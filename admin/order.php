<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$selectedOrder = $_GET['orderId'];

require 'header.php';

require '../model/model.php';
require '../model/products.php';
require '../model/orders.php';

$productsModel = new ProductsModel();
$ordersModel = new OrdersModel();

$orderDetails = $ordersModel->getOrderDetails($selectedOrder);
$orderStatuses = $ordersModel->getOrderStatuses();

?>

<h3>Dane do wysyłki</h3>
<table>
    <tr><td>Imię</td><td><?=$orderDetails['firstName'];?></td></tr>
    <tr><td>Nazwisko</td><td><?=$orderDetails['lastName'];?></td></tr>
    <tr><td>Adres</td><td>Ul. <?=$orderDetails['street'];?> <?=$orderDetails['buildingNo'];?>/<?=$orderDetails['apartmentNo'];?></td></tr>
    <tr><td>Miasto</td><td><?=$orderDetails['postalCode'];?> <?=$orderDetails['city'];?></td></tr>
</table>

<br/>

<h3>Zamówione produkty</h3>
<table style="text-align: center;">
    <thead>
    <th>Nazwa</th>
    <th>Ilość</th>
    <th>Cena</th>
    <th>Łączna cena</th>
    </thead>
    <?php foreach ($orderDetails['products'] as $product) { ?>
    <tr>
        <td><?=$product['name'];?></td>
        <td><?=$product['amount'];?></td>
        <td><?=$product['price'];?> PLN</td>
        <td><?=$product['totalPrice'];?> PLN</td>
    </tr>
    <?php } ?>
    <tr><td colspan="4" style="text-align: right;">Razem: <?=$orderDetails['totalPrice'];?></td></td>
</table>

<br/>
<h3>Status zamówienia:</h3>
<form action="updateOrderStatus.php" method="POST">
<select name="orderStatus">
    <?php     foreach ($orderStatuses as $statusId=>$statusName) { 
        if ($statusId == $orderDetails['status']) { ?>
            <option value="<?=$statusId;?>" selected=""><?=$statusName;?></option> 
        <?php } else { ?>
            <option value="<?=$statusId;?>"><?=$statusName;?></option>
        <?php } ?>
    <?php } ?>
</select>
<input type="hidden" name="orderId" value="<?=$selectedOrder;?>"/>
<input type="submit" value="Zmień status"/>
</form>