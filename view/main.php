<?php

include 'view/view.php';

class MainView extends View
{
    public function  index() {
        $art=$this->loadModel('main');
        $this->set('mainStart', $art->getMainStart());
        $this->render('mainStart');
    }
    public function  about()
    {
        $this->set('userId', 'damian1');
        $art=$this->loadModel('main');
        if ($art->isUserLogged())
        {
            $this->set('mainAbout', $art->getMainAbout());
            $this->render('mainAbout');
        }
        else
        {
            $this->render('noPermissions');
        }
    }
}
?>
