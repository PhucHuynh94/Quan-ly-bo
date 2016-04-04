<?php

/**
 * @author dinhnhatbang <dinhnhatbang@gmail.com>
 */

namespace Cowtype\Controller;

use Application\Mvc\Controller;
use Cowtype\Form\CowtypeForm;
use Cowtype\Model\Cowtype;

class AdminController extends Controller
{

    public function initialize()
    {
        $this->setAdminEnvironment();
        $this->helper->activeMenu()->setActive('cowtype');
        $this->view->languages_disabled = true;
    }

    public function indexAction()
    {
        $this->view->entries = Cowtype::find([
            "order" => "id DESC"
        ]);

        $this->helper->title($this->helper->at('Quản lý giống bò'), true);
    }

    public function addAction()
    {
        $this->view->pick(['admin/edit']);

        $model = new Cowtype();
        $form = new CowtypeForm();

        if ($this->request->isPost()) {
            $model = new Cowtype();
            $post = $this->request->getPost();
            $form->bind($post, $model);
            if ($form->isValid()) {
                if ($model->save()) {
                    $this->flash->success($this->helper->at('Cowtype '. $model->getName() .'created'));
                    $this->redirect($this->url->get() . 'cowtype/admin');
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

        $this->helper->title($this->helper->at('Add new cow type'), true);
    }

    public function editAction($id)
    {
        $model = Cowtype::findFirst($id);
        if (!$model) {
            $this->redirect($this->url->get() . 'cowtype/admin');
        }
        $form = new CowtypeForm();
        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form->bind($post, $model);
            if ($form->isValid()) {
                if ($model->save() == true) {
                    $this->flash->success('Cowtype has been saved');
                    return $this->redirect($this->url->get() . 'cowtype/admin');
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

        $this->helper->title($this->helper->at('Manage Cow type'), true);
    }

    public function deleteAction($id)
    {
        $model = Cowtype::findFirst($id);
        if (!$model) {
            return $this->redirect($this->url->get() . 'cowtype/admin');
        }
        if ($this->request->isPost()) {
            $model->delete();
            $this->flash->warning('Deleting cow type ' . $model->getName());
            return $this->redirect($this->url->get() . 'cowtype/admin');
        }
        $this->view->model = $model;
        $this->helper->title($this->helper->at('Delete cow type'), true);
    }

}
