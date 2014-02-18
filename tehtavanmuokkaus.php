<?php

require_once 'libs/common.php';
require_once 'libs/models/tehtava.php';
require_once 'libs/models/tarkeysaste.php';
require_once 'libs/models/luokka.php';

$kayttaja_id = $_SESSION['kayttaja_id'];

if (isset($_GET['id'])){
    $id = (int)$_GET['id'];
    $tehtava = Tehtava::etsi($id, $kayttaja_id);
    $tarkeysasteet = Tarkeysaste::getTarkeysasteet($kayttaja_id);
    $luokat = Luokka::getKayttajanluokat($kayttaja_id);
    
    naytaKirjautuneelle('tehtavanmuokkaus_view.php', array('tehtava'=>$tehtava, 'tarkeysasteet'=>$tarkeysasteet, 'luokat'=>$luokat));
} else {
    naytaKirjautuneelle('tehtavalista.php', array());
}
