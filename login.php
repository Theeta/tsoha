<?php

require_once 'libs/common.php';

if (empty($_POST["username"]) && empty($_POST["password"])) {
    naytaNakyma('kirjautuminen.php');
}

//Tarkistetaan että vaaditut kentät on täytetty:
if (empty($_POST["username"])) {
    naytaNakyma("kirjautuminen.php", array('virhe' => "Kirjautuminen epäonnistui! Et antanut käyttäjätunnusta."));
}
$kayttaja = $_POST["username"];

if (empty($_POST["password"])) {
    naytaNakyma("kirjautuminen.php", array('kayttaja' => $kayttaja, 'virhe' => "Kirjautuminen epäonnistui! Et antanut salasanaa."));
}
$salasana = $_POST["password"];

$kayttaja = Kayttaja::getKayttajaTunnuksilla($kayttaja, $salasana);

/* Tarkistetaan onko parametrina saatu oikeat tunnukset */
if (isset($kayttaja)) {
    /* Jos tunnus on oikea, ohjataan käyttäjä sopivalla HTTP-otsakkeella listaan. */
    $_SESSION['kayttaja'] = $kayttaja;
    $_SESSION['kayttaja_id'] = $kayttaja->getId();
    siirrySivulle('tehtavalista.php');
} else {
    naytaNakyma("kirjautuminen.php", array(
        /* Välitetään näkymälle tieto siitä, kuka yritti kirjautumista */
        'kayttaja' => $kayttaja,
        'virhe' => "Kirjautuminen epäonnistui! Antamasi tunnus tai salasana on väärä."));
}
  