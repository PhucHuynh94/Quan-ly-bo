<?php

/**
 * @author dinhnhatbang <dinhnhatbang@gmail.com>
 */

namespace User\Controller;

use Application\Mvc\Controller;
use User\Model\User;
use User\Form\LoginForm;
use User\Form\UserForm;
use Phalcon\Http\Response;

class ApiController extends Controller
{
 
	private $response;

	private $status = [
		'success' => [
			'U21000' => [
				'id' => 'U21000',
				'name' => 'Tạo tài khoản người dùng thành công.',
			],
			'U22000' => [
				'id' => 'U22000',
				'name' => 'Đăng nhập thành công.',
			],
			'U23000' => [
				'id' => 'U23000',
				'name' => 'Sửa thông tin người dùng thành công.',
			],
			'U24000' => [
				'id' => 'U24000',
				'name' => 'Xoá người dùng thành công.',
			],
			'U25000' => [
				'id' => 'U25000',
				'name' => 'Đăng xuất thành công.',
			],			
		],
		'fail' => [	
			'U31000' => [
				'id' => 'U31000',
				'name' => 'Tài khoản người dùng đã tồn tại, không thể tạo tài khoản người dùng.',
			],
			'U31001' => [
				'id' => 'U31001',
				'name' => 'Dữ liệu không chính xác, không thể tạo tài khoản người dùng.',
			],			
			'U32000' => [
				'id' => 'U32000',
				'name' => 'Tài khoản người dùng không tồn tại, không thể đăng nhập.'
			],
			'U32001' => [
				'id' => 'U32001',
				'name' => 'Mật khẩu không chính xác, không thể đăng nhập.',
			],
			'U32002' => [
				'id' => 'U32002',
				'name' => 'Tài khoản người dùng đã bị khoá, không thể đăng nhập, vui lòng liên hệ quản trị viên.',
			]			
		],
		'sysFail' => [
			'U41000' => [
				'id' => 'U41000',
				'name' => 'Có lỗi xảy ra, không thể tạo tài khoản người dùng.',
			],
			'U42000' => [
				'id' => 'U42000',
				'name' => 'Có lỗi xảy ra, không thể đăng nhập.',
			],
			'U43000' => [
				'id' => 'U43000',
				'name' => 'Có lỗi xảy ra, không thể sửa thông tin người dùng.',
			],
			'U44000' => [
				'id' => 'U44000',
				'name' => 'Có lỗi xảy ra, không thể xoá người dùng.',
			],
			'U45000' => [
				'id' => 'U45000',
				'name' => 'Có lỗi xảy ra, không thể đăng xuất.',
			]												
		]
	];

	public function initialize()
	{
		$this->view->disable();
		$this->response = new \Phalcon\Http\Response();
		$this->response->setHeader("Content-Type", "application/json; charset=utf-8");
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
							// Đăng nhập thành công.
							$this->session->set('auth', $user->getAuthData());
							$this->response->setContent(json_encode(array( 
								'statusId'=> $this->status['success']['U22000']['id'],
								'statusName'=> $this->status['success']['U22000']['name'],
								'data' => $this->session->get('auth'),
							)));
						}else{
							// Tài khoản người dùng đã bị khoá, không thể đăng nhập
							$this->response->setContent(json_encode(array(
								'statusId'=> $this->status['fail']['U32002']['id'],
								'statusName'=> $this->status['fail']['U32002']['name'],
							)));
						}
					}else{
						// Mật khẩu không chính xác, không thể đăng nhập.
						$this->response->setContent(json_encode(array(
							'statusId'=> $this->status['fail']['U32001']['id'],
							'statusName'=> $this->status['fail']['U32001']['name'],
						)));
					}
				}else{
					// Tài khoản người dùng không tồn tại, không thể đăng nhập.
					$this->response->setContent(json_encode(array(
						'statusId'=> $this->status['fail']['U32000']['id'],
						'statusName'=> $this->status['fail']['U32000']['name'],
					)));
				}
			}
			$this->response->send();
		}
	}
	public function addAction()
	{
        if ($this->request->isPost()) {
        	$model = new User();
        	$form = new UserForm();
        	$form->initAdding();
            $post = $this->request->getPost();
            $form->bind($post, $model);
            if ($form->isValid()) {
				$phoneNumber = $this->request->getPost('phoneNumber', 'string');
				$user = User::findFirst("phoneNumber='$phoneNumber'");
				// Kiểm tra người dùng đã tồn tại hay chưa, nếu không tồn tại tiến hành tạo tài khoản mới
				if (!$user) {  
					$model->setActive(1); //Active user
	                if ($model->save()) {
	                	// Tạo tài khoản người dùng thành công.
						$this->response->setContent(json_encode(array(
							'statusId'=> $this->status['success']['U21000']['id'],
							'statusName'=> $this->status['success']['U21000']['name'],
						)));
	                } else {
	                	// Hệ thống không thể tạo tài khoản cho người dùng.
						$this->response->setContent(json_encode(array(
							'statusId'=> $this->status['sysFail']['U41000']['id'],
							'statusName'=> $this->status['sysFail']['U41000']['name'],						
						)));	                    
	                }
            	}else{
            		// Tài khoản người dùng đã tồn tại, không thể tạo tài khoản người dùng.
					$this->response->setContent(json_encode(array(
						'statusId'=> $this->status['fail']['U31000']['id'],
						'statusName'=> $this->status['fail']['U31000']['name'],
					)));            		
            	}
            } else {
            	// Dữ liệu không chính xác, không thể tạo tài khoản người dùng.
        		$this->response->setContent(json_encode(array(
					'statusId'=> $this->status['fail']['U31001']['id'],
					'statusName'=> $this->status['fail']['U31001']['name'],
				)));
            }
        	$this->response->send();
        }
	}	
	public function logoutAction()
	{
		if ($this->request->isPost()) {
			$this->session->remove('auth');
			$this->response->setContent(json_encode(array(
				'statusId'=> $this->status['success']['U25000']['id'],
				'statusName'=> $this->status['success']['U25000']['name'],
			)));
        	$this->response->send();
        }
	}

}
