<?php
require_once 'libs/common.php';
  //Poistetaan istunnosta merkintä kirjautuneesta käyttäjästä -> Kirjaudutaan ulos
  unset($_SESSION['kayttaja']);

  //Yleensä kannattaa ulkos kirjautumisen jälkeen ohjata käyttäjä kirjautumissivulle
  siirrySivulle('login.php');
?>