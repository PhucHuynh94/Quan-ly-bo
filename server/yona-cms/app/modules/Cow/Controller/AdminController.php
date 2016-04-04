<?php

/**
 * @author dinhnhatbang <dinhnhatbang@gmail.com>
 */

namespace Cow\Controller;

use Application\Mvc\Controller;
use Cow\Form\CowForm;
use Cow\Model\Cow;

class AdminController extends Controller
{

    public function initialize()
    {
        $this->setAdminEnvironment();
        $this->helper->activeMenu()->setActive('cow');
        $this->view->languages_disabled = true;
    }

    public function indexAction()
    {
        $this->view->entries = Cow::find([
            "order" => "id DESC"
        ]);

        $this->helper->title($this->helper->at('Manage Cows'), true);
    }

    public function addAction()
    {
        $this->view->pick(['admin/edit']);

        $model = new Cow();
        $form = new CowForm();
        $form->initAdding();

        if ($this->request->isPost()) {
            $model = new Cow();
            $post = $this->request->getPost();
            $form->bind($post, $model);
            if ($form->isValid()) {
                $model->setCheckboxes($post);
                if ($model->save()) {
                    $this->flash->success($this->helper->at('Cow created'));
                    $this->redirect($this->url->get() . 'cow/admin');
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

        $this->helper->title($this->helper->at('Add new cow'), true);
    }

    public function editAction($id)
    {
        $model = Cow::findFirst($id);
        if (!$model) {
            $this->redirect($this->url->get() . 'admin/edit');
        }
        $form = new CowForm();
        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form->bind($post, $model);
            if ($form->isValid()) {
                $model->setCheckboxes($post);
                if ($model->save() == true) {
                    $this->flash->success('Cow has been saved');
                    return $this->redirect($this->url->get() . 'cow/admin');
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

        $this->helper->title($this->helper->at('Manage Cows'), true);
    }

    public function deleteAction($id)
    {
        $model = Cow::findFirst($id);
        if (!$model) {
            return $this->redirect($this->url->get() . 'cow/admin');
        }
        if ($this->request->isPost()) {
            $model->delete();
            $this->flash->warning('Deleting cow');
            return $this->redirect($this->url->get() . 'cow/admin');
        }
        $this->view->model = $model;
        $this->helper->title($this->helper->at('Delete Cow'), true);
    }

}
