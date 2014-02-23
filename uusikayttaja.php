<?php

require_once 'libs/common.php';
require_once 'libs/models/kayttaja.php';

//kirjautunut käyttäjä ei voi luoda uutta käyttäjää
if (isset($_SESSION['kayttaja_id'])) {
    naytaNakyma('kirjauduensinulos.php', array());
}

//jos lomake on lähetetty eli painettu luo uusi käyttäjä -nappia
if (isset($_POST['lahetetty'])) {

    //luodaan uusi käyttäjäolio ja asetetaan sille nimi, tunnus ja salasana
    $kayttaja = new Kayttaja(null, null, null, null);
    $kayttaja->setNimi($_POST['nimi']);
    $kayttaja->setTunnus($_POST['tunnus']);
    $kayttaja->setSalasana($_POST['salasana1'], $_POST['salasana2']);

    //tarkastetaan, onko käyttäjäolio kelvollinen ja jos on, lisätään se kantaan, 
    //siirrytään sisäänkirjautumissivulle ja ilmoitetaan onnistuneesta käyttäjänluonnista
    if ($kayttaja->onkoKelvollinen()) {
        $kayttaja->lisaaKantaan();
        siirrySivulle('login.php');
        $_SESSION['ilmoitus'] = "Käyttäjä luotu onnistuneesti.";

        //jos käyttäjäolio ei ole kelvollinen eli tuli virheitä, annetaan käyttäjän muokata lomaketta ja näytetään virheet
    } else {
        $virheet = $kayttaja->getVirheet();
        naytaNakyma('uusikayttaja_view.php', array('kayttaja' => $kayttaja, 'virheet' => $virheet));
    }

//jos lomaketta ei ole lähetetty, näytetään tyhjä uusikäyttäjä-näkymä
} else {
    naytaNakyma('uusikayttaja_view.php', array());
}
?>