<?php

require_once 'libs/common.php';
require_once 'libs/models/tehtava.php';
require_once 'libs/models/tarkeysaste.php';
require_once 'libs/models/luokka.php';

$kayttaja_id = $_SESSION['kayttaja_id'];
$id = (int)$_POST['id'];
$tehtava = Tehtava::etsi($id, $kayttaja_id);
$tehtava->setKuvaus(($_POST['kuvaus']));
$tarkeysasteet = Tarkeysaste::getTarkeysasteet($kayttaja_id);

$tehtava->setTarkeysaste_id(($_POST['tarkeysaste_id']), $kayttaja_id);

$tehtava->setKayttaja_id($kayttaja_id);

 if (isset($_POST['luokka'])) {
        foreach ($_POST['luokka'] as $luokka) {
            $tehtava->setLuokat($luokka, $kayttaja_id);
        }
    }

if ($tehtava->onkoKelvollinen()) {
    $tehtava->muokkaaKantaa($id);
    siirrySivulle('tehtavalista.php');
    $_SESSION['ilmoitus'] = "Tehtävää muokattu onnistuneesti.";
    
} else {
    $virheet = $tehtava->getVirheet();
}

naytaKirjautuneelle('tehtavanmuokkaus_view.php', array('tehtava'=>$tehtava, 'virheet'=>$virheet, 'tarkeysasteet' => $tarkeysasteet));
?>