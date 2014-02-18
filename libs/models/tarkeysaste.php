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
    
    //tarkastetaan samalla, onko nimi kelvollinen eli 1-255 merkkiä pitkä
    public function setNimi($nimi) {
        $this->nimi = $nimi;

        if (trim($this->nimi) == '') {
            $this->virheet['nimi'] = "Tärkeysasteen nimi ei saa olla tyhjä.";
        } elseif (strlen($this->nimi) > 255) {
            $this->virheet['nimi'] = "Tärkeysasteen nimen on oltava alle 255 merkkiä.";
        } else {
            unset($this->virheet['nimi']);
        }
    }
    
    
    //tarkastetaan samalla, onko käyttäjä_id sama kuin sisäänkirjautunut käyttäjä
    public function setKayttaja_id($kayttaja_id) {
        $this->kayttaja_id = $kayttaja_id;
        
        if ($this->kayttaja_id != $_SESSION['kayttaja_id']){
            $this->virheet['kayttaja_id'] = "Voit muokata vain omia tärkeysasteita.";
        } else {
            unset($this->virheet['kayttaja_id']);
        }
    }

    //etsitään yksittäinen, tietyn käyttäjän tärkeysaste
    public static function etsi($id, $kayttaja_id) {
        $sql = "SELECT * FROM tarkeysaste WHERE id = ? and kayttaja_id = ? LIMIT 1";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($id, $kayttaja_id));
        $tulos = $kysely->fetchObject();
        if ($tulos == null) {
            return null;
        } else {
            $tarkeysaste = new Tarkeysaste($tulos->id, $tulos->nimi, $tulos->kayttaja_id);
            return $tarkeysaste;
        }
    }

    //haetaan tietyn käyttäjän kaikki tärkeysasteet
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

    //lisätään kantaan uusi tärkeysaste
    public function lisaaKantaan($nimi, $kayttaja_id) {
        $sql = "INSERT INTO tarkeysaste(nimi, kayttaja_id) VALUES(?,?) RETURNING id";
        $kysely = getTietokantayhteys()->prepare($sql);

        $ok = $kysely->execute(array($nimi, $kayttaja_id));
        if ($ok) {
            $id = $kysely->fetchColumn();
        }
        return $ok;
    }

    //poistetaan kannasta tietty tärkeysaste
    public function poistaKannasta($id) {
        $sql = "DELETE FROM tarkeysaste WHERE id=?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($id));
    }

    //muokataan tiettyä tärkeysastetta
    public function muokkaaKantaa($id) {
        $sql = "UPDATE tarkeysaste SET nimi=?, kayttaja_id=? WHERE id=?";
        $kysely = getTietokantayhteys()->prepare($sql);

        $ok = $kysely->execute(array($this->nimi, $this->kayttaja_id, $id));
        if ($ok) {
            $this->id = $kysely->fetchColumn();
        }
        return $ok;
    }

    //tarkastetaan liittyikö tärkeysasteeseen virheitä
    public function onkoKelvollinen() {
        return empty($this->virheet);
    }

}