<?php

abstract class Model
{
    protected $pdo;

    public function  __construct() {
        try {
            require '/home/imagiweb/domains/imagiwebtion.eu/public_html/sklep/config/sql.php';
            $this->pdo=new PDO('mysql:host='.$host.';charset=utf8;dbname='.$dbase, $user, $pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(DBException $e) {
            echo 'The connect can not create: ' . $e->getMessage();
        }
    }
    
    public function isUserLogged()
    {
        if (isset($_SESSION['userId']))
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
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
    
    public function getCurrentDateTime()
    {
        $date = date("Y-m-d H:i:s");
        return $date;
    }
}