<?php

/**
 * Routes
 * @copyright Copyright (c) 2011 - 2014 Aleksandr Torosh (http://wezoom.com.ua)
 * @author Aleksandr Torosh <webtorua@gmail.com>
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