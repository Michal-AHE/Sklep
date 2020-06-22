<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_name("sklep");
session_start();
require 'libs/session.php';
$session = new Session;


if (isset($_GET['task']))
{
    if (isset($_GET['action']))
    {
        $action = $_GET['action'];
    }
    else
    {
        $action = 'index';
    }
    
    if($_GET['task']=='main')
    {
        include 'controller/main.php';
        $ob = new MainController();
        $ob->$action();
    }
    else if($_GET['task']=='products')
    {
        include 'controller/products.php';
        $ob = new ProductsController();
        $ob->$action();
    }
    else if($_GET['task']=='login')
    {
        include 'controller/login.php';
        $ob = new LoginController();
        $ob->$action();
    }
    else if($_GET['task']=='categories')
    {
        include 'controller/categories.php';
        $ob = new CategoriesController();
        $ob->$action();
    }
    else if($_GET['task']=='cart')
    {
        include 'controller/cart.php';
        $ob = new CartController();
        $ob->$action();
    }
    else if ($_GET['task']=='users')
    {
        include 'controller/users.php';
        $ob = new UsersController();
        $ob->$action();
    }
    else
    {
        include 'controller/articles.php';
        $ob = new ArticlesController();
        $ob->index();
    }
}
else
{
    include 'controller/main.php';
    $ob = new MainController();
    $ob->start();
}
?>
