<?php

require_once 'libs/common.php';
require_once 'libs/models/tehtava.php';
require_once 'libs/models/tarkeysaste.php';
require_once 'libs/models/luokka.php';

//käyttäjä saadaan sessiosta
$kayttaja_id = $_SESSION['kayttaja_id'];
$tarkeysasteet = Tarkeysaste::getTarkeysasteet($kayttaja_id);
$luokat = Luokka::getKayttajanluokat($kayttaja_id);

//tehtävänmuokkaus onnistuu vain jos yritetään muokata tiettyä tehtävää
if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    //jos käyttäjä yrittää muokata omaa tehtäväänsä, haetaan kyseinen tehtävä ja käyttäjän tärkeysasteet ja luokat
    if (Tehtava::etsi($id, $kayttaja_id) != NULL) {

        $tehtava = Tehtava::etsi($id, $kayttaja_id);

        //näytetään käyttäjälle tehtävänmuokkausnäkymä
        naytaKirjautuneelle('tehtavanmuokkaus_view.php', array('tehtava' => $tehtava, 'tarkeysasteet' => $tarkeysasteet, 'luokat' => $luokat));

        //jos käyttäjä yrittää muokata toisen käyttäjän tehtävää, näytetään virhesivu
    } else {
        naytaKirjautuneelle('vaarahenkilo.php', array());
    }
} 
//jos on lähetetty muokkauslomake eli painettu tallenna-nappia
elseif (isset($_POST['id'])) {
    $id = (int) $_POST['id'];

    //tarkastetaan, että käyttäjä yrittää muokata omaa tehtäväänsä
    if (Tehtava::etsi($id, $kayttaja_id) != NULL) {
        $tehtava = Tehtava::etsi($id, $kayttaja_id);
        
        //asetetaan tehtävälle uudet tiedot
        $tehtava->setKuvaus(($_POST['kuvaus']));
        $tehtava->setTarkeysaste_id(($_POST['tarkeysaste_id']), $kayttaja_id);
        $tehtava->setKayttaja_id($kayttaja_id);

        //jos luokkia merkitty, asetetaan nekin
        if (isset($_POST['luokka'])) {
            foreach ($_POST['luokka'] as $luokka) {
                $tehtava->setLuokat($luokka, $kayttaja_id);
            }
        }
        //jos luokkia ei ole merkitty, poistetaan tehtävältä luokat
        else {
            $tehtava->poistaLuokatKannasta($id);
        }

        //tarkastetaan, onko tehtävä muokkauksien jälkeen kelvollinen ja jos on, muokataan tietokantaa, 
        //siirrytään tehtävälistaan ja kerrotaan käyttäjälle, että muokkaus onnistui
        if ($tehtava->onkoKelvollinen()) {
            $tehtava->muokkaaKantaa($id);
            siirrySivulle('tehtavalista.php');
            $_SESSION['ilmoitus'] = "Tehtävää muokattu onnistuneesti.";
        
        //jos muokkaus ei onnistunut, näytetään käyttäjälle virheet ja annetaan mahdollisuus korjata ne
        } else {
            $virheet = $tehtava->getVirheet();
            naytaKirjautuneelle('tehtavanmuokkaus_view.php', array('tehtava' => $tehtava, 'tarkeysasteet' => $tarkeysasteet, 'luokat' => $luokat, 'virheet'=>$virheet));
        }
    }
    //jos käyttäjä yritti muokata jonkun toisen tehtävää, näytetään virhesivu
    else {
        naytaKirjautuneelle('vaarahenkilo.php', array());
    }
}
//jos ei annettu tehtävän id:tä, siirrytään tehtävälistaan
else {
    siirrySivulle('tehtavalista.php');
}
