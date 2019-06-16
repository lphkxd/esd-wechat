<?php

namespace ESD\Plugins\We\examples;

use ESD\Plugins\EasyRoute\Annotation\RestController;
use ESD\Plugins\EasyRoute\Controller\EasyController;

/**
 * @RestController("/")
 * Class Index
 * @package ESD\Plugins\EasyRoute
 */
class Index extends EasyController
{

    /**
     * @RestController("wx")
     * Class Index
     * @package ESD\Plugins\We
     */
    public function wx()
    {

        p(123123);


    }


    /**
     * 找不到方法时调用
     * @param $methodName
     * @return mixed
     */
    protected function defaultMethod(?string $methodName)
    {
        // TODO: Implement defaultMethod() method.
    }
}