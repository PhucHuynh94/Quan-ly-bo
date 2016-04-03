<?php

/**
 * @author dinhnhatbang <dinhnhatbang@gmail.com>
 */

namespace User\Controller;

use Application\Mvc\Controller;
use User\Form\UserForm;
use User\Model\User;

class AdminController extends Controller
{

    public function initialize()
    {
        $this->setAdminEnvironment();
        $this->helper->activeMenu()->setActive('user');
        $this->view->languages_disabled = true;
    }

    public function indexAction()
    {
        $this->view->entries = User::find([
            "order" => "id DESC"
        ]);

        $this->helper->title($this->helper->at('Manage Users'), true);
    }

    public function addAction()
    {
        $this->view->pick(['admin/edit']);

        $model = new User();
        $form = new UserForm();
        $form->initAdding();

        if ($this->request->isPost()) {
            $model = new User();
            $post = $this->request->getPost();
            $form->bind($post, $model);
            if ($form->isValid()) {
                $model->setCheckboxes($post);
                if ($model->save()) {
                    $this->flash->success($this->helper->at('User created', ['name' => $model->getPhoneNumber()]));
                    $this->redirect($this->url->get() . 'user/admin');
                } else {
                    $this->flashErrors($model);
                }
            } else {
                $this->flashErrors($form);
            }
        }

        $this->view->form = $form;
        $this->view->model = $model;
        $this->view->submitButton = $this->helper->at('Add New');

        $this->helper->title($this->helper->at('Add new user'), true);
    }

    public function editAction($id)
    {
        $model = User::findFirst($id);
        if (!$model) {
            $this->redirect($this->url->get() . 'admin/edit');
        }
        $form = new UserForm();
        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form->bind($post, $model);
            if ($form->isValid()) {
                $model->setCheckboxes($post);
                if ($model->save() == true) {
                    $this->flash->success('User <b>' . $model->getPhoneNumber() . '</b> has been saved');
                    return $this->redirect($this->url->get() . 'user/admin');
                } else {
                    $this->flashErrors($model);
                }
            } else {
                $this->flashErrors($form);
            }
        } else {
            $form->setEntity($model);
        }

        $this->view->submitButton = $this->helper->at('Save');
        $this->view->form = $form;
        $this->view->model = $model;

        $this->helper->title($this->helper->at('Manage Users'), true);
    }

    public function deleteAction($id)
    {
        $model = User::findFirst($id);
        if (!$model) {
            return $this->redirect($this->url->get() . 'user/admin');
        }
        if ($this->request->isPost()) {
            $model->delete();
            $this->flash->warning('Deleting user <b>' . $model->getPhoneNumber() . '</b>');
            return $this->redirect($this->url->get() . 'user/admin');
        }
        $this->view->model = $model;
        $this->helper->title($this->helper->at('Delete User'), true);
    }

}
