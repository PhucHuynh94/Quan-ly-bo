<?php

/**
 * @author dinhnhatbang <dinhnhatbang@gmail.com>
 */

namespace Cowtype;

class Routes
{

    public function init($router)
    {
        $router->add('/cowtype', array(
            'module'     => 'cowtype',
            'controller' => 'index',
            'action'     => 'index',
        ))->setName('cowtype');

        return $router;

    }

}