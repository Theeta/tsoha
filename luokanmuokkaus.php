<?php
require_once 'libs/common.php';
require_once 'libs/models/luokka.php';

//käyttäjä saadaan sessiosta
$id = (int)$_SESSION['kayttaja_id'];
  
//haetaan käyttäjän luokat
$luokat = Luokka::getKayttajanluokat($id);

//näytetään vain kirjautuneelle käyttäjälle lista hänen luokistaan
naytaKirjautuneelle('luokanmuokkaus_view.php', array('luokat'=>$luokat));
?>