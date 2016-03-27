<?php

/**
 * AdminUser
 * @copyright Copyright (c) 2011 - 2014 Aleksandr Torosh (http://wezoom.com.ua)
 * @author Aleksandr Torosh <webtorua@gmail.com>
 */

namespace Cow\Form;

use Cow\Model\Cow;
use Application\Form\Form;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Email;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Check;
use Phalcon\Validation\Validator\Email as ValidatorEmail;
use Phalcon\Validation\Validator\PresenceOf;

class CowForm extends Form
{

    public function initialize()
    {
        $userId = new Text('userId');
        $userId->setLabel('userId');
        $this->add($userId);
        
        $birthday = new Text('birthday');
        $birthday->setLabel('birthday');
        $this->add($birthday);

        $gender = new Slect('gender');
        $gender->setLabel('gender');
        $this->add($gender);        

        $gender = new Slect('gender');
        $gender->setLabel('gender');
        $this->add($gender); 

    }

}
