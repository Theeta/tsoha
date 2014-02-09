<?php

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

    public function setId($id) {
        $this->id = $id;
    }

    public function setNimi($nimi) {
        $this->nimi = $nimi;
    }

    public function setTunnus($tunnus) {
        $this->tunnus = $tunnus;
    }

    public function setSalasana($salasana) {
        $this->salasana = $salasana;
    }

    public static function getKayttajat() {
        $sql = "SELECT id, nimi, tunnus, salasana from kayttaja";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute();

        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $kayttaja = new Kayttaja($tulos->id, $tulos->nimi, $tulos->tunnus, $tulos->salasana);
            $tulokset[] = $kayttaja;
        }
        return $tulokset;
    }

    /* Etsitään kannasta käyttäjätunnuksella ja salasanalla käyttäjäriviä */

    public static function getKayttajaTunnuksilla($kayttaja, $salasana) {
        $sql = "SELECT id, nimi, tunnus, salasana from kayttaja where tunnus = ? AND salasana = ? LIMIT 1";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($kayttaja, $salasana));

        $tulos = $kysely->fetchObject();
        if ($tulos == null) {
            return null;
        } else {
            $kayttaja = new Kayttaja();
            $kayttaja->id = $tulos->id;
            $kayttaja->nimi = $tulos->nimi;
            $kayttaja->tunnus = $tulos->tunnus;
            $kayttaja->salasana = $tulos->salasana;

            return $kayttaja;
        }
    }

}