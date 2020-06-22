<? include 'templates/header.html.php'; ?>

<h1>Lista artykułów</h1>
<table>
    <tr>
        <td>Miniatura</td>
        <td>Nazwa</td>
        <td>Kategoria</td>
        <td>Cena</td>
    </tr>
    <? foreach($this->get('products') as $product) { ?>
    <tr>
        <td><img alt="<?=$product['product_name'];?>" src="gfx/products/<?=$product['product_id'];?>/<?=$product['product_link'];?>-<?=$product['thumbnail'];?>.jpg" width="100"></td>
        <td><a href="?task=products&amp;action=one&amp;id=<?= $product['product_id']; ?>"><?= $product['product_name']; ?></a></td>
        <td><?= $product['category']; ?></td>
        <td><?= $product['price']; ?></td>
    </tr>
    <? } ?>
</table>

<? include 'templates/footer.html.php'; ?>