<? include 'templates/header.html.php'; ?>

<h2>Uzupełnij swoje dane</h2>

<form action ="?task=cart&action=summarizeOrder" method="POST">
<p>Imię</p>
<input type="text" name="firstName" value="<?=$this->get('userData')['first_name'];?>"/>
<p>Nazwisko</p>
<input type="text" name="lastName" value="<?=$this->get('userData')['last_name'];?>"/>
<p>Ulica</p>
<input type="text" name="street" value="<?=$this->get('userData')['street'];?>"/>
<p>Numer budynku</p>
<input type="text" name="buildingNumber" value="<?=$this->get('userData')['building_no'];?>"/>
<p>Numer mieszkania</p>
<input type="text" name="apartmentNumber" value="<?=$this->get('userData')['apartment_no'];?>"/>
<p>Kod pocztowy</p>
<input type="text" name="postalCode" value="<?=$this->get('userData')['postal_code'];?>"/>
<p>Miasto</p>
<input type="text" name="city" value="<?=$this->get('userData')['city'];?>"/>
<p>Sposób wysyłki</p>

<? foreach ($this->get('carriers') as $carrier) { ?>

<input type="radio" id="carrier_<?=$carrier['carrier_id']?>" name="carrier" value="<?=$carrier['carrier_id']?>">
<label for="1"><?=$carrier['name']?> (<?=$carrier['cost']?> PLN)</label><br>

<? } ?>

<p>Sposób płatności</p>
<? foreach ($this->get('paymentMethods') as $paymentMethod) { ?>
<input type="radio" id="<?=$paymentMethod['id']?>" name="payment" value="<?=$paymentMethod['id']?>">
<label for="1"><?=$paymentMethod['name']?></label><br>
<? } ?>
<input type="submit" value="Przejdź do podsumowania"/>
</form>

<? include 'templates/footer.html.php'; ?>