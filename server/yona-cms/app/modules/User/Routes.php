<?php

/**
 * @author dinhnhatbang <dinhnhatbang@gmail.com>
 */

namespace User;

class Routes
{

    public function init($router)
    {
        $router->add('/user', array(
            'module'     => 'user',
            'controller' => 'index',
            'action'     => 'index',
        ))->setName('user');

        return $router;

    }

}