<?php

require_once 'libs/common.php';

//jos on painettu kirjaudu sisään -nappia eli lähetetty lomake, tarkastetaan, onko annettu käyttäjätunnus ja salasana
if (isset($_POST['lahetetty'])) {
    if (empty($_POST["username"]) && empty($_POST["password"])) {
        naytaNakyma('kirjautuminen.php', array('virheet' => "Kirjautuminen epäonnistui! Et antanut käyttäjätunnusta tai salasanaa."));
    } elseif (empty($_POST["username"])) {
        naytaNakyma("kirjautuminen.php", array('virheet' => "Kirjautuminen epäonnistui! Et antanut käyttäjätunnusta."));
    } elseif (empty($_POST["password"])) {
        $tunnus = $_POST["username"];
        naytaNakyma("kirjautuminen.php", array('tunnus' => $tunnus, 'virheet' => "Kirjautuminen epäonnistui! Et antanut salasanaa."));
    }
    $tunnus = $_POST["username"];
    $salasana = $_POST["password"];
    $kayttaja = Kayttaja::getKayttajaTunnuksilla($tunnus, $salasana);
    
    /* Tarkistetaan onko parametrina saatu oikeat tunnukset */
if (isset($kayttaja)) {
    /* Jos tunnus on oikea, ohjataan käyttäjä listaan ja tervehditään käyttäjää nimeltä. */
    $_SESSION['kayttaja'] = $kayttaja;
    $_SESSION['kayttaja_id'] = $kayttaja->getId();
    siirrySivulle('tehtavalista.php');
    $_SESSION['ilmoitus'] = "Hei " . $kayttaja->getNimi() . "!";
} else {
    naytaNakyma("kirjautuminen.php", array(
        /* Välitetään näkymälle tieto siitä, kuka yritti kirjautumista */
        'tunnus' => $tunnus,
        'virheet' => "Kirjautuminen epäonnistui! Antamasi tunnus tai salasana on väärä."));
}
  
}
//jos lomaketta ei ole vielä lähetetty, näytetään kirjautumisnäkymä
else {
    naytaNakyma('kirjautuminen.php', array());
}

