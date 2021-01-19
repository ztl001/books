## php安装redis扩展

### redis扩展下载地址

```shell
//Linux版地址：
https://pecl.php.net/package/redis
//Windows版地址：
https://windows.php.net/downloads/pecl/releases/redis
```

### win下载完成后，将该文件放到php扩展目录ext文件夹中

```shell
cd D:\laragon\bin\php\php-7.2.19-Win32-VC15-x64\ext
```

### 打开php.ini开启redis扩展模块

```shell
extendsion=php_redis.dll
```

### linux下载完成后

```shell
tar -zcvf redis-5.0.tar.gz
cd redis-5.0
/usr/local/php/bin/phpize
./configure --with-php-config=/usr/local/php/bin/php-config
make && make install
```



