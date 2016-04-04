<?php

/**
 * @author dinhnhatbang <dinhnhatbang@gmail.com>
 */

namespace User\Controller;

use Application\Mvc\Controller;
use User\Form\UserForm;
use User\Form\LoginForm;
use User\Model\User;

class IndexController extends Controller
{

    public function indexAction()
    {
        $this->view->languages_disabled = true;

        $auth = $this->session->get('auth');
        if (!$auth) {
            $this->flash->notice($this->helper->at('Log in please'));
            $this->redirect($this->url->get() . 'user/index/login');
        }
        
        $this->helper->title($this->helper->at('User Panel'), true);

        $this->helper->activeMenu()->setActive('admin-home');

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
                                return $this->redirect($this->url->get() . 'admin');
                            } else {
                                $this->flash->error($this->helper->translate("User is not activated yet"));
                            }
                        } else {
                            $this->flash->error($this->helper->translate("Incorrect login or password"));
                        }
                    } else {
                        $this->flash->error($this->helper->translate("Incorrect login or password"));
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
