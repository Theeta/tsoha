<?php

session_start();
require_once 'config.php';
require_once 'tietokantayhteys.php';
require_once 'libs/models/kayttaja.php';

/* Näyttää näkymätiedoston ja lähettää sille muuttujat */

function naytaNakyma($sivu, $data = array()) {
    $data = (object) $data;
    require 'views/pohja.php';
    die();
}

function siirrySivulle($sivu) {
    header('Location:' . $sivu);
}

function onkoKirjautunut() {
    if (isset($_SESSION['kayttaja'])) {
        return TRUE;
    } else {
        return FALSE;
    }
}


function naytaKirjautuneelle($nakyma, $data) {
    if (onkoKirjautunut()) {
        naytaNakyma($nakyma, $data);
    } else {
        siirrySivulle('login.php');
    }
}