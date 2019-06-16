<?php

use ESD\Plugins\Aop\AopPlugin;
use ESD\Plugins\Cache\CachePlugin;
use ESD\Plugins\WeChat\exampleClass\TestPort;
use ESD\Plugins\WeChat\WeChatPlugin;
use ESD\Server\Co\ExampleClass\DefaultServer;


function p($val, $title = null, $starttime = '')
{
    print_r('[ ' . date("Y-m-d H:i:s") . ']:');
    if ($title != null) {
        print_r("[" . $title . "]:");
    }
    print_r($val);
    /* if ($starttime != '') {
         $endtime = explode(' ', microtime());
         $thistime = $endtime[0] + $endtime[1] - ($starttime[0] + $starttime[1]);
         $thistime = round($thistime, 3);
         print_r(' -- 执行耗时' . $thistime . '秒。');
     }
    print_r("\r\n");*/
    print_r("\r\n");

}

require __DIR__ . '/../vendor/autoload.php';
define("ROOT_DIR", __DIR__ . "/..");
define("RES_DIR", __DIR__ . "/resources");


$server = new DefaultServer(null, TestPort::class);


$server->getPlugManager()->addPlug(new AopPlugin());
$server->getPlugManager()->addPlug(new CachePlugin());
$server->getPlugManager()->addPlug(new WeChatPlugin());
//配置
$server->configure();
//启动
$server->start();