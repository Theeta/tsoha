<?php

require_once 'libs/common.php';
require_once 'libs/models/tehtava.php';
require_once 'libs/models/luokka.php';

$sivu = 1;

if (isset($_GET['sivu'])) {
    $sivu = (int) $_GET['sivu'];

    //Sivunumero ei saa olla pienempi kuin yksi
    if ($sivu < 1)
        $sivu = 1;
}

$montakotehtavaasivulla = 4;
$tarkeysaste_id = null;
$luokka_id = null;

$id = (int) $_SESSION['kayttaja_id'];
$tarkeysasteet = Tarkeysaste::getTarkeysasteet($id);
$luokat = Luokka::getKayttajanluokat($id);

if (isset($_GET['tarkeysaste']) && isset($_GET['luokka'])){
    $tarkeysaste_id = (int) $_GET['tarkeysaste'];
    $luokka_id = (int) $_GET['luokka'];
    $tehtavat = Tehtava::getKayttajanTehtavatTarkeysasteellaJaLuokalla($id, $sivu, $montakotehtavaasivulla, $tarkeysaste_id, $luokka_id);
    $tehtavaLkm = Tehtava::lukumaaraTarkeysasteellaJaLuokalla($id, $tarkeysaste_id, $luokka_id);
    
}
elseif (isset($_GET['tarkeysaste'])) {
    $tarkeysaste_id = (int) $_GET['tarkeysaste'];
    $tehtavat = Tehtava::getKayttajanTehtavatTarkeysasteella($id, $sivu, $montakotehtavaasivulla, $tarkeysaste_id);
    $tehtavaLkm = Tehtava::lukumaaraTarkeysasteella($id, $tarkeysaste_id);
    
} 
elseif (isset ($_GET['luokka'])) {
    $luokka_id = (int) $_GET['luokka'];
    $tehtavat = Tehtava::getKayttajanTehtavatLuokalla($id, $sivu, $montakotehtavaasivulla, $luokka_id);
    $tehtavaLkm = Tehtava::lukumaaraLuokalla($id, $luokka_id);
}
else {
    $tehtavat = Tehtava::getKayttajanTehtavat($id, $sivu, $montakotehtavaasivulla);
    $tehtavaLkm = Tehtava::lukumaara($id);
    
}


$sivuja = ceil($tehtavaLkm / $montakotehtavaasivulla);
naytaKirjautuneelle('tehtavalista_view.php', array('tehtavat' => $tehtavat, 'lukumaara' => $tehtavaLkm,
    'sivu' => $sivu, 'sivuja' => $sivuja, 'tarkeysasteet' => $tarkeysasteet, 'tarkeysaste'=>$tarkeysaste_id,
    'luokat'=>$luokat, 'luokka'=>$luokka_id));
?>