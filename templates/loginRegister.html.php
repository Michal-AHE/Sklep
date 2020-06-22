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
<input type="submit" value="Zarejestruj"/>
</form>

<? include 'templates/footer.html.php'; ?>