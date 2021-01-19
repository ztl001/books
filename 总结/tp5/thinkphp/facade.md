## facade用法

### 什么是Facade、为什么需要、有什么好处

#### 专业解释

门面模式又称外观模式，用于为子系统中的一组接口提供一个一致的界面。门面模式定义了一个高层接口，这个接口使得子系统更加容易使用：引入门面角色之后，用户只需要直接与门面角色交互，用户与子系统之间的复杂关系由门面角色来实现，从而降低了系统的耦合度。

```php
namespace app\common;
class Test{
    public function hello($name){
        return 'hello,'.$name;
    }
}
```

我们要用这个类

```php
$test = new \app\common\Test;
echo $test->hello('ztl');
```

这样调用类，但是如果调用的次数多了，自己每次调用这方法都要创建类从写法上就觉得不是很好而我们更多的是想直接以静态通过类名::方法（） 的方式调用，并且开发速度不快以及不够优雅。

```php
echo \app\facade\Test::hello('ztl');
```

### thinkphp实例

#### 创建一个app\facade\UserUtil.php的门面代理类

```php
namespace app\facade;
use think\Facade;
class UserUtil extends Facade{
    protected static function getFacadeclass(){
        return \app\util\UserUtil::class;
    }
}
```

#### 在控制器中使用

```php
namespace app\index\controller;
use app\facade\UserUtil;
class Index{
    public function index(){
        return UserUtil::index();
    }
}
```







