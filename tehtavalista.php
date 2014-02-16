<?php

require_once 'libs/common.php';
require_once 'libs/models/tehtava.php';

$sivu = 1;
if (isset($_GET['sivu'])) {
    $sivu = (int) $_GET['sivu'];

    //Sivunumero ei saa olla pienempi kuin yksi
    if ($sivu < 1)
        $sivu = 1;
}
$montakotehtavaasivulla = 6;

$id = (int) $_SESSION['kayttaja_id'];
$tarkeysasteet = Tarkeysaste::getTarkeysasteet($_SESSION['kayttaja_id']);

if (isset($_GET['tarkeysaste'])) {
    $tarkeysaste_id = (int) $_GET['tarkeysaste'];
    $tehtavat = Tehtava::getKayttajanTehtavatTarkeysasteella($id, $sivu, $montakotehtavaasivulla, $tarkeysaste_id);
    $tehtavaLkm = Tehtava::lukumaaraTarkeysasteella($id, $tarkeysaste_id);
} else {
    $tehtavat = Tehtava::getKayttajanTehtavat($id, $sivu, $montakotehtavaasivulla);
    $tehtavaLkm = Tehtava::lukumaara($id);
}

$sivuja = ceil($tehtavaLkm / $montakotehtavaasivulla);
naytaKirjautuneelle('tehtavalista_view.php', array('tehtavat' => $tehtavat, 'lukumaara' => $tehtavaLkm, 'sivu' => $sivu, 'sivuja' => $sivuja, 'tarkeysasteet' => $tarkeysasteet));
?>