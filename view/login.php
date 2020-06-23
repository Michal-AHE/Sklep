<?php

include 'view/view.php';

class LoginView extends View
{
    public function loginForm()
    {
        $this->render('loginForm');
    }
    public function login()
    {
        $art=$this->loadModel('login');
        $data = $art->login($_POST['email'], $_POST['password']);
        if ($data)
        {
            Session::set('userId', $data['user_id']);
            Session::set('userName', $data['first_name']);
            header('Location: index.php');
        }
        else
        {      
            $this->render('loginIncorrect');
        }
    }
    public function logout()
    {
        $art=$this->loadModel('login');
        $art->logout();
        $this->render('logout');
    }
    
    public function register()
    {
        $this->render('loginRegister');
    }
    
    public function registerUser()
    {
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $password1 = $_POST['password1'];
        $password2 = $_POST['password2'];
        $street = $_POST['street'];
        $buildingNo = $_POST['buildingNo'];
        $apartmentNo = $_POST['apartmentNo'];
        $postalCode = $_POST['postalCode'];
        $city = $_POST['city'];
        
        $art=$this->loadModel('login');
        if ($art->registerUser($email, $firstName, $lastName, $password1, $password2, $street, $buildingNo, $apartmentNo, $postalCode, $city))
        {
            header("Location: ?task=login&action=registerSuccess");
        }
        else
        {
            header("Location: ?task=login&action=registerFail");
        }
    }
    
    public function registerSuccess()
    {
        $this->render('loginRegisterSuccess');
    }
    
    public function registerFail()
    {
        $this->render('loginRegisterFail');
    }
}
?>
