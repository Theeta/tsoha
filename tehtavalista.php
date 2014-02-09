<?php
require_once 'libs/common.php';
require_once 'libs/models/tehtava.php';

$sivu = 1;
  if (isset($_GET['sivu'])) {
    $sivu = (int)$_GET['sivu'];

    //Sivunumero ei saa olla pienempi kuin yksi
    if ($sivu < 1) $sivu = 1;
  }
  $montakotehtavaasivulla = 3;

$tehtavat = Tehtava::getTehtavat($sivu, $montakotehtavaasivulla);

$tehtavaLkm = Tehtava::lukumaara();
$sivuja = ceil($tehtavaLkm/$montakotehtavaasivulla);
naytaKirjautuneelle('tehtavalista_view.php', array('tehtavat'=>$tehtavat, 'lukumaara'=>$tehtavaLkm, 'sivu'=>$sivu, 'sivuja'=>$sivuja));
?>