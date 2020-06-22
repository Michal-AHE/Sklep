<? include 'templates/header.html.php'; ?>

<h1>Sklep internetowy</h1>
<h2>Ostatnio dodane produkty</h2>
<table>
    <? foreach($this->get('latests') as $latest) { ?>
    <tr>
        <td><img src="gfx/products/<?=$latest['product_id'];?>/<?=$latest['product_link'];?>-<?=$latest['thumbnail'];?>.jpg" width="100"></td>
        <td>
            <p><a href="?task=products&amp;action=one&amp;id=<?= $latest['product_id']; ?>"><?= $latest['product_name']; ?></a></p>
            <p>
                <ul>
                    <li>Sklep</li>
                    <? foreach($latest['category_tree'] as $category) { ?>
                    <li class="subcategory_li"><?= $category ?></li>
                    <? } ?>
                </ul>
            </p>
        </td>
        <td><?= $latest['price']; ?></td>
    </tr>
    <? } ?>
</table>

<h2>Promocje</h2>
<table>
    <? foreach($this->get('promotions') as $promo) { ?>
    <tr>
        <td><img src="gfx/products/<?=$promo['product_id'];?>/<?=$promo['product_link'];?>-<?=$promo['thumbnail'];?>.jpg" width="100"></td>
        <td><a href="?task=products&amp;action=one&amp;id=<?= $promo['product_id']; ?>"><?= $promo['product_name']; ?></a></td>
        <td><?= $promo['category']; ?></td>
        <td style="text-decoration: line-through;"><?= $promo['product_price']; ?></td>
        <td style="font-weight: bold;"><?= $promo['new_price']; ?></td>
    </tr>
    <? } ?>
</table>
<? include 'templates/footer.html.php'; ?>