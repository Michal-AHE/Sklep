<? include 'templates/header.html.php'; ?>

<h2>Podsumowanie Twojego zamówienia</h2>
<h3>Łączna cena</h3>
<p><?=$this->get('userData')['totalPrice']?> PLN</p>
<h3>Dane do wysyłki</h3>
<p><?=$this->get('userData')['firstName']?> <?=$this->get('userData')['lastName']?></p>
<p>Ulica <?=$this->get('userData')['street']?> <?=$this->get('userData')['buildingNumber']?>/<?=$this->get('userData')['apartmentNumber']?></p>
<p><?=$this->get('userData')['postalCode']?> <?=$this->get('userData')['city']?></p>
<h3>Sposób wysyłki</h3>
<p><?=$this->get('userData')['carrierName']?> (<?=$this->get('userData')['carrierCost']?> PLN)</p>
<h3>Płatność:</h3>
<p>ID płatności: <?=$this->get('transactionId');?> (<?=$this->get('paymentMethod');?>)</p>
<form action ='<?=$this->get('paymentAddress');?>' method="GET">
    <input type='hidden' name='paymentId' value="<?=$this->get('transactionId');?>"/>
    <input type='hidden' name='type' value="hardLogin"/>
    <input type="submit" value="Zapłać"/>
</form>
<? include 'templates/footer.html.php'; ?>