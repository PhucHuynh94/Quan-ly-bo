<?php

/**
 * UserController
 * @copyright Copyright (c) 2011 - 2014 Aleksandr Torosh (http://wezoom.com.ua)
 * @author Aleksandr Torosh <webtorua@gmail.com>
 */

namespace Cow\Controller;

use Application\Mvc\Controller;
use Cow\Model\Cow;
use Cow\Form\CowForm;
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
                    $this->response->setStatusCode(201, "Created");
					$this->response->setContent(json_encode(array(
						'status'=>'Thêm bò mới thành công',
					)));
                } else {
                    $this->response->setStatusCode(406, "Not Acceptable");
					$this->response->setContent(json_encode(array(
						'status'=>'Không thể tạo bò mới',
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
	public function editAction()
	{
	}

	public function deleteAction()
	{
	}	

}
