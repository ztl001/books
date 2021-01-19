## validate自定义验证规则

### 在TP5中定义$rule验证规则有两种方式

```php
//方式一
$rule = [
    'name' => '', //会导致出现result未定义错误
    'age'  => 'number|between:1,120'
];
//方式二
$rule = [
    'name' => ['require','max'=>25],
    'age'  => ['number','between'=>'1,120']
];
```

### 方式一：自定义验证规则

```php
$rule = [
    'name' => 'require|max:25|checkName',
    'age'  => 'number|between:1,120'
];
protected function checkName($val){
 	//$val是name的值   
}
```

### 方式二：自定义验证规则

```php
$rule = [
    'name' => ['require','max'=>25,'checkName'=>'$rule参数'],
    'age'  => ['number','between'=>'1,120'],
    'email'=> ['require','checkUserEmial'=>'qq.com']
];
protected function checkName($val,$rule){
    //$val是name的值，$rule为上面的$rule参数
}
protected function checkUserEmail($val,$rule){
    $res = preg_match('/^\w+([-+.]\w+)*@'.$rule.'$/',$val);
    if(!$res){
        return '邮箱只能是'.$rule.'域名';
    }else{
        return true;
    }
}
```

