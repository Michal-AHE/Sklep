<? include 'templates/header.html.php'; ?>

<form action="?task=login&action=registerUser" method="POST">
<h2>Rejestracja nowego klienta</h2>
<p>Imię</p>
<input type="text" name="firstName"/>
<p>Nazwisko</p>
<input type="text" name="lastName"/>
<p>E-mail</p>
<input type="text" name="email"/>
<p>Hasło</p>
<input type="password" name="password1"/>
<p>Powtórz hasło</p>
<input type="password" name="password2"/>
<p>Ulica</p>
<input type="text" name="street"/>
<p>Numer domu</p>
<input type="text" name="buildingNo"/>
<p>Numer lokalu</p>
<input type="text" name="apartmentNo"/>
<p>Kod pocztowy</p>
<input type="text" name="postalCode"/>
<p>Miasto</p>
<input type="text" name="city"/>
<input type="submit" value="Zarejestruj"/>
</form>

<? include 'templates/footer.html.php'; ?>