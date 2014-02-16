<?php

require_once 'libs/common.php';
require_once 'libs/models/tarkeysaste.php';

if (!empty($_POST['nimi'])){
    $nimi = $_POST['nimi'];
    $kayttaja_id = $_SESSION['kayttaja_id'];
    Tarkeysaste::lisaaKantaan($nimi, $kayttaja_id);
    $_SESSION['ilmoitus'] = "Tärkeysaste lisätty onnistuneesti.";
}
siirrySivulle('tarkeysasteenmuokkaus.php');

?>
