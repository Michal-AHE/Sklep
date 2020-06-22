<?php

include 'controller/controller.php';

class MainController extends Controller{

    public function start() {
        $view=$this->loadView('main');
        $view->index();
    }
    public function about() {
        $view=$this->loadView('main');
        $view->about();
    }
}
?>
