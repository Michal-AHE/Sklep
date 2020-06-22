<?php

include 'view/view.php';

class ProductsView extends View{
    public function  index() {
        $art=$this->loadModel('products');
        //$art->getCategoryTree(2);
        $this->set('latests', $art->getLatestProducts());
        $this->set('promotions', $art->getPromo());
        $this->render('shopIndex');
    }
    public function  one() {
        $art=$this->loadModel('products');
        $this->set('products', $art->getOne($_GET['id']));
        $this->render('oneProduct');
    }
    public function add() {
        $cat=$this->loadModel('categories');
        $this->set('catsData', $cat->getAll());
        $this->render('addArticle');
    }
}
?>
