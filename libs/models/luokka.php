<?php

class Luokka {

    private $id;
    private $nimi;
    private $kayttaja_id;
    private $virheet;

    public function __construct($id, $nimi, $kayttaja_id) {
        $this->id = $id;
        $this->nimi = $nimi;
        $this->kayttaja_id = $kayttaja_id;
        $this->virheet = array();
    }

    public function getId() {
        return $this->id;
    }

    public function getNimi() {
        return $this->nimi;
    }

    public function getKayttaja_id() {
        return $this->kayttaja_id;
    }

    public function getVirheet() {
        return $this->virheet;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNimi($nimi) {
        $this->nimi = $nimi;

        if (trim($this->nimi) == '') {
            $this->virheet['nimi'] = "Tärkeysasteen nimi ei saa olla tyhjä.";
        } elseif (strlen($this->nimi) > 255) {
            $this->virheet['nimi'] = "Tärkeysasteen nimen on oltava alle 255 merkkiä.";
        } else {
            unset($this->virheet['nimi']);
        }
        $this->nimi = $nimi;
    }

    public function setKayttaja_id($kayttaja_id) {
        $this->kayttaja_id = $kayttaja_id;
    }

    //haetaan tietyn käyttäjän tietyn tehtävän luokat
    public static function getTehtavanluokat($tehtava_id, $kayttaja_id) {
        $sql = "SELECT luokka.id as id, luokka.nimi as nimi, luokka.kayttaja_id as kayttaja_id, tehtavanluokat.tehtava_id, tehtavanluokat.luokka_id FROM luokka, tehtavanluokat 
            WHERE tehtavanluokat.tehtava_id = ? AND luokka.kayttaja_id = ? AND luokka.id = tehtavanluokat.luokka_id";

        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($tehtava_id, $kayttaja_id));

        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $luokka = new Luokka($tulos->id, $tulos->nimi, $tulos->kayttaja_id);
            $tulokset[] = $luokka;
        }
        return $tulokset;
    }

    //haetaan tietyn käyttäjän kaikki luokat
    public static function getKayttajanluokat($kayttaja_id) {
        $sql = "SELECT id, nimi, kayttaja_id FROM luokka WHERE kayttaja_id = ?";

        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($kayttaja_id));

        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $luokka = new Luokka($tulos->id, $tulos->nimi, $tulos->kayttaja_id);
            $tulokset[] = $luokka;
        }
        return $tulokset;
    }

    //etsitään yksittäinen, tietyn käyttäjän luokka
    public static function etsi($id, $kayttaja_id) {
        $sql = "SELECT * FROM luokka WHERE id = ? and kayttaja_id = ? LIMIT 1";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($id, $kayttaja_id));
        $tulos = $kysely->fetchObject();
        if ($tulos == null) {
            return null;
        } else {
            $luokka = new Luokka($tulos->id, $tulos->nimi, $tulos->kayttaja_id);
            return $luokka;
        }
    }

    //lisää uuden luokan tietokantaan
    public function lisaaKantaan($nimi, $kayttaja_id) {
        $sql = "INSERT INTO luokka(nimi, kayttaja_id) VALUES(?,?) RETURNING id";
        $kysely = getTietokantayhteys()->prepare($sql);

        $ok = $kysely->execute(array($nimi, $kayttaja_id));
        if ($ok) {
            $id = $kysely->fetchColumn();
        }
        return $ok;
    }

    //muokkaa tiettyä luokkaa tietokannassa
    public function muokkaaKantaa($id) {

        $sql = "UPDATE luokka SET nimi=?, kayttaja_id=? WHERE id=?";
        $kysely = getTietokantayhteys()->prepare($sql);

        $ok = $kysely->execute(array($this->nimi, $this->kayttaja_id, $id));
        if ($ok) {
            $this->id = $kysely->fetchColumn();
        }
        return $ok;
    }

    //poistaa tietyn luokan tietokannasta
    public function poistaKannasta($id) {
        $sql = "DELETE FROM luokka WHERE id=?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($id));
    }

    public function onkoKelvollinen() {
        return empty($this->virheet);
    }

}