<?php
require_once 'libs/common.php';
require_once 'libs/models/tarkeysaste.php';

$id = (int)$_SESSION['kayttaja_id'];
  
$tarkeysasteet = Tarkeysaste::getTarkeysasteet($id);

naytaKirjautuneelle('tarkeysasteenmuokkaus_view.php', array('tarkeysasteet'=>$tarkeysasteet));
?>