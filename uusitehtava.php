<?php

require_once 'libs/common.php';
require_once 'libs/models/tehtava.php';
require_once 'libs/models/luokka.php';

//käyttäjä saadaan selville sessiosta
$kayttaja_id = $_SESSION['kayttaja_id'];

//haetaan tietyn käyttäjän tärkeysasteet ja luokat, jotka käyttäjä voi valita uudelle tehtävälleen
$tarkeysasteet = Tarkeysaste::getTarkeysasteet($kayttaja_id);
$luokat = Luokka::getKayttajanluokat($kayttaja_id);

//jos käyttäjä on painanut tallenna-nappia
if (isset($_POST['lahetetty'])) {

    //luodaan uusi tehtäväolio ja asetetaan sille käyttäjä, kuvaus ja tärkeysaste
    $tehtava = new Tehtava(null, null, null, null, null);
    $tehtava->setKayttaja_id($kayttaja_id);
    $tehtava->setKuvaus($_POST['kuvaus']);
    $tehtava->setTarkeysaste_id($_POST['tarkeysaste_id'], $kayttaja_id);

    //jos käyttäjä on valinnut luokkia, asetetaan tehtäväoliolle myös ne
    if (isset($_POST['luokka'])) {
        foreach ($_POST['luokka'] as $luokka) {
            $tehtava->setLuokat($luokka, $kayttaja_id);
        }
    }

    //tarkastetaan, onko uusi tehtäväolio kelvollinen ja jos on, lisätään se kantaan, 
    //siirrytään tehtävälistaan ja ilmoitetaan käyttäjälle onnistuneesta lisäyksestä
    if ($tehtava->onkoKelvollinen()) {
        $tehtava->lisaaKantaan();
        siirrySivulle('tehtavalista.php');
        $_SESSION['ilmoitus'] = "Tehtävä lisätty onnistuneesti.";
        //jos tehtäväolio ei ollut kelvollinen eli tuli virheitä, 
        //näytetään ne käyttäjälle ja annetaan tilaisuus korjata lomaketta
    } else {
        $virheet = $tehtava->getVirheet();
        naytaKirjautuneelle('uusitehtava_view.php', array('tarkeysasteet' => $tarkeysasteet, 'luokat' => $luokat,
            'virheet' => $virheet, 'tehtava' => $tehtava));
    }

    //jos käyttäjä ei ole vielä lähettänyt tietoja tallenna-napilla, näytetään uusitehtävä-näkymä
} else {
    naytaKirjautuneelle('uusitehtava_view.php', array('tarkeysasteet' => $tarkeysasteet, 'luokat' => $luokat));
}
?>