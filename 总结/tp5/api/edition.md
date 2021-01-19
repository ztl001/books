## api版本控制的几种思路

### 通过子域名

通过2个模块或应用来实现，对于架构改变比较大的API版本通常会这样选择

```
api
├─application           
│  ├─v1  
│  │  ├─controller 
│  │  ├─model 
│  │  ├─config
│  │  └─ ...            
│  ├─v2
│  │  ├─controller
│  │  ├─model           
│  │  ├─config  
│  │  └─ ...     
│   ... 
```

请求方式

```
GET https://api.tp5.com/v1/user/1
GET https://api.tp5.com/v2/user/1
```

### 通过请求参数

对于刚开始没有做好版本规划，后期迭代维护过程中增加了新的版本，考虑到架构的改造成本

```
GET https://api.tp5.com/user/1
GET https://api.tp5.com/user/1?version=v2
```

### 通过路由

通常会选择在URL地址中增加版本标识参数，这种方式便于调试。

对于API应用来说，更建议采用**单模块设计 + 多级控制器**,目录结构如下:

```
api
├─application          
│  ├─controller
│  │  ├─v1
│  │  ├─v2
│  │  └─ ...            
│  ├─model
│   ... 
```

路由规则定义如下：

```
Route::get(':version/user/:id',':version.User/read')
```

```
GET https://api.tp5.com/v1/user/1
GET https://api.tp5.com/v2/user/1
```

### 通过头信息

最新的规范趋向于通过头信息来定义版本，优势在于从历史版本迭代更新的时候不需要改变URL地址

1. 使用自定义请求头如**api-version**控制版本

   ```
   GET https://api.tp5.com/user/1
   api-version:v2
   ```

   路由规则定义

   ```
   $version = Request::header('api-version') ? : 'v1';
   Route::get('user/:id',$version.'.User/read');
   ```

2. 通过**Accept**头信息来处理(好处是可以设置接口输出格式)

   ```
   GET https://api.tp5.com/user/1
   Accept: application/vnd.tp5.v2+json
   ```

   

