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

//siirrytään tietylle sivulle
function siirrySivulle($sivu) {
    header('Location:' . $sivu);
}

//tarkastetaan, onko kirjautunutta käyttäjää
function onkoKirjautunut() {
    return isset($_SESSION['kayttaja']);
}

//näytetään tietty näkymä vain kirjautuneelle käyttäjälle
function naytaKirjautuneelle($nakyma, $data) {
    if (onkoKirjautunut()) {
        naytaNakyma($nakyma, $data);
    } else {
        siirrySivulle('login.php');
    }
}