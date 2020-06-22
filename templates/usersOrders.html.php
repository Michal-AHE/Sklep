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
        <td><?=$order['order_id'];?></td>
        <td><?=$order['date'];?></td>
        <td><?=$order['total_amount'];?></td>
        <td><?=$order['total_price'];?></td>
        <td><?=$order['status'];?></td>
    </tr>
    <? } ?>
    </tbody>
</table>

<? include 'templates/footer.html.php'; ?>