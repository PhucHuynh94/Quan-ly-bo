<?php

/**
 * UserController
 * @copyright Copyright (c) 2011 - 2014 Aleksandr Torosh (http://wezoom.com.ua)
 * @author Aleksandr Torosh <webtorua@gmail.com>
 */

namespace User\Controller;

use Application\Mvc\Controller;
use User\Model\User;
use User\Form\LoginForm;
use User\Form\UserForm;
use Phalcon\Mvc\View;
use Phalcon\Http\Response;

class ApiController extends Controller
{
 
	private $response;
	public function initialize()
	{
		$this->view->disable();
		$this->response = new \Phalcon\Http\Response();
		$this->response->setHeader("Content-Type", "application/json; charset=utf-8");
	}

	public function indexAction()
	{
		
	}    
	public function loginAction()
	{
		if ($this->request->isPost()) {
			$form = new LoginForm();
			if ($form->isValid($this->request->getPost())) {
				$phoneNumber = $this->request->getPost('phoneNumber', 'string');
				$password = $this->request->getPost('password', 'string');
				$user = User::findFirst("phoneNumber='$phoneNumber'");
				if ($user) {
					if ($user->checkPassword($password)) {
						if ($user->isActive()) {
							$this->session->set('auth', $user->getAuthData());
							$this->response->setStatusCode(200, "OK");
							$this->response->setContent(json_encode(array(
								'status'=>'Đăng nhập thành công',
								'data' => $this->session->get('auth'),
							)));
						}else{
							$this->response->setStatusCode(401, "Unauthorized");
							$this->response->setContent(json_encode(array(
								'status' => 'Tài khoản đã bị khóa'
							)));
						}
					}else{
						$this->response->setStatusCode(401, "Unauthorized");
						$this->response->setContent(json_encode(array(
							'status' => 'Mật khẩu không chính xác'
						)));
					}
				}else{
					$this->response->setStatusCode(401, "Unauthorized");
					$this->response->setContent(json_encode(array(
						'status' => 'Người dùng không tồn tại'
					)));
				}
			}
			$this->response->send();
		}
	}
	public function signupAction()
	{
        if ($this->request->isPost()) {
        	$model = new User();
        	$form = new UserForm();
        	$form->initAdding();
            $model = new User();
            $post = $this->request->getPost();
            $form->bind($post, $model);
            if ($form->isValid()) {
                $model->setCheckboxes($post);
                if ($model->save()) {
                    $this->response->setStatusCode(201, "Created");
					$this->response->setContent(json_encode(array(
						'status'=>'Tạo tài khoản thành công',
					)));
                } else {
                    $this->response->setStatusCode(406, "Not Acceptable");
					$this->response->setContent(json_encode(array(
						'status'=>'Không thể tạo tài khoản',
					)));	                    
                }
            } else {
            	$this->response->setStatusCode(406, "Not Acceptable");
        		$this->response->setContent(json_encode(array(
					'status'=>'Dữ liệu không chính xác',
				)));
            }
        	$this->response->send();
        }
	}
	public function logoutAction()
	{
		if ($this->request->isPost()) {
            $this->session->remove('auth');
           	$this->response->setStatusCode(200, "OK");
			$this->response->setContent(json_encode(array(
				'status'=>'Đăng xuất thành công',
			)));           	
        	$this->response->send();
        }
	}

}
