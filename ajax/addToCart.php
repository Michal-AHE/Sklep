<?php

include_once "../model/model.php";
include_once '../model/cart.php';

$cartClass = new CartModel();

$productId = $_POST['productId'];
$userId = $_POST['userId'];
$productAmount = $_POST['productAmount'];

if ($cartClass->addToCart($userId, $productId, $productAmount))
{
    echo "1";
}
else
{
    echo '0';
}