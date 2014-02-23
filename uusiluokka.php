<?php

require_once 'libs/common.php';
require_once 'libs/models/luokka.php';

//käyttäjä saadaan sessiosta ja käyttäjälle haetaan omat luokat
$kayttaja_id = $_SESSION['kayttaja_id'];
$luokat = Luokka::getKayttajanluokat($kayttaja_id);

//jos on lähetetty lomake eli painettu tallenna-nappia
if (isset($_POST['lahetetty'])) {

    //luodaan uusi luokkaolio ja asetetaan sille nimi ja käyttäjä
    $luokka = new Luokka(null, null, null);
    $luokka->setNimi($_POST['nimi']);
    $luokka->setKayttaja_id($_SESSION['kayttaja_id']);

    //tarkastetaan, onko uusi luokkaolio kelvollinen ja jos on, lisätään se kantaan, 
    //palataan luokkalistaan ja ilmoitetaan käyttäjälle onnistuneesta lisäyksestä
    if ($luokka->onkoKelvollinen()) {
        $luokka->lisaaKantaan();
        siirrySivulle('luokanmuokkaus.php');
        $_SESSION['ilmoitus'] = "Luokka lisätty onnistuneesti.";

        //jos luokkaolio ei ollut kelvollinen eli tuli virheitä, 
        //näytetään ne käyttäjälle ja annetaan tilaisuus korjata lomaketta
    } else {
        $virheet = $luokka->getVirheet();
        naytaKirjautuneelle('luokanmuokkaus_view.php', array('luokat' => $luokat, 'luokka' => $luokka, 'virheet' => $virheet));
    }
}
//jos lomaketta ei ole lähetetty eli tallenna-nappia ei ole painettu, näytetään vain lista luokista
else {
    naytaKirjautuneelle('luokanmuokkaus_view.php', array('luokat' => $luokat));
}
?>
