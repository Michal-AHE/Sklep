<? include 'templates/header.html.php'; ?>

<form action="index.php?task=login&action=login" method="POST">
    <p>email</p>
    <input type="text" name="email">
    <p>haslo</p>
    <input type="password" name="password">
    <input type="submit" value="Zaloguj">
</form>

<? include 'templates/footer.html.php'; ?>