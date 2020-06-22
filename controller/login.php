<?php

include 'controller/controller.php';

class LoginController extends Controller{

    public function loginForm() {
        $view=$this->loadView('login');
        $view->loginForm();
    }
    public function login()
    {
        $view=$this->loadView('login');
        $view->login();
    }
    public function logout() {
        $view=$this->loadView('login');
        $view->logout();
    }
    
    public function register() {
        $view=$this->loadView('login');
        $view->register();
    }
    
    public function registerUser() {
        $view=$this->loadView('login');
        $view->registerUser();
    }
    
    public function registerSuccess() {
        $view=$this->loadView('login');
        $view->registerSuccess();
    }
    
    public function registerFail() {
        $view=$this->loadView('login');
        $view->registerFail();
    }
}
?>
