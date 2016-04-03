<?php

/**
 * @author dinhnhatbang <dinhnhatbang@gmail.com>
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
        $authData->phoneNumber = $this->getPhoneNumber();
        $authData->email = $this->getEmail();
        $authData->name = $this->getName();        
        $authData->role = $this->getRole();
        $authData->birthday = $this->getBirthday();
        $authData->address = $this->getAddress();
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
        if ($this->active == 1) {
            return true;
        }
        return false;
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


    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }


    public function setPhoneNumber($phoneNumber)
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


    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }


    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getAddress()
    {
        return $this->address;
    }


    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    public function getBirthday()
    {
        return $this->birthday;
    }


    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
        return $this;
    }

    public function getGender()
    {
        return $this->gender;
    }


    public function setGender($gender)
    {
        $this->gender = $gender;
        return $this;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function getRoleTitle()
    {
        if (array_key_exists($this->role, self::$roles)) {
            return self::$roles[$this->role];
        }
    }

    public function setRole($role)
    {
        $this->role = $role;
        return $this;
    }

    public function getActive()
    {
        return $this->active;
    }


    public function setActive($active)
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
