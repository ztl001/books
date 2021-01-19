## 消息队列--beanstalkd

### 简介

beanstalk是一个轻量级、分布式的内存队列系统

### 概念

* Tube

  是一个管道的概念，管道就是指队列，一个队列系统

* Job

  任务的概念，就是指消息，它指存储在队列中的每一个具体成员。生产者生成job，将它放入特定的tube中，在由消费者监听特定的tube，从中接收job

### 特性

* **优先级**

  设定job优先级之后，可以让该job在一堆job中，更优先被消费者接收

* **延迟**

  beanstalkd支持为job设置延迟接收的属性，通常来讲，生产者往消息队列中放入一条消息，只要有消费者空闲，就会被立马接收。但beanstalkd的延迟特性，可以让job在指定时间才被接收。

* **预留**

  beanstalkd支持设置job的状态为预留，处理预留状态时，它不允许被消费，也不会被消费者接收

* **持久性**

  beanstalkd还可通过日志实现持久性，这样我们可以不必担心数据丢失，提升消息可靠性

* **超时重发**

  在消费者接收到job之后，没能在一定时间内处理完毕，此时，beanstalkd会认为该job处理失败，将它从reserved的状态重新调整到ready状态。

### 任务状态

* ready：代表job随时可以被消费者接收
* reserved：指job已被消费者接收，但消费者那边还没有给出反馈，它不会被消费者接收
* delayed：指job处于延迟状态，等时间到了会变成ready
* buried：指job处于预留状态
* deleted：指job已经从tube中被删除

### 安装

我们只需要下载你需要的版本的beanstalkd压缩包到，在解压，在编译安装，就行

```shell
wget https://github.com/beanstalkd/beanstalkd/archive/v1.10.zip
tar xzvf beanstalkd-1.10.zip
cd beanstalkd-1.10
make && make install
beanstalkd -v
```

启动beanstalkd的服务

```shell
beanstalkd -l 0.0.0.0 -p 11300 -b /log/beanstalkd/binlog -F
```

* **-l**  指绑定ip，默认 127.0.0.1
* **-p** 指绑定的端口，默认 11300
* **-b** 指开启binlog进行持久化
* **-F** 不把内存文件写入磁盘

### 分布式

beanstalkd的分布式，需要通过客户端自己实现。即：你有10台消息队列服务器，此时，你需要全部部署上beanstalkd，并且自己编写分布式的中间代码。

### 常见问题

```
https://github.com/beanstalkd/beanstalkd/wiki/FAQ
```





