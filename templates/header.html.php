<html>
    <head>
        <title>Sklep medyczny</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link href="css/style.css?ver=1.2" rel="stylesheet" type="text/css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    </head>
    <body>
        <div id="cartInfoBackground">
            <div id="cartInfo">
                <div id="cartInfoClose"></div>
                <h2>Dodano produkt do koszyka!</h2>
                <table id="cartInfoTable">
                    <thead>
                        <th>Zdjęcie</th>
                        <th>Produkt</th>
                        <th>Ilość</th>
                        <th>Łączna cena</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td id="cartInfoImageCell">
                                <img id="cartInfoImage" src="" width="200"/>
                            </td>
                            <td id="cartInfoName"></td>
                            <td id="cartInfoAmount"></td>
                            <td id="cartInfoValue"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div id="top-menu">
            <div id="loginContainer">
                <? echo (Session::get('userId') ? 'Witaj '.Session::get('userName').' (<a href=index.php?task=login&action=logout>Wygloguj</a>)' : '<a href="index.php?task=login&action=loginForm">Zaloguj</a><a style="margin-left:20px;" href="index.php?task=login&action=register">Zarejestruj się</a>'); ?>
            </div>
            <?php if (Session::get('userId')) { ?>
            <div id='cartAmount'>
                <p>Koszyk: <a href="?task=cart&action=cartSummary"><?=$this->get('totalCartAmount');?></a> produktów</p>
            </div>
            <?php } ?>
            <div class="menu_position"><a href="?task=main&amp;action=start">Strona Główna</a></div>
            <div class="menu_position"><a href="?task=main&amp;action=about">O nas</a></div>
            <div class="menu_position"><a href="?task=products&amp;action=index">Sklep internetowy</a></div>
            <div class="menu_position"><a href="?task=main&amp;action=contact">Kontakt</a></div>
        </div>
        <div id="content">