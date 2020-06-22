<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'header.php';

require '../model/model.php';
require '../model/orders.php';

$ordersModel = new OrdersModel();
$orders = $ordersModel->getAllOrdersByStatus();
?>

<table>
    <thead>
    <th>Nr zamówienia</th>
    <th>Data zamówienia</th>
    <th>Użytkownik</th>
    <th>Towarów</th>
    <th>Kwota</th>
    <th>Status</th>
    </thead>
    <tbody>
        <?php foreach ($orders as $order) { ?>
        <tr>
            <td><a href="order.php?orderId=<?=$order['order_id'];?>"><?=$order['order_id'];?></a></td>
            <td><?=$order['date'];?></td>
            <td><?=$order['user_id'];?></td>
            <td><?=$order['total_amount'];?></td>
            <td><?=$order['total_price'];?></td>
            <td><?=$order['status_name'];?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>

