## tp异常处理

### 关于抛出异常

在接口的设计中，接口返回的数据是非常重要的，例如无法避免的500等等。同时还有一个极大的问题，就是在新增模块中，如需要一个es分词查找，在添加、删除索引的时候，是非常容易导致抛出错误异常

### 方案1

```php
public function addIndex($data){
    $params = [
        'index' => 'show',
        'type'  => 'store',
        'body'  => $data
    ];
    try{
        $this->client->index($params)
    }catch(\Exception $ex){
        echo '参数错误的异常'
    }
}
```

**这种方法非常不利于某个错误的处理**

### 方案2

```php
public function addIndex($data){
    $params = [
        'index' => 'show',
        'type'  => 'store',
        'body'  => $data
    ];
    try{
        $this->client->index($params);
    }catch(BadRequest400Exception $e){
        $msg = json_decode($e->getMessage(), true);
        return $msg;
    }catch(BadMethodCallException $e){
        return '方法不存在'.$e->getMessage();
    }catch(\Excetpint $e){
        return '系统异常';
    }
}
```

**代码过于冗余**

### 方案3(tp5)

**定义个异常处理接管，重写render方法，这个方法主要是抛出一个响应异常**

```php
//异常处理接管的代码
namespace app\common\exception;
use Exception;
use think\exception\Handle;
use think\Response;

class Handler extends Handle{
    //这里写需要进行捕获的错误加载类库
    protected $handler_exceptons = [
        '\app\common\excepton\EsearchHandler',
        '\app\common\exception\SystemHandler',
    ];
    //重写render方法
    public function render(Exception $e){
        try{
            //系统抛出的
            $isDebug = config('app.ap_debug');
            if(!$request()->isAjax() || $isDebug){
                return parent::render($e);
            }
            //错误信息，用于写入日志
            $errorInfo = [
                'code' => $e->getCode(),
                'line' => $e->getLine(),
                'message' => $e->getMessage(),
                'file' => $e->getFile()
            ];
            //捕获错误处理异常
            return $this->handler_exception($e, $errorInfo);
        }catch(\Exception $e){
            return parent::render($e);
        }
    }
}
```

* handler_exceptions：定义需要捕获异常的错误处理模块
* reander：重写错误处理异常
  * errorInfo：用来分发给各个子模块异常，用来需要的地方打印日志
  * catch：这个的用处不大, 主要是这个如果出现错误的话,自己处理不了, 就交给tp自带的异常处理去处理，return parent::render($exception);执行父方法
* handler_exception：用来遍历执行是否需要捕获的错误的模块，依次加载，当真实的时候会继承Response方法

### 功能模块的异常处理

```php
namespace app\common\exception;
class EsearchHandler extends BaseExcepton implements CustomExceptionInterface{
    public function handler($e, $errInfo){
        $e_class =get_class($e);
        switch($e_class){
            case "Elasticsearch\Common\Exceptions\UnexpectedValueException":
                  return $this->showMsg($e->getMessage(),$errorInfo);
                  break;
            case "Elasticsearch\Common\Exceptions\BadRequest400Exception":
                  return $this->showMsg($e->getMessage(),$errorInfo);
                  break;
        }
    }
}
```

