# EasySwooleDistributed WeChat Plugin

* EasySwooleDistributed WeChat 是基于 [EasySwoole WeChat](https://github.com/easy-swoole/wechat) 重构，优化并完善；
* 我们鼓励大家使用 composer 来管理您的第三方库，方便后期更新操作；


EasySwoole Distributed WeChat Plugin 是一个基于 Swoole 4.x 全协程支持的微信SDK库，告别同步阻塞，轻松编写高性能的微信公众号/小程序/开放平台业务接口
>* 微信官方文档：http://mp.weixin.qq.com/wiki
>* 开放平台文档：https://open.weixin.qq.com
>* 商户支付文档：https://pay.weixin.qq.com/wiki/doc/api/index.html


## 获取实例

添加 WeChatPlugin 插件

```php
 app/Application 的 main 中添加插件

 public static function main()
  {
    $application = new GoApplication();
    $application->addPlug(new WeChatPlugin());
    $application->run();
  }
```



 在开始操作之前需要获取一个实例，程序中使用以下方式获取实例
```yaml
wechat:
  official_account_config:  #公众号配置
    app_id: 111111111
    app_secret: 22222222222222222222
    ....
  mini_program_config:  #小程序配置
    app_id: 111111111
    app_secret: 22222222222222222222
  open_platform_config: #开放平台配置
    app_id: 111111111
    app_secret: 22222222222222222222
```


 在开始操作之前需要获取一个实例，程序中使用以下方式获取实例
```php
 use GetWeChat;
 //获取公众号实例
 $wechat = $this->getOfficialAccount();
```

## 异常捕获

在调用方法时，如果传递了无效的参数或者发生网络异常，将会抛出 ***ESD\Plugins\WeChat\Exception\RequestError*** 或者 ***ESD\Plugins\WeChat\Exception\OfficialAccountError*** 类型的异常，开发者需要手工捕获该类异常进行处理，类似这样：

```php

 use ESD\Plugins\WeChat\Exception\OfficialAccountError;
 use ESD\Plugins\WeChat\Exception\RequestError;

 try {
     $wechat->officialAccount()->ipList();
 } catch (RequestError $requestError){
    
 } catch (OfficialAccountError $error){
            
 }
 
```


## 微信公众号

微信公众号沙箱: https://mp.weixin.qq.com/debug/cgi-bin/sandbox?t=sandbox/login


Copyright
--
* wechat-plugin 基于`MIT`协议发布，任何人可以用在任何地方，不受约束
* wechat-plugin 部分代码来自互联网，若有异议，可以联系作者进行删除