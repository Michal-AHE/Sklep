<? include 'templates/header.html.php'; ?>

<h2>Twoje zamówienie nr <?=$this->get('orderId');?></h2>

<h3>Odbiorca: </h3>
<p><?=$this->get('details')['firstName'];?> <?=$this->get('details')['lastName'];?></p>
<p>ul. <?=$this->get('details')['street'];?> <?=$this->get('details')['buildingNo'];?>/<?=$this->get('details')['apartmentNo'];?></p>
<p>ul. <?=$this->get('details')['postalCode'];?> <?=$this->get('details')['city'];?></p>

<?php if($this->get('details')['status'] == 2 OR $this->get('details')['status'] == 3) { ?>
<p><a href="dompdf/index.php?orderId=<?=$this->get('orderId');?>">Pobierz fakturę</a></p>
<?php } ?>

<? include 'templates/footer.html.php'; ?>