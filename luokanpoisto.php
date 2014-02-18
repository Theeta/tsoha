<?php

require_once 'libs/common.php';
require_once 'libs/models/luokka.php';

if (!empty($_POST['id'])){
    $id = (int)$_POST['id'];
    Luokka::poistaKannasta($id);
    $_SESSION['ilmoitus'] = "Luokka poistettu onnistuneesti.";
}
siirrySivulle('luokanmuokkaus.php');

?>
