<? include 'templates/header.html.php'; ?>

<h2>Zawartość Twojego koszyka</h2>
<? $cart = $this->get('cart'); ?>
<table id="cartInfoTable">
                    <thead>
                        <th></th>
                        <th>Produkt</th>
                        <th>Ilość</th>
                        <th>Cena</th>
                        <th>Łączna cena</th>
                    </thead>
                    <tbody>
                        <? if (count($this->get('cart'))>0) { ?>
                        <? foreach ($this->get('cart') as $product=>$values) { ?>
                        <tr>
                            <td id="cartInfoImageCell">
                                <img id="cartSummaryImage" src="<?=$values['thumbnail'];?>" width="70"/>
                            </td>
                            <td id="cartInfoName"><?=$values['name'];?></td>
                            <td id="cartInfoAmount"><?=$values['amount'];?></td>
                            <td id="cartInfoValue"><?=$values['price'];?></td>
                            <td id="cartInfoValue"><?=$values['priceTotal'];?></td>
                        </tr>
                        <? } ?>
                        <tr>
                            <td colspan="5" style="text-align: center;">
                                <form action="?task=cart&action=cartOrder" method="POST">
                                    <input type="hidden" name="cartSummary" value="<?=$this->get('cart')?>">
                                    <button id="makeOrder">Dokonaj zakupu</button>
                                </form>
                            </td>
                        </tr>
                        <? } else { ?>
                        <tr><td colspan="5" style="text-align: center;">Twój koszyk jest pusty</td></tr>
                        <? } ?>
                    </tbody>
                </table>

<? include 'templates/footer.html.php'; ?>