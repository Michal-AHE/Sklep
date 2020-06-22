<?php

include 'controller/controller.php';

class CartController extends Controller{

    public function addToCart() {
        $view=$this->loadView('cart');
        $view->addToCart();
    }
    public function cartSummary() {
        $view=$this->loadView('cart');
        $view->cartSummary();
    }
    public function cartOrder() {
        $view=$this->loadView('cart');
        $view->cartOrder();
    }
    public function summarizeOrder() {
        $view= $this->loadView('cart');
        $view->summarizeOrder();
    }
}
?>
