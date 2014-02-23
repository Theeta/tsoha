<?php

require_once 'libs/common.php';
require_once 'libs/models/tarkeysaste.php';

//vain kirjautunut käyttäjä voi poistaa tärkeysasteita
if (onkoKirjautunut()) {

    //poistettavan tärkeysasteen id
    if (!empty($_POST['id'])) {
        $id = (int) $_POST['id'];

        //käyttäjä voi poistaa vain omia tärkeysasteitaan
        if (Tarkeysaste::etsi($id, $_SESSION['kayttaja_id']) != null) {
            Tarkeysaste::poistaKannasta($id);
            $_SESSION['ilmoitus'] = "Tärkeysaste poistettu onnistuneesti.";
        }

        //näytetään virhesivu, jos yrittää poistaa toisen tärkeysastetta
        else {
            naytaKirjautuneelle('vaarahenkilo.php', array());
        }
    }
}

//lopuksi palataan tehtävälistaan
siirrySivulle('tarkeysasteenmuokkaus.php');
?>
