<? include 'templates/header.html.php'; ?>

<h2>Produkt pomyślnie dodany do koszyka</h2>
<a>Przejdź do koszyka</a>
<a href="?task=products&action=one&id=<?=$this->get('productId');?>">Wróć do zakupów</a>

<? include 'templates/footer.html.php'; ?>