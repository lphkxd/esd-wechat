<?php
/**
 * File: WeChatPlugin.php
 * User: 4213509@qq.com
 * Date: 2019-06-15
 * Time: ${Time}
 **/

namespace ESD\Plugins\WeChat;

use ESD\Core\Context\Context;
use ESD\Core\PlugIn\AbstractPlugin;
use ESD\Core\PlugIn\PluginInterfaceManager;

class WeChatPlugin extends AbstractPlugin
{
    /**
     * @var WeChatConfig
     */
    private $wechatConfig;

    /**
     * 获取插件名字
     * @return string
     */
    public function getName(): string
    {
        return "WeChat";
    }

    /**
     * CachePlugin constructor.
     * @param WechatConfig|null $securityConfig
     * @throws \DI\DependencyException
     * @throws \ReflectionException
     * @throws \DI\NotFoundException
     */
    public function __construct(?WechatConfig $wechatConfig = null)
    {
        parent::__construct();
        if ($wechatConfig == null) {
            $wechatConfig = new WechatConfig();
        }
        $this->wechatConfig = $wechatConfig;
    }

    /**
     * @param PluginInterfaceManager $pluginInterfaceManager
     * @return mixed|void
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     * @throws \ESD\Core\Exception
     * @throws \ReflectionException
     */
    public function onAdded(PluginInterfaceManager $pluginInterfaceManager)
    {
        parent::onAdded($pluginInterfaceManager);
    }

    /**
     * @param Context $context
     * @return mixed|void
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     * @throws \ESD\Core\Plugins\Config\ConfigException
     */
    public function init(Context $context)
    {
        parent::init($context);
        $this->wechatConfig->merge();
    }

    /**
     * 在服务启动前
     * @param Context $context
     * @return mixed
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     * @throws \ESD\Core\Plugins\Config\ConfigException
     */
    public function beforeServerStart(Context $context)
    {
        $this->wechatConfig->merge();
    }

    /**
     * 在进程启动前
     * @param Context $context
     * @return mixed
     */
    public function beforeProcessStart(Context $context)
    {
        $this->ready();
    }
}