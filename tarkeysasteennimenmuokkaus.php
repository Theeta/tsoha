<?php

require_once 'libs/common.php';
require_once 'libs/models/tarkeysaste.php';

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $tarkeysaste = Tarkeysaste::etsi($id);

    naytaKirjautuneelle('tarkeysasteennimenmuokkaus_view.php', array('tarkeysaste' => $tarkeysaste));
} else if (isset($_POST['nimi'])) {
    $id = (int) $_POST['id'];
    $nimi = $_POST['nimi'];
    $tarkeysaste = Tarkeysaste::etsi($id);
    $tarkeysaste->setNimi($nimi);

    $tarkeysaste->setKayttaja_id($_SESSION['kayttaja_id']);

    if ($tarkeysaste->onkoKelvollinen()) {
        $tarkeysaste->muokkaaKantaa($id);
        siirrySivulle('tarkeysasteenmuokkaus.php');
        $_SESSION['ilmoitus'] = "Tärkeysastetta muokattu onnistuneesti.";
    } else {
        $virheet = $tarkeysaste->getVirheet();
        $kayttaja_id = (int) $_SESSION['kayttaja_id'];

        $tarkeysasteet = Tarkeysaste::getTarkeysasteet($kayttaja_id);
        naytaKirjautuneelle('tarkeysasteenmuokkaus_view.php', array('virheet' => $virheet, 'tarkeysasteet'=>$tarkeysasteet));
    }
} else {
    naytaKirjautuneelle('tarkeysasteennimenmuokkaus_view.php', array());
}