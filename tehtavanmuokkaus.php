<?php

require_once 'libs/common.php';
require_once 'libs/models/tehtava.php';

if (isset($_GET['id'])){
    $tehtava = Tehtava::etsi($_GET['id']);
    naytaKirjautuneelle('tehtavanmuokkaus_view.php', array('tehtava'=>$tehtava));
} else {
    naytaKirjautuneelle('tehtavalista.php', array());
}
?>
