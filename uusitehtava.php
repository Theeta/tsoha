<?php

require_once 'libs/common.php';
require_once 'libs/models/tehtava.php';
require_once 'libs/models/luokka.php';

$kayttaja_id = $_SESSION['kayttaja_id'];
$tarkeysasteet = Tarkeysaste::getTarkeysasteet($kayttaja_id);
$luokat = Luokka::getKayttajanluokat($kayttaja_id);


if (isset($_POST['kuvaus'])) {

    $tehtava = new Tehtava(null, null, null, null, null);
    $tehtava->setKayttaja_id($kayttaja_id);

    $tehtava->setKuvaus($_POST['kuvaus']);
    $tehtava->setTarkeysaste_id($_POST['tarkeysaste_id'], $kayttaja_id);

    if (isset($_POST['luokka'])) {
        foreach ($_POST['luokka'] as $luokka) {
            $tehtava->setLuokat($luokka, $kayttaja_id);
        }
    }

    if ($tehtava->onkoKelvollinen()) {
        $tehtava->lisaaKantaan();
        siirrySivulle('tehtavalista.php');
        $_SESSION['ilmoitus'] = "Tehtävä lisätty onnistuneesti.";
    } else {
        $virheet = $tehtava->getVirheet();
        naytaKirjautuneelle('uusitehtava_view.php', array('tarkeysasteet' => $tarkeysasteet, 'virheet' => $virheet));
    }
} else {
    naytaKirjautuneelle('uusitehtava_view.php', array('tarkeysasteet' => $tarkeysasteet, 'luokat' => $luokat));
}
?>