<?php

//require 'tietokantayhteys.php';

class Kayttaja {

    private $id;
    private $nimi;
    private $tunnus;
    private $salasana;

    public function __construct($id, $nimi, $tunnus, $salasana) {
        $this->id = $id;
        $this->nimi = $nimi;
        $this->tunnus = $tunnus;
        $this->salasana = $salasana;
    }

    public function getId() {
        return $this->id;
    }

    public function getNimi() {
        return $this->nimi;
    }

    public function getTunnus() {
        return $this->tunnus;
    }

    public function getSalasana() {
        return $this->salasana;
    }

    /* Tähän gettereitä ja settereitä */

    public static function getKayttajat() {
        $sql = "SELECT id, nimi, tunnus, salasana from kayttaja";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute();

        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $kayttaja = new Kayttaja($tulos->id, $tulos->nimi, $tulos->tunnus, $tulos->salasana);
            //$array[] = $muuttuja; lisää muuttujan arrayn perään. 
            //Se vastaa melko suoraan ArrayList:in add-metodia.
            $tulokset[] = $kayttaja;
        }
        return $tulokset;
    }

}