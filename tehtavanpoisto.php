<?php

require_once 'libs/common.php';
require_once 'libs/models/tehtava.php';

if (!empty($_POST['id'])){
    $id = (int)$_POST['id'];
    Tehtava::poistaKannasta($id);
    $_SESSION['ilmoitus'] = "Tehtävä poistettu onnistuneesti.";
}
siirrySivulle('tehtavalista.php');


?>
