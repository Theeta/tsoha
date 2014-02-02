<?php
 //Otetaan käyttöön kirjastotiedosto, joka hakee kasan omatekoisia yleistoimintoja, sekä malliluokka:
  require_once 'libs/common.php';
  require_once 'libs/models/kayttaja.php';
  
  //Selvitetään onko käyttäjä tehnyt haun
  $hakusana = null;
  if (!empty($_GET['haku'])) {
    $hakusana = $_GET['haku'];
  }

  //Kutsutaan malliluokan staattista metodia
  $kissat = Kissa::hae($hakusana);
  
  //Näytetään näkymä lähettäen sille muutamia muuttujia
  naytaNakymä("kissalista", array(
    'title' => "Kissalista",
    'kissat' => $kissat
  ));