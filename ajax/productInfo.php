<?php

include_once "../model/model.php";
include_once '../model/products.php';

$products = new ProductsModel();

$productId = $_POST['productId'];

$productName = $products->getProductName($productId);
$productPrice = $products->getProductPrice($productId);
$productThumbnail = $products->getProductThumbnail($productId);

$productDetails = json_encode(['productName' => $productName, 'productPrice' => $productPrice, 'productThumbnail' => $productThumbnail]);

echo $productDetails;
