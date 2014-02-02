<?php
require_once 'libs/common.php';
if (onkoKirjautunut()){
    naytaNakyma('tehtavat.php');
} else {
    siirrySivulle('login.php');
}
?>