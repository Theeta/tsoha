<?php
require_once 'libs/common.php';
require_once 'libs/models/tarkeysaste.php';

//käyttäjä saadaan sessiosta
$id = (int)$_SESSION['kayttaja_id'];

//haetaan käyttäjän tärkeysasteet
$tarkeysasteet = Tarkeysaste::getTarkeysasteet($id);

//näytetään vain kirjautuneelle käyttäjälle lista hänen tärkeysasteistaan
naytaKirjautuneelle('tarkeysasteenmuokkaus_view.php', array('tarkeysasteet'=>$tarkeysasteet));
?>