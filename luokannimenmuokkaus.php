<?php

require_once 'libs/common.php';
require_once 'libs/models/luokka.php';

//käyttäjä saadaan sessiosta
$kayttaja_id = (int) $_SESSION['kayttaja_id'];

//voidaan muokata vain luokkaa, jonka id on annettu ja joka kuuluu kyseiselle käyttäjälle
if (isset($_GET['id']) && Luokka::etsi($_GET['id'], $kayttaja_id) != NULL) {
    $id = (int) $_GET['id'];
    $luokka = Luokka::etsi($id, $kayttaja_id);
    naytaKirjautuneelle('luokannimenmuokkaus_view.php', array('luokka' => $luokka));

//kun lomake on lähetetty painamalla tallenna-nappia
} else if (isset($_POST['id'])) {
    $id = (int) $_POST['id'];
    
    //etsitään kyseinen luokka kannasta ja asetetaan sille nimi ja käyttäjä
    $luokka = Luokka::etsi($id, $kayttaja_id);
    $luokka->setNimi($_POST['nimi']);
    $luokka->setKayttaja_id($kayttaja_id);

    //tarkastetaan, onko muokattu luokka kelvollinen ja jos on, muokataan kantaa, 
    //siirrytään luokanmuokkaussivulle ja ilmoitetaan käyttäjälle onnistuneesta muokkauksesta
    if ($luokka->onkoKelvollinen()) {
        $luokka->muokkaaKantaa($id);
        siirrySivulle('luokanmuokkaus.php');
        $_SESSION['ilmoitus'] = "Luokkaa muokattu onnistuneesti.";
        
    //muussa tapauksessa ilmoitetaan käyttäjälle virheet ja annetaan käyttäjän korjata ne
    } else {
        $virheet = $luokka->getVirheet();
        $luokat = Luokka::getKayttajanluokat($kayttaja_id);
        naytaKirjautuneelle('luokannimenmuokkaus_view.php', array('virheet' => $virheet, 'luokat'=>$luokat, 'luokka'=>$luokka));
    }
    
//jos käyttäjä yritti muokata toisen henkilön luokkaa tai ei antanut id:tä, siirrytään virhesivulle
} else {
    naytaKirjautuneelle('luokannimenmuokkaus_view.php', array());
}