### tp5计划任务

1. 利用tp自带的think自定义command功能，在application/模块/新建一个command文件夹/Crontab.class.php，其中的class可以省略，假如在配置的app.php中关闭class_suffix，修改文件名为Crontab.php

```php
<?php 
namespace app\api\command;
use think\console\Command;
use think\console\Input;
use think\console\Output;
class Crontab extends Command{
    protected function configure(){
        $this->setName('Crontab')->setDescription('计划任务 Crontab');
    }
    protected function execute(Input $input, Output $output){
        $output->writeln('Date crontab job start...');
        //这里写计划任务列表集
        $this->updateUser();
        //这里写计划任务列表集
        $output->writeln('Date crontab job edn...');
    }
    private function updateUser(){}
}
```

2. 配置command.php文件，位置在application/command.php

```php
return ['app\api\command\Crontab'];
```

3. 写一个Crontab.sh文件来执行

```shell
#!/bin/bash
cd /data/www/tp5
/usr/bin/php think Crontab
```



