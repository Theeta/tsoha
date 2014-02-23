<?php

require_once 'libs/common.php';
require_once 'libs/models/tarkeysaste.php';

//käyttäjä saadaan sessiosta
$kayttaja_id = (int) $_SESSION['kayttaja_id'];

//voidaan muokata vain tärkeysastetta, jonka id on annettu ja joka kuuluu kyseiselle käyttäjälle
if (isset($_GET['id']) && Tarkeysaste::etsi($_GET['id'], $kayttaja_id) != NULL) {
    $id = (int) $_GET['id'];
    $tarkeysaste = Tarkeysaste::etsi($id, $kayttaja_id);
    naytaKirjautuneelle('tarkeysasteennimenmuokkaus_view.php', array('tarkeysaste' => $tarkeysaste));

//kun lomake on lähetetty painamalla tallenna-nappia
} else if (isset($_POST['id'])) {
    $id = (int) $_POST['id'];

    //etsitään kyseinen tärkeysaste kannasta ja asetetaan sille nimi ja käyttäjä
    $tarkeysaste = Tarkeysaste::etsi($id, $kayttaja_id);
    $tarkeysaste->setNimi($_POST['nimi']);
    $tarkeysaste->setKayttaja_id($kayttaja_id);

    //tarkastetaan, onko muokattu tärkeysaste kelvollinen ja jos on, muokataan kantaa, 
    //siirrytään sivulle tärkeysasteenmuokkaus ja ilmoitetaan käyttäjälle onnistuneesta muokkauksesta
    if ($tarkeysaste->onkoKelvollinen()) {
        $tarkeysaste->muokkaaKantaa($id);
        siirrySivulle('tarkeysasteenmuokkaus.php');
        $_SESSION['ilmoitus'] = "Tärkeysastetta muokattu onnistuneesti.";

        //muussa tapauksessa näytetään virheet ja annetaan käyttäjän korjata ne
    } else {
        $virheet = $tarkeysaste->getVirheet();
        $tarkeysasteet = Tarkeysaste::getTarkeysasteet($kayttaja_id);
        naytaKirjautuneelle('tarkeysasteennimenmuokkaus_view.php', array('virheet' => $virheet, 'tarkeysasteet' => $tarkeysasteet, 'tarkeysaste' => $tarkeysaste));
    }
//jos käyttäjä yritti muokata toisen käyttäjän tärkeysastetta tai ei antanut id:tä, siirrytään virhesivulle
} else {
    naytaKirjautuneelle('vaarahenkilo.php', array());
}