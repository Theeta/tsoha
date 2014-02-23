<?php

require_once 'libs/common.php';
require_once 'libs/models/kayttaja.php';

//käyttäjä saadaan sessiosta
$kayttaja_id = (int) $_SESSION['kayttaja_id'];

//käyttäjä voi muokata vain itseään
if (isset($_GET['id']) && $_GET['id'] == $kayttaja_id) {
    $id = (int) $_GET['id'];
    $kayttaja = Kayttaja::etsi($id);
    naytaKirjautuneelle('kayttajanmuokkaus_view.php', array('kayttaja' => $kayttaja));

//jos lomake on lähetetty eli painettu tallenna-nappia
} else if (isset($_POST['id'])) {
    $id = (int) $_POST['id'];
    //etsitään muokattava käyttäjä
    $kayttaja = Kayttaja::etsi($_SESSION['kayttaja_id']);

    //asetetaan uusi nimi ja salasana
    $kayttaja->setNimi($_POST['nimi']);
    $kayttaja->setSalasana($_POST['salasana1'], $_POST['salasana2']);

    $kayttaja->setId($kayttaja_id);

    //tarkastetaan, ovatko muutokset kelvollisia ja jos ovat, muokataan kantaa, 
    //siirrytään tehtävälistaan ja ilmoitetaan käyttäjälle onnistuneesta muokkauksesta
    if ($kayttaja->onkoKelvollinen()) {
        $kayttaja->muokkaaKantaa($id);
        siirrySivulle('tehtavalista.php');
        $_SESSION['ilmoitus'] = "Käyttäjää muokattu onnistuneesti.";

        //jos muokkaus ei onnistunut, näytetään käyttäjälle virheet ja annetaan mahdollisuus niiden korjaamiseen
    } else {
        $virheet = $kayttaja->getVirheet();
        naytaKirjautuneelle('kayttajanmuokkaus_view.php', array('virheet' => $virheet, 'kayttaja' => $kayttaja));
    }

//jos käyttäjä yrittää muokata toista käyttäjää, näytetään virhesivu
} else {
    naytaKirjautuneelle('vaarahenkilo.php', array());
}