<?php

require_once 'libs/common.php';
require_once 'libs/models/tehtava.php';

//vain kirjautunut käyttäjä voi poistaa tehtäviä
if (onkoKirjautunut()) {

    //poistettavan tehtävän id
    if (!empty($_POST['id'])) {
        $id = (int) $_POST['id'];

        //käyttäjä voi poistaa vain omia tehtäviään
        if (Tehtava::etsi($id, $_SESSION['kayttaja_id']) != null) {
            Tehtava::poistaKannasta($id);
            $_SESSION['ilmoitus'] = "Tehtävä poistettu onnistuneesti.";
        }

        //näytetään virhesivu, jos yrittää poistaa toisen tehtävää
        else {
            naytaKirjautuneelle('vaarahenkilo.php', array());
        }
    }
}

//lopuksi palataan tehtävälistaan
siirrySivulle('tehtavalista.php');
?>
