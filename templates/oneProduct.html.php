<? include 'templates/header.html.php'; ?>

    <? foreach($this->get('products') as $product) { ?>
<h1><?= $product['product_name']; ?></h1>
Kategoria: <?= $product['category']; ?><br />
Cena: <?= $product['price']; ?>

<p><?= $product['description']; ?></p>
    <? } ?>
<? if (Session::get('userId')) { ?>
<p>
    <input type="hidden" id="addToCartProductId" value="<?=$product['product_id'];?>"/>
    <input type="hidden" id="addToCartUserId" value="<?=Session::get('userId');?>"/>
    <span>Ilość: </span>
    <span id="addToCartAmount">1</span>
    <span class="cartControl" id="addToCartIncrease">+</span>
    <span class="cartControl" id="addToCartDecrease">-</span>
    <button id="addToCartButton">Dodaj do koszyka</button>
</p>

<? } ?>

<? include 'templates/footer.html.php'; ?>