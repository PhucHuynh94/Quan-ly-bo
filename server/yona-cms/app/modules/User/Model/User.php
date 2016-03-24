<?php
/**
 * @copyright Copyright (c) 2011 - 2014 Aleksandr Torosh (http://wezoom.com.ua)
 * @author Aleksandr Torosh <webtorua@gmail.com>
 */

namespace User\Model;

use Phalcon\Mvc\Model\Validator\Uniqueness;
use stdClass;

class User extends \Phalcon\Mvc\Model
{

    public function getSource()
    {
        return "user";
    }

    private $id;
    private $phoneNumber;
    private $password;
    private $email;
    private $name;
    private $address;
    private $birthday;
    private $gender;
    private $role;
    private $active = 0;

    public static $roles = [
        'farmer' => 'Nông dân',
        'veterinarians'     => 'Bác sĩ thú y',
        'scientist'      => 'Nhà khoa học',
        'traders' => 'Thương lái'
    ];

    public function initialize()
    {
        require_once __DIR__ . '/../../../../vendor/password.php';
    }

    public function setCheckboxes($post)
    {
        $this->setActive(isset($post['active']) ? 1 : 0);
    }

    public function validation()
    {
        $this->validate(new Uniqueness(
            [
                "field"   => "phoneNumber",
                "message" => $this->getDi()->get('helper')->translate("Số điện thoại không được bỏ trống")
            ]
        ));

        $this->validate(new Uniqueness(
            [
                "field"   => "password",
                "message" => $this->getDi()->get('helper')->translate("Mật khẩu không được bỏ trống")
            ]
        ));

        return $this->validationHasFailed() != true;

    }

    public function getAuthData()
    {
        $authData = new stdClass();
        $authData->id = $this->getId();
        $authData->admin_session = false;
        $authData->phoneNumber = $this->getPhoneNumber();
        $authData->email = $this->getEmail();
        $authData->name = $this->getName();
        return $authData;
    }

    public static function getRoleById($id)
    {
        $role = self::findFirst([
            'conditions' => 'id = :id:',
            'bind'       => ['id' => $id],
            'columns'    => ['role'],
            'cache'      => [
                'key'      => HOST_HASH . md5('Admin\Model\User::getRoleById::' . $id),
                'lifetime' => 60,
            ]
        ]);
        if ($role) {
            return $role->role;
        } else {
            return 'guest';
        }

    } 

    public function isActive()
    {
        if ($this->active) {
            return true;
        }
    }

    public function checkPassword($password)
    {
        if (password_verify($password, $this->password)) {
            return true;
        }
    }      

    public function getId()
    {
        return $this->id;
    }


    private function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }


    private function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }


    public function setPassword($password)
    {
        if ($password) {
            $this->password = password_hash($password, PASSWORD_DEFAULT);
        }
    }

    public function getEmail()
    {
        return $this->email;
    }


    private function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }


    private function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getAddress()
    {
        return $this->address;
    }


    private function setAddress($address)
    {
        $this->address = $address;
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

    public function getRole()
    {
        return $this->role;
    }


    private function setRole($role)
    {
        $this->role = $role;
        return $this;
    }

    public function getActive()
    {
        return $this->active;
    }


    private function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    public function getRoles()
    {
        return $this->roles;
    }


    public function setRoles($roles)
    {
        $this->roles = $roles;
        return $this;
    }
}
