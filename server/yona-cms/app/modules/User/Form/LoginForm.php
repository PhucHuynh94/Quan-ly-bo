<?php

/**
 * LoginForm
 * @copyright Copyright (c) 2011 - 2014 Aleksandr Torosh (http://wezoom.com.ua)
 * @author Aleksandr Torosh <webtorua@gmail.com>
 */

namespace User\Form;

use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Password;
use Phalcon\Validation\Validator\PresenceOf;

class LoginForm extends \Phalcon\Forms\Form
{

    public function initialize()
    {
        $phoneNumber = new Text('phoneNumber', array(
            'required' => true,
        ));
        $phoneNumber->addValidator(new PresenceOf(array('message' => 'Số điện thoại không được bỏ trống')));
        $this->add($phoneNumber);

        $password = new Password('password', array(
            'required' => true,
        ));
        $password->addValidator(new PresenceOf(array('message' => 'Mật khẩu không được bỏ trống')));
        $this->add($password);

    }

}
