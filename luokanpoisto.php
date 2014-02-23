<?php

require_once 'libs/common.php';
require_once 'libs/models/luokka.php';

//vain kirjautunut käyttäjä voi poistaa luokkia
if (onkoKirjautunut()) {

    //poistettavan luokan id
    if (!empty($_POST['id'])) {
        $id = (int) $_POST['id'];

        //käyttäjä voi poistaa vain omia luokkiaan
        if (Luokka::etsi($id, $_SESSION['kayttaja_id']) != null) {
            Luokka::poistaKannasta($id);
            $_SESSION['ilmoitus'] = "Luokka poistettu onnistuneesti.";
        }

        //näytetään virhesivu, jos yrittää poistaa toisen luokkaa
        else {
            naytaKirjautuneelle('vaarahenkilo.php', array());
        }
    }
}

//lopuksi palataan luokanmuokkauslistaan
siirrySivulle('luokanmuokkaus.php');
?>
