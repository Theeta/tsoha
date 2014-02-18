<?php

require_once 'libs/common.php';
require_once 'libs/models/luokka.php';

$kayttaja_id = (int) $_SESSION['kayttaja_id'];

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $luokka = Luokka::etsi($id, $kayttaja_id);

    naytaKirjautuneelle('luokannimenmuokkaus_view.php', array('luokka' => $luokka));
} else if (isset($_POST['nimi'])) {
    $id = (int) $_POST['id'];
    $nimi = $_POST['nimi'];
    $luokka = Luokka::etsi($id, $kayttaja_id);
    $luokka->setNimi($nimi);

    $luokka->setKayttaja_id($kayttaja_id);

    if ($luokka->onkoKelvollinen()) {
        $luokka->muokkaaKantaa($id);
        siirrySivulle('luokanmuokkaus.php');
        $_SESSION['ilmoitus'] = "Luokkaa muokattu onnistuneesti.";
    } else {
        $virheet = $luokka->getVirheet();

        $luokat = Luokka::getKayttajanluokat($kayttaja_id);
        naytaKirjautuneelle('luokanmuokkaus_view.php', array('virheet' => $virheet, 'luokat'=>$luokat));
    }
} else {
    naytaKirjautuneelle('luokannimenmuokkaus_view.php', array());
}