### nginx安装

1. 准备依赖包

   ```shell
   sudo apt-get install libpcre3 libpcre3-dev 
   sudo apt-get install openssl libssl-dev
   sudo apt-get install zlib1g-dev
   sudo apt-get  install  build-essential
   ```

2. 准备nginx用户

   ```she
   useradd -M -s /sbin/nologin nginx
   ```

3. 源码编译与安装

   ```shel
   ./configure --prefix=/usr/local/nginx --with-http_stub_status_module --with-http_ssl_module --with-http_random_index_module --with-http_sub_module
   make && make install
   ```

4. 设置配置文件

   ```shel
   user nginx;
   ```

5. 服务管理

   ```shel
   #检测配置语法
   /usr/local/nginx/sbin/nginx -t
   #启动服务
   /usr/local/nginx/sbin/nginx
   #重载服务
   /usr/local/nginx/sbin/nginx -s reload
   pkill -HUP nginx
   #关闭服务
   /usr/local/nginx/sbin/nginx -s stop
   pkill nignx
   ```

6. 进程管理

   ```shel
   pstree | grep nginx
   ps -ef | grep nginx
   ps aux | grep nginx
   ```

   

