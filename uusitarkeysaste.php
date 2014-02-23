<?php

require_once 'libs/common.php';
require_once 'libs/models/tarkeysaste.php';

//käyttäjä saadaan sessiosta ja käyttäjälle haetaan omat tärkeysasteet
$kayttaja_id = $_SESSION['kayttaja_id'];
$tarkeysasteet = Tarkeysaste::getTarkeysasteet($kayttaja_id);

//jos on lähetetty lomake eli painettu tallenna-nappia
if (isset($_POST['lahetetty'])) {

    //luodaan uusi tärkeysasteolio ja asetetaan sille nimi ja käyttäjä
    $tarkeysaste = new Tarkeysaste(null, null, null);
    $tarkeysaste->setNimi($_POST['nimi']);
    $tarkeysaste->setKayttaja_id($_SESSION['kayttaja_id']);

    //tarkastetaan, onko uusi tärkeysasteolio kelvollinen ja jos on, lisätään se kantaan, 
    //palataan tärkeysastelistaan ja ilmoitetaan käyttäjälle onnistuneesta lisäyksestä
    if ($tarkeysaste->onkoKelvollinen()) {
        $tarkeysaste->lisaaKantaan();
        siirrySivulle('tarkeysasteenmuokkaus.php');
        $_SESSION['ilmoitus'] = "Tärkeysaste lisätty onnistuneesti.";
        
        //jos tärkeysasteolio ei ollut kelvollinen eli tuli virheitä, 
        //näytetään ne käyttäjälle ja annetaan tilaisuus korjata lomaketta
    } else {
        $virheet = $tarkeysaste->getVirheet();
        naytaKirjautuneelle('tarkeysasteenmuokkaus_view.php', array('tarkeysasteet' => $tarkeysasteet, 'tarkeysaste' => $tarkeysaste, 'virheet' => $virheet));
    }
}
//jos lomaketta ei ole lähetetty eli tallenna-nappia ei ole painettu, näytetään vain lista tärkeysasteista
else {
    naytaKirjautuneelle('tarkeysasteenmuokkaus_view.php', array('tarkeysasteet' => $tarkeysasteet));
}
?>
