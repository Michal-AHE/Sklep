<? include 'templates/header.html.php'; ?>

<h2>Twoje zamówienia</h2>

<table style='text-align: center;'>
    <thead>
    <th>Nr zamówienia</th>
    <th>Data zamówienia</th>
    <th>Łączna ilość</th>
    <th>Łączna kwota</th>
    <th>Status</th>
    </thead>
    <tbody>
    <? foreach ($this->get('orders') as $order) { ?>
    <tr>
        <td><a href="?task=users&action=order&orderId=<?=$order['order_id'];?>"><?=$order['order_id'];?></a></td>
        <td><?=$order['date'];?></td>
        <td><?=$order['total_amount'];?></td>
        <td><?=$order['total_price'];?></td>
        <td><?=$order['status_name'];?></td>
    </tr>
    <? } ?>
    </tbody>
</table>

<? include 'templates/footer.html.php'; ?>