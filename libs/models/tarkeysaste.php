<?php

class Tarkeysaste {

    private $id;
    private $nimi;
    private $kayttaja_id;
    private $virheet = array();

    public function __construct($id, $nimi, $kayttaja_id) {
        $this->id = $id;
        $this->nimi = $nimi;
        $this->kayttaja_id = $kayttaja_id;
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
        } else {
            unset($this->virheet['nimi']);
        }
    }

    public function setKayttaja_id($kayttaja_id) {
        $this->kayttaja_id = $kayttaja_id;
    }
    
    public static function etsi($id){
        $sql = "SELECT * FROM tarkeysaste WHERE id =?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($id));
        $tulos = $kysely->fetchObject();
        if ($tulos == null){
            return null;
        } else {
            $tarkeysaste = new Tarkeysaste($tulos->id, $tulos->nimi, $tulos->kayttaja_id);
            return $tarkeysaste;
        }
    }
    
    public static function getTarkeysasteet($id) {

        $sql = "SELECT id, nimi, kayttaja_id FROM tarkeysaste WHERE kayttaja_id = ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($id));

        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $tarkeysaste = new Tarkeysaste($tulos->id, $tulos->nimi, $tulos->kayttaja_id);
            $tulokset[] = $tarkeysaste;
        }
        return $tulokset;
    }
    
    public function lisaaKantaan($nimi, $kayttaja_id) {
        $sql = "INSERT INTO tarkeysaste(nimi, kayttaja_id) VALUES(?,?) RETURNING id";
        $kysely = getTietokantayhteys()->prepare($sql);

        $ok = $kysely->execute(array($nimi, $kayttaja_id));
        if ($ok) {
            $id = $kysely->fetchColumn();
        }
        return $ok;
    }
    public function poistaKannasta($id) {
        $sql = "DELETE FROM tarkeysaste WHERE id=?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($id));
    }
    
    public function muokkaaKantaa($id) {
        
        $sql = "UPDATE tarkeysaste SET nimi=?, kayttaja_id=? WHERE id=?";
        $kysely = getTietokantayhteys()->prepare($sql);

        $ok = $kysely->execute(array($this->nimi, $this->kayttaja_id, $id));
        if ($ok) {
            $this->id = $kysely->fetchColumn();
        }
        return $ok;
    }
    
    public function onkoKelvollinen() {
        return empty($this->virheet);
    }



}