<?php

/**
 * AdminUser
 * @copyright Copyright (c) 2011 - 2014 Aleksandr Torosh (http://wezoom.com.ua)
 * @author Aleksandr Torosh <webtorua@gmail.com>
 */

namespace User\Form;

use User\Model\User;
use Application\Form\Form;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Email;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Check;
use Phalcon\Validation\Validator\Email as ValidatorEmail;
use Phalcon\Validation\Validator\PresenceOf;

class UserForm extends Form
{

    public function initialize()
    {
        $this->add(
            (new Text('phoneNumber', [
                'required' => true,
            ]))->setLabel('Số điện thoại')
        );

        $this->add(
            (new Password('password'))
                ->setLabel('Mật khẩu')
        );       

        $this->add(
            (new Email('email'))
                ->setLabel('Email')
        );

        $this->add(
            (new Text('name'))
                ->setLabel('Tên')
        );

        $this->add(
            (new Select('role', User::$roles))
                ->setLabel('Role')
        );

        $this->add(
            (new Check('active'))
                ->setLabel('Kích hoạt')
        );
    }

    public function initAdding()
    {
        $password = $this->get('password');
        $password->setAttribute('required', true);
        $password->addValidator(new PresenceOf([
            'message' => 'Password is required',
        ]));

    }

}
