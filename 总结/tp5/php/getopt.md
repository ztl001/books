## php--getopt

### php中的getopt是用于接收cmd参数的时候用的

```shell
array getopt(string $options [,array $longopts])
```

### 简单实例

```php
$options = getopt("f:hp:");
var_dump($options);
```

使用命令 php script.php -f test -hp demo 

```php
Array
(
    [f] => test
    [h] => 
    [p] => demo
)
```



