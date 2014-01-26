<?php
//Lista asioista array-tietotyyppiin laitettuna:
require_once 'libs/kayttaja.php';
require_once "libs/tietokantayhteys.php";
$lista = Kayttaja::getKayttajat();
?><!DOCTYPE HTML>
<html>
    <head><title>Listatesti</title></head>
    <body>
        <h1>Käyttäjänimilistatesti</h1>
        <ul>
            <?php foreach ($lista as $asia): ?>
            <li><?php echo $asia->getNimi(); ?></li>
            <?php endforeach; ?>
        </ul>
    </body>
</html>