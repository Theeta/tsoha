<?php

require_once 'libs/common.php';
require_once 'libs/models/tehtava.php';
require_once 'libs/models/luokka.php';

//aina aluksi näytetään ensimmäinen sivu
$sivu = 1;

//jos käyttäjä haluaa nähdä jonkin muun sivun, näytetään sitten se
if (isset($_GET['sivu'])) {
    $sivu = (int) $_GET['sivu'];

    //Sivunumero ei saa olla pienempi kuin yksi
    if ($sivu < 1)
        $sivu = 1;
}

//kuinka monta tehtävää yhdellä sivulla näytetään
$montakotehtavaasivulla = 6;

//aluksi ei ole valittuna tiettyä tärkeysastetta tai luokkaa
$tarkeysaste_id = null;
$luokka_id = null;

//käyttäjä saadaan sessiosta
$id = (int) $_SESSION['kayttaja_id'];

//tärkeysasteet ja luokat kuuluvat kyseiselle käyttäjälle
$tarkeysasteet = Tarkeysaste::getTarkeysasteet($id);
$luokat = Luokka::getKayttajanluokat($id);

//jos käyttäjä on valinnut tietyn tärkeysasteen ja luokan
if (isset($_GET['tarkeysaste']) && isset($_GET['luokka'])) {

    //tarkastetaan kuuluvatko tärkeysaste ja luokka kyseiselle käyttäjälle
    if (Tarkeysaste::etsi($_GET['tarkeysaste'], $id) != NULL && Luokka::etsi($_GET['luokka'], $id) != NULL) {
        $tarkeysaste_id = (int) $_GET['tarkeysaste'];
        $luokka_id = (int) $_GET['luokka'];

        //haetaan tehtävät, joilla on kyseinen tärkeysaste ja luokka ja selvitetään niiden lukumäärä
        $tehtavat = Tehtava::getKayttajanTehtavatTarkeysasteellaJaLuokalla($id, $tarkeysaste_id, $luokka_id, $sivu, $montakotehtavaasivulla);
        $tehtavaLkm = Tehtava::lukumaaraTarkeysasteellaJaLuokalla($id, $tarkeysaste_id, $luokka_id);
    }
    //jos käyttäjä valitsee toisen käyttäjän tärkeysasteen tai luokan, näytetään virhesivu
    else {
        naytaKirjautuneelle('vaarahenkilo.php', array());
    }

//jos käyttäjä on valinnut tietyn tärkeysasteen
} elseif (isset($_GET['tarkeysaste'])) {

    //tarkastetaan kuuluko kyseinen tärkeysaste kyseiselle käyttäjälle
    if (Tarkeysaste::etsi($_GET['tarkeysaste'], $id) != NULL) {
        $tarkeysaste_id = (int) $_GET['tarkeysaste'];

        //haetaan tehtävät, joilla on kyseinen tärkeysaste ja lasketaan niiden lukumäärä
        $tehtavat = Tehtava::getKayttajanTehtavatTarkeysasteella($id, $sivu, $montakotehtavaasivulla, $tarkeysaste_id);
        $tehtavaLkm = Tehtava::lukumaaraTarkeysasteella($id, $tarkeysaste_id);
    }

    //jos käyttäjä yrittää katsella toisen henkilön tärkeysasteeseen kuuluvia tehtäviä, näytetään virhesivu
    else {
        naytaKirjautuneelle('vaarahenkilo.php', array());
    }

//jos käyttäjä on valinnut tietyn luokan
} elseif (isset($_GET['luokka'])) {

    //tarkastetaan kuuluuko kyseinen luokka kyseiselle käyttäjälle
    if (Luokka::etsi($_GET['luokka'], $id)) {
        $luokka_id = (int) $_GET['luokka'];

        //haetaan tehtävät, jotka kuuluvat kyseiseen luokkaan ja lasketaan niiden lukumäärä
        $tehtavat = Tehtava::getKayttajanTehtavatLuokalla($id, $sivu, $montakotehtavaasivulla, $luokka_id);
        $tehtavaLkm = Tehtava::lukumaaraLuokalla($id, $luokka_id);
    }
    //jos käyttäjä yrittää katsella toisen henkilön luokkaan kuuluvia tehtäviä, näytetään virhesivu
    else {
        naytaKirjautuneelle('vaarahenkilo.php', array());
    }

//jos luokkaa tai tärkeysastetta ei ole valittu, haetaan kaikki käyttäjän tehtävät ja lasketaan niiden lukumäärä
} else {
    $tehtavat = Tehtava::getKayttajanTehtavat($id, $sivu, $montakotehtavaasivulla);
    $tehtavaLkm = Tehtava::lukumaara($id);
}

//kuinka monelle sivulle käyttäjän tehtävät jakautuvat
$sivuja = ceil($tehtavaLkm / $montakotehtavaasivulla);

//lopuksi näytetään kirjautuneelle käyttäjälle tehtävälista halutuilla parametreilla
naytaKirjautuneelle('tehtavalista_view.php', array('tehtavat' => $tehtavat, 'lukumaara' => $tehtavaLkm,
    'sivu' => $sivu, 'sivuja' => $sivuja, 'tarkeysasteet' => $tarkeysasteet, 'tarkeysaste' => $tarkeysaste_id,
    'luokat' => $luokat, 'luokka' => $luokka_id));
?>