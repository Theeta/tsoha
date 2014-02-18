<?php
require_once 'libs/common.php';
require_once 'libs/models/luokka.php';

$id = (int)$_SESSION['kayttaja_id'];
  
$luokat = Luokka::getKayttajanluokat($id);

naytaKirjautuneelle('luokanmuokkaus_view.php', array('luokat'=>$luokat));
?>