<?php

require_once 'libs/common.php';
require_once 'libs/models/tehtava.php';

if (isset($_GET['id'])){
    $id = (int)$_GET['id'];
    $tehtava = Tehtava::etsi($id);
    $tarkeysasteet = Tarkeysaste::getTarkeysasteet($_SESSION['kayttaja_id']);
    
    naytaKirjautuneelle('tehtavanmuokkaus_view.php', array('tehtava'=>$tehtava, 'tarkeysasteet'=>$tarkeysasteet));
} else {
    naytaKirjautuneelle('tehtavalista.php', array());
}
