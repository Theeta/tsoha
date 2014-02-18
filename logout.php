<?php
require_once 'libs/common.php';
  //Poistetaan istunnosta merkintä kirjautuneesta käyttäjästä -> Kirjaudutaan ulos
  unset($_SESSION['kayttaja']);
  unset($_SESSION['kayttaja_id']);

  //Ohjataan käyttäjä kirjautumissivulle
  siirrySivulle('login.php');
?>