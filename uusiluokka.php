<?php

require_once 'libs/common.php';
require_once 'libs/models/luokka.php';

if (!empty($_POST['nimi'])){
    $nimi = $_POST['nimi'];
    $kayttaja_id = $_SESSION['kayttaja_id'];
    Luokka::lisaaKantaan($nimi, $kayttaja_id);
    $_SESSION['ilmoitus'] = "Luokka lisätty onnistuneesti.";
}
siirrySivulle('luokanmuokkaus.php');

?>
