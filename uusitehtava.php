<?php

require_once 'libs/common.php';
require_once 'libs/models/tehtava.php';

$tarkeysasteet = Tarkeysaste::getTarkeysasteet($_SESSION['kayttaja_id']);


if (isset($_POST['kuvaus'])) {
    
    $tehtava = new Tehtava(null, null, null, null, null);
    $tehtava->setKayttaja_id($_SESSION['kayttaja_id']);
    
    $tehtava->setKuvaus($_POST['kuvaus']);
    $tehtava->setTarkeysaste_id($_POST['tarkeysaste_id']);

    if ($tehtava->onkoKelvollinen()) {
        $tehtava->lisaaKantaan();
        siirrySivulle('tehtavalista.php');
        $_SESSION['ilmoitus'] = "Tehtävä lisätty onnistuneesti.";
    } else {
        $virheet = $tehtava->getVirheet();
        naytaKirjautuneelle('uusitehtava_view.php', array('tarkeysasteet' => $tarkeysasteet, 'virheet' => $virheet));
    }
}
else {
    naytaKirjautuneelle('uusitehtava_view.php', array('tarkeysasteet' => $tarkeysasteet));
}


?>