<?php

/**
 * @author dinhnhatbang <dinhnhatbang@gmail.com>
 */

namespace Cow;

class Routes
{

    public function init($router)
    {
        $router->add('/cow', array(
            'module'     => 'cow',
            'controller' => 'index',
            'action'     => 'index',
        ))->setName('cow');

        return $router;

    }

}