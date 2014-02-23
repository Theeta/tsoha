<?php

require_once 'libs/common.php';
require_once 'libs/models/kayttaja.php';

//käyttäjä voi poistaa vain itsensä
if (!empty($_POST['id']) && $_POST['id'] == $_SESSION['kayttaja_id']) {
    $id = (int) $_POST['id'];

    //käyttäjä kirjautuu ensin ulos
    unset($_SESSION['kayttaja']);
    unset($_SESSION['kayttaja_id']);

    //ja sitten käyttäjä poistetaan kannasta
    Kayttaja::poistaKannasta($id);
    $_SESSION['ilmoitus'] = "Käyttäjä poistettu onnistuneesti.";

    //näytetään virhesivu, jos yrittää poistaa toista käyttäjää
} else {
    naytaKirjautuneelle('vaarahenkilo.php', array());
}

//lopuksi siirrytään sisäänkirjautumissivulle
siirrySivulle('login.php');
?>
