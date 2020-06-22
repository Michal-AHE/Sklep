<?php

abstract class View{

    protected $cartModel;


    public function __construct()
    {
        $this->set('userId', Session::get('userId'));
        $this->cartModel=$this->loadModel('cart');
        $cart = $this->cartModel->getCartSummary($this->get('userId'));
        $this->set("totalCartAmount", $cart['totalAmount']);
        $this->set("totalCartValue", $cart['totalValue']);
    }
    
    public function loadModel($name, $path='model/') {
        $path=$path.$name.'.php';
        $name=$name.'Model';
        try {
            if(is_file($path)) {
                require $path;
                $ob=new $name();
            } else {
                throw new Exception('Can not open model '.$name.' in: '.$path);
            }
        }
        catch(Exception $e) {
            echo $e->getMessage().'<br />
                File: '.$e->getFile().'<br />
                Code line: '.$e->getLine().'<br />
                Trace: '.$e->getTraceAsString();
            exit;
        }
        return $ob;
    }
    
    public function render($name, $path='templates/') {
        $path=$path.$name.'.html.php';
        try {
            if(is_file($path)) {
                require $path;
            } else {
                throw new Exception('Can not open template '.$name.' in: '.$path);
            }
        }
        catch(Exception $e) {
            echo $e->getMessage().'<br />
                File: '.$e->getFile().'<br />
                Code line: '.$e->getLine().'<br />
                Trace: '.$e->getTraceAsString();
            exit;
        }
    }
    
    public function set($name, $value) {
        $this->$name=$value;
    }
    
    public function get($name) {
        return $this->$name;
    }
}