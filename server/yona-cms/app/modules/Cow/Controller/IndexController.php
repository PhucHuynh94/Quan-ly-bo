<?php

/**
 * AdminUserController
 * @copyright Copyright (c) 2011 - 2014 Aleksandr Torosh (http://wezoom.com.ua)
 * @author Aleksandr Torosh <webtorua@gmail.com>
 */

namespace User\Controller;

use Application\Mvc\Controller;
use User\Model\User;
use User\Form\LoginForm;
use Phalcon\Mvc\View;

class IndexController extends Controller
{

    public function indexAction()
    {


    }

    public function loginAction()
    {
        $form = new LoginForm();

        if ($this->request->isPost()) {
            if ($this->security->checkToken()) {
                if ($form->isValid($this->request->getPost())) {
                    $phoneNumber = $this->request->getPost('phoneNumber', 'string');
                    $password = $this->request->getPost('password', 'string');
                    $user = User::findFirst("phoneNumber='$phoneNumber'");
                    if ($user) {
                        if ($user->checkPassword($password)) {
                            if ($user->isActive()) {
                                $this->session->set('auth', $user->getAuthData());
                                $this->flash->success($this->helper->translate("Welcome to the administrative control panel!"));
                                return $this->redirect($this->url->get() . 'user/index');
                            } else {
                                $this->flash->error($this->helper->translate("User is not activated yet"));
                            }
                        } else {
                            $this->flash->error($this->helper->translate("Sai số điện thoại hoặc mật khẩu"));
                        }
                    } else {
                        $this->flash->error($this->helper->translate("Sai số điện thoại hoặc mật khẩu"));
                    }
                } else {
                    foreach ($form->getMessages() as $message) {
                        $this->flash->error($message);
                    }
                }
            } else {
                $this->flash->error($this->helper->translate("Security errors"));
            }
        }

        $this->view->form = $form;

    }

    public function logoutAction()
    {
        if ($this->request->isPost()) {
            if ($this->security->checkToken()) {
                $this->session->remove('auth');
            } else {
                $this->flash->error("Security errors");
            }
        } else {
            $this->flash->error("Security errors");
        }
        $this->redirect($this->url->get());
    }

}
