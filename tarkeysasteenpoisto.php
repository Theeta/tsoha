<?php

require_once 'libs/common.php';
require_once 'libs/models/tarkeysaste.php';

if (!empty($_POST['id'])){
    $id = (int)$_POST['id'];
    Tarkeysaste::poistaKannasta($id);
    $_SESSION['ilmoitus'] = "Tärkeysaste poistettu onnistuneesti.";
}
siirrySivulle('tarkeysasteenmuokkaus.php');

?>
