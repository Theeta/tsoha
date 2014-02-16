<?php

require_once 'tarkeysaste.php';

class Tehtava {

    private $id;
    private $kuvaus;
    private $kayttaja_id;
    private $tarkeysaste_id;
    private $tarkeysaste;
    private $virheet = array();

    public function __construct($id, $kuvaus, $kayttaja_id, $tarkeysaste_id, $tarkeysaste) {
        $this->id = $id;
        $this->kuvaus = $kuvaus;
        $this->kayttaja_id = $kayttaja_id;
        $this->tarkeysaste_id = $tarkeysaste_id;
        $this->tarkeysaste = $tarkeysaste;
    }

    public function getId() {
        return $this->id;
    }

    public function getKuvaus() {
        return $this->kuvaus;
    }

    public function getKayttaja_id() {
        return $this->kayttaja_id;
    }

    public function getTarkeysaste_id() {
        return $this->tarkeysaste_id;
    }

    public function getTarkeysaste() {
        return $this->tarkeysaste;
    }

    public function getVirheet() {
        return $this->virheet;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setKuvaus($kuvaus) {
        $this->kuvaus = $kuvaus;

        if (trim($this->kuvaus) == '') {
            $this->virheet['kuvaus'] = "Kuvaus ei saa olla tyhjä.";
        } else {
            unset($this->virheet['kuvaus']);
        }
    }

    public function setKayttaja_id($kayttaja_id) {
        $this->kayttaja_id = $kayttaja_id;
    }

    public function setTarkeysaste_id($tarkeysaste_id) {
        $this->tarkeysaste_id = $tarkeysaste_id;

        if (Tarkeysaste::etsi($tarkeysaste_id) == null) {
            $this->virheet['tarkeysaste_id'] = "Tärkeysastetta ei löytynyt tietokannasta";
        } else {
            unset($this->virheet['tarkeysaste_id']);
        }
    }

    public static function getTehtavat($sivu, $montako) {

        $sql = "SELECT tehtava.id as id, tehtava.kuvaus as kuvaus, tehtava.kayttaja_id as kayttaja_id, tehtava.tarkeysaste_id as tarkeysaste_id, tarkeysaste.nimi as tarkeysaste FROM tehtava, tarkeysaste WHERE tehtava.tarkeysaste_id=tarkeysaste.id ORDER by kuvaus LIMIT ? OFFSET ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($montako, ($sivu - 1) * $montako));

        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $tehtava = new Tehtava($tulos->id, $tulos->kuvaus, $tulos->kayttaja_id, $tulos->tarkeysaste_id, $tulos->tarkeysaste);
            $tulokset[] = $tehtava;
        }
        return $tulokset;
    }
    
    public static function getKayttajanTehtavat($id, $sivu, $montako) {

        $sql = "SELECT tehtava.id as id, tehtava.kuvaus as kuvaus,
            tehtava.kayttaja_id as kayttaja_id, tehtava.tarkeysaste_id as tarkeysaste_id,
            tarkeysaste.nimi as tarkeysaste FROM tehtava, tarkeysaste 
            WHERE tehtava.kayttaja_id = ? and tehtava.tarkeysaste_id=tarkeysaste.id 
            ORDER by kuvaus LIMIT ? OFFSET ?";
        
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($id, $montako, ($sivu - 1) * $montako));

        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $tehtava = new Tehtava($tulos->id, $tulos->kuvaus, $tulos->kayttaja_id, $tulos->tarkeysaste_id, $tulos->tarkeysaste);
            $tulokset[] = $tehtava;
        }
        return $tulokset;
    }
    
    public static function getKayttajanTehtavatTarkeysasteella($id, $sivu, $montako, $tarkeysaste_id) {

        $sql = "SELECT tehtava.id as id, tehtava.kuvaus as kuvaus,
            tehtava.kayttaja_id as kayttaja_id, tehtava.tarkeysaste_id as tarkeysaste_id,
            tarkeysaste.nimi as tarkeysaste FROM tehtava, tarkeysaste 
            WHERE tehtava.kayttaja_id = ? and tehtava.tarkeysaste_id=tarkeysaste.id and tehtava.tarkeysaste_id = ?
            ORDER by kuvaus LIMIT ? OFFSET ?";
        
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($id, $tarkeysaste_id, $montako, ($sivu - 1) * $montako));

        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $tehtava = new Tehtava($tulos->id, $tulos->kuvaus, $tulos->kayttaja_id, $tulos->tarkeysaste_id, $tulos->tarkeysaste);
            $tulokset[] = $tehtava;
        }
        return $tulokset;
    }

    public static function lukumaara($id) {
        $sql = "SELECT count(*) FROM tehtava WHERE kayttaja_id = ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($id));
        return $kysely->fetchColumn();
    }
    
    public static function lukumaaraTarkeysasteella($id, $tarkeysaste_id) {
        $sql = "SELECT count(*) FROM tehtava WHERE kayttaja_id = ? and tarkeysaste_id = ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($id, $tarkeysaste_id));
        return $kysely->fetchColumn();
    }

    public function onkoKelvollinen() {
        return empty($this->virheet);
    }

    public function lisaaKantaan() {
        $sql = "INSERT INTO tehtava(kuvaus, kayttaja_id, tarkeysaste_id) VALUES(?,?,?) RETURNING id";
        $kysely = getTietokantayhteys()->prepare($sql);

        $ok = $kysely->execute(array($this->getKuvaus(), $this->getKayttaja_id(), $this->getTarkeysaste_id()));
        if ($ok) {
            $this->id = $kysely->fetchColumn();
        }
        return $ok;
    }

    public static function etsi($id) {
        $sql = "SELECT tehtava.id as id, tehtava.kuvaus as kuvaus,
            tehtava.kayttaja_id as kayttaja_id, tehtava.tarkeysaste_id as tarkeysaste_id,
            tarkeysaste.nimi as tarkeysaste FROM tehtava, tarkeysaste
            WHERE tehtava.id = ? and tehtava.tarkeysaste_id = tarkeysaste.id LIMIT 1";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($id));
        $tulos = $kysely->fetchObject();
        if ($tulos == null){
            return null;
        } else {
            $tehtava = new Tehtava($tulos->id, $tulos->kuvaus, $tulos->kayttaja_id, $tulos->tarkeysaste_id, $tulos->tarkeysaste);
            return $tehtava;
        }
    }

    public function muokkaaKantaa($id) {
        
        $sql = "UPDATE tehtava SET kuvaus=?, kayttaja_id=?, tarkeysaste_id=? WHERE id=?";
        $kysely = getTietokantayhteys()->prepare($sql);

        $ok = $kysely->execute(array($this->kuvaus, $this->kayttaja_id, $this->tarkeysaste_id, $id));
        if ($ok) {
            $this->id = $kysely->fetchColumn();
        }
        return $ok;
    }

    public function poistaKannasta($id) {
        $sql = "DELETE FROM tehtava WHERE id=?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($id));
    }

}