<?php

include 'controller/controller.php';

class UsersController extends Controller{

    public function userData() {
        $view=$this->loadView('orders');
        $view->addToCart();
    }
    
    public function orders()
    {
        $view=$this->loadView('users');
        $view->orders();
    }
    
    public function order()
    {
        $view=$this->loadView('users');
        $view->order();
    }
}
?>
