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
    
    public function registerUser($email, $firstName, $lastname, $password1, $password2, $street, $buildingNo, $apartmentNo, $postalCode, $city)
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
            $queryUser="INSERT INTO users (first_name, last_name, email, password, joined) VALUES ('$firstName','$lastname','$email','$password','$currentDate')";
            $stmtUser = $this->pdo->prepare($queryUser);
            $userStatus = $stmtUser->execute();
            $userId = $this->pdo->lastInsertId();
            
            $queryUserData="INSERT INTO users_data (user_id, street, building_no, apartment_no, postal_code, city)"
                    . " VALUES ('$userId','$street','$buildingNo','$apartmentNo','$postalCode', '$city')";
            $userDataStatus = $this->pdo->query($queryUserData);
            if ($userStatus AND $userDataStatus)
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
