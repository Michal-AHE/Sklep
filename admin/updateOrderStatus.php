<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'header.php';

require '../model/model.php';
require '../model/products.php';
require '../model/orders.php';

$productsModel = new ProductsModel();
$ordersModel = new OrdersModel();

$orderId = $_POST['orderId'];
$status = $_POST['orderStatus'];

if ($ordersModel->changeOrderStatus($orderId, $status))
{
    echo "<p>Zmieniono status zamówienia</p>";
}
else
{
    echo "<p>Podczas próby zmiany statusu zamówienia wystąpił błąd</p>";
}