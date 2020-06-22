<?php

include_once 'model/model.php';

class LoginModel extends Model
{
    public function login($email, $password)
    {
        $data = FALSE;
        $password = sha1($password);
        $query="SELECT user_id, first_name, last_name FROM users WHERE email='$email' AND password='$password'";
        $select=$this->pdo->query($query);
        foreach ($select as $row) {
            $data=$row;
        }
        $select->closeCursor();
        {
            return $data;
        }
    }
    
    public function logout()
    {
        Session::destroy();
    }
    
    private function checkEmail($email)
    {
        $query="SELECT user_id, first_name, last_name FROM users WHERE email='$email'";
        if ($this->pdo->query($query)->fetchColumn())
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    
    public function registerUser($email, $firstName, $lastname, $password1, $password2)
    {
        if ($password1!=$password2)
        {
            return FALSE;
        }
        if(filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            if ($this->checkEmail($email))
            {
                return FALSE;
            }
            $password = sha1($password1);
            $currentDate = date("Y-m-d H:i:s");
            $query="INSERT INTO users (first_name, last_name, email, password, joined) VALUES ('$firstName','$lastname','$email','$password','$currentDate')";
            if ($this->pdo->query($query))
            {
                return TRUE;
            }
            else
            {
                return FALSE;
            }
        }
        else
        {
            return FALSE;
        }
    }
}
?>
