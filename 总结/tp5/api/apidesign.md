## api接口设计

### 接口参数定义

| 公共参数  |     含义     |                         参数的意义                         |
| :-------: | :----------: | :--------------------------------------------------------: |
| timestamp | 毫秒级时间戳 | 1.客户端的请求时间 2.后端可以做请求过期验证 3.参加签名算法 |
|  app_key  |   签名公钥   |        签名算法公钥，后端通过公钥可以查到对应是私钥        |
|   sign    |   接口签名   |        通过请求的参数和定义好的签名算法生成接口签名        |
|    did    |    设备ID    |  设备的唯一标示 1.数据收集 2.便于追踪问题 3.消息推送标示   |

### 接口安全性

#### 过期验证

通过时间戳进行验证

```php
if(microtime(true) * 1000 - $_REQUEST['timestamp'] > 5000) {
    throw new \Exception(401, 'Expird request');
}
```

#### 签名验证

通过配对私钥的加密算法产生签名，请求中携带签名进行鉴权

```php
$params = ksort($_REQUEST);
unset($params['sign']);
$sign = md5(sha1(impload('-', $params).$_REQUEST['app_key']));
if($sign !== $_REQUEST['sign']){
    throw new \Exception(401, 'Invalid sign');
}
```

#### 重放攻击

防止一次相同请求多次攻击API服务器

```php
$key = md5("{$_REQUEST['REQUEST_URI']}-{$_REQUEST['timestamp']}-{$_REQUEST['noise']}-{$_REQUEST['did']}");
if ($redisInstance->exists($key)) {
	throw new \Exception(401, 'Repeated request');
}
```

#### 限流

防止同一IP频繁访问API服务器

```php
$key = md5("{$_REQUEST['REQUEST_URI']}-{$_REQUEST['REMOTE_ADDR']}-{$_REQUEST['did']}");
if ($redisInstance->get($key) > 60) {
	throw new \Exception(401, 'Request limit');
}
$redisInstance->incre($key);
```

#### 转义

防止注入，xss等攻击

```php
$username = htmlspecialchars($_REQUEST['username']);
```

### 接口的状态码

#### 业务操作正确码

```shell
# 1xx 2xx 3xx开头，后拼接3位
# 001 ~ 099 表示系统状态；100 ~ 199 表示授权业务；200 ~ 299 表示用户业务
200 + 001 => 200001,也就是001~009个编号可以用来表示业务成功的情况
```

#### 业务操作错误码

```shell
#400~499开头，后拼接3位
400 + 001 => 400001
```

#### 服务端错误码

```shell
#500~599开头，后拼接3位
500 + 001 => 500001
```

#### 公用状态码

```shell
200 -> 正常

400 -> 缺少公共必传参数或者业务必传参数

401 -> 接口校验失败 例如签名

403 -> 没有该接口的访问权限

499 -> 上游服务响应时间超过接口设置的超时时间

500 -> 代码错误

501 -> 不支持的接口method

502 -> 上游服务返回的数据格式不正确

503 -> 上游服务超时

504 -> 上游服务不可用
```

