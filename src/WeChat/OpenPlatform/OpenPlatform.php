<?php
/**
 * Created by PhpStorm.
 * User: eValor
 * Date: 2019-03-18
 * Time: 10:18
 */

namespace ESD\Plugins\WeChat\OpenPlatform;

use ESD\Plugins\WeChat\Config\OpenPlatformConfig;

class OpenPlatform
{
    private $config;

    private $auth;

    function __construct(?OpenPlatformConfig $config = null)
    {
        if (is_null($config)) {
            $config = new OpenPlatformConfig;
        }
        $this->config = $config;
    }

    /**
     * authorization
     * @return Auth
     */
    function auth()
    {
        if (!isset($this->auth)) {
            $this->auth = new Auth($this);
        }
        return $this->auth;
    }

    /**
     * ConfigGetter
     * @return OpenPlatformConfig
     */
    public function getConfig(): OpenPlatformConfig
    {
        return $this->config;
    }
}