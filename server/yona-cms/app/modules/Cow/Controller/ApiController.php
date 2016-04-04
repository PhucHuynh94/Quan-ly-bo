<?php

/**
 * @author dinhnhatbang <dinhnhatbang@gmail.com>
 */

namespace Cow\Controller;

use Application\Mvc\Controller;
use Cow\Model\Cow;
use Cow\Form\CowForm;
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
  
	public function addAction()
	{
        if ($this->request->isPost()) {
        	$model = new Cow();
        	$form = new CowForm();
        	$form->initAdding();
            $post = $this->request->getPost();
            $form->bind($post, $model);
            if ($form->isValid()) {
                if ($model->save()) {
                	// Tạo bò thành công
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
}
