<?php
/**
 * @copyright Copyright (c) 2011 - 2014 Aleksandr Torosh (http://wezoom.com.ua)
 * @author Aleksandr Torosh <webtorua@gmail.com>
 */

namespace Cow\Model;

use Phalcon\Mvc\Model\Validator\Uniqueness;
use stdClass;

class Cow extends \Phalcon\Mvc\Model
{

    public function getSource()
    {
        return "cow";
    }
    
    private $id;
    private $userId;
    private $birthday;
    private $gender;
    private $type;
    private $target;       
    private $isBorn;

    public function getId()
    {
        return $this->id;
    }


    private function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getUserId()
    {
        return $this->userId;
    }


    private function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    public function getBirthday()
    {
        return $this->birthday;
    }


    private function setBirthday($birthday)
    {
        $this->birthday = $birthday;
        return $this;
    }

    public function getGender()
    {
        return $this->gender;
    }


    private function setGender($gender)
    {
        $this->gender = $gender;
        return $this;
    }

    public function getType()
    {
        return $this->type;
    }


    private function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    public function getTarget()
    {
        return $this->target;
    }


    private function setTarget($target)
    {
        $this->target = $target;
        return $this;
    }

    public function getIsBorn()
    {
        return $this->isBorn;
    }


    private function setIsBorn($isBorn)
    {
        $this->isBorn = $isBorn;
        return $this;
    }
}
