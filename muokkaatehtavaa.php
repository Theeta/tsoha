<?php

require_once 'libs/common.php';
require_once 'libs/models/tehtava.php';

$id = (int)$_POST['id'];
$tehtava = Tehtava::etsi($id);
$tehtava->setKuvaus(($_POST['kuvaus']));
$tarkeysasteet = Tarkeysaste::getTarkeysasteet($_SESSION['kayttaja_id']);

$tehtava->setTarkeysaste_id(($_POST['tarkeysaste_id']));

$tehtava->setKayttaja_id($_SESSION['kayttaja_id']);

if ($tehtava->onkoKelvollinen()) {
    $tehtava->muokkaaKantaa($id);
    siirrySivulle('tehtavalista.php');
    $_SESSION['ilmoitus'] = "Tehtävää muokattu onnistuneesti.";
    
} else {
    $virheet = $tehtava->getVirheet();
}

naytaKirjautuneelle('tehtavanmuokkaus_view.php', array('tehtava'=>$tehtava, 'virheet'=>$virheet, 'tarkeysasteet' => $tarkeysasteet));
?>