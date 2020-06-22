<?php

include 'controller/controller.php';

class ProductsController extends Controller{

    public function index() {
        $view=$this->loadView('products');
        $view->index();
    }
    public function one() {
        $view=$this->loadView('products');
        $view->one();
    }
    public function add() {
        $view=$this->loadView('products');
        $view->add();
    }
    public function insert() {
        $model=$this->loadModel('products');
        $model->insert($_POST);
        $this->redirect('?task=products&action=index');
    }
    public function delete() {
        $model=$this->loadModel('articles');
        $model->delete($_GET['id']);
        $this->redirect('?task=products&action=index');
    }
}
?>
