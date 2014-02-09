<?php

require_once 'libs/common.php';
require_once 'libs/models/tehtava.php';

if (empty($_POST['kuvaus']) && empty($_POST['tarkeysaste_id'])) {
    naytaKirjautuneelle('uusitehtava_view.php', array());
}

$uusitehtava = new Tehtava(null, null, null, null, null);

if (empty($_POST["kuvaus"])) {
    naytaNakyma("uusitehtava_view.php", array('virheet' => "Anna tehtävän kuvaus"));
}
$uusitehtava->setKuvaus($_POST['kuvaus']);

if (empty($_POST["tarkeysaste_id"])) {
    naytaNakyma("uusitehtava_view.php", array('virheet' => "Anna tehtävän tärkeysaste"));
}
$uusitehtava->setTarkeysaste_id($_POST['tarkeysaste_id']);


$uusitehtava->setKayttaja_id($_SESSION['kayttaja_id']);


//Pyydetään Kissa-oliota tarkastamaan syötetyt tiedot.
if ($uusitehtava->onkoKelvollinen()) {
    $uusitehtava->lisaaKantaan();
    siirrySivulle('tehtavalista.php');
    $_SESSION['ilmoitus'] = "Tehtävä lisätty onnistuneesti.";
} else {
    $virheet = $uusitehtava->getVirheet();
}

naytaKirjautuneelle('uusitehtava_view.php', array('tehtava'=>$uusitehtava, 'virheet'=>$virheet));
?>