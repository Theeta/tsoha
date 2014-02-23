<?php

class Kayttaja {

    private $id;
    private $nimi;
    private $tunnus;
    private $salasana;
    private $virheet = array();

    public function __construct($id, $nimi, $tunnus, $salasana) {
        $this->id = $id;
        $this->nimi = $nimi;
        $this->tunnus = $tunnus;
        $this->salasana = $salasana;
        $this->virheet = array();
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

    public function getVirheet() {
        return $this->virheet;
    }

    public function setId($id) {
        $this->id = $id;
    }

    //asetetaan käyttäjälle nimi ja tarkastetaan, kelpaako se
    public function setNimi($nimi) {
        $this->nimi = $nimi;

        if (trim($this->nimi) == '') {
            $this->virheet['nimi'] = "Nimi ei saa olla tyhjä.";
        } elseif (strlen($this->nimi) > 50) {
            $this->virheet['nimi'] = "Nimen on oltava alle 50 merkkiä pitkä.";
        } else {
            unset($this->virheet['nimi']);
        }
    }

    //asetetaan käyttäjälle tunnus ja tarkastetaan, kelpaako se
    public function setTunnus($tunnus) {
        $this->tunnus = $tunnus;

        if (trim($this->tunnus) == '') {
            $this->virheet['tunnus'] = "Käyttäjätunnus ei saa olla tyhjä.";
        } elseif (strlen($this->tunnus) > 20) {
            $this->virheet['tunnus'] = "Käyttäjätunnuksen on oltava alle 20 merkkiä pitkä.";
        } elseif ($this->loytyykoTunnusta($tunnus)) {
            $this->virheet['tunnus'] = "Käyttäjätunnus on jo olemassa, valitse toinen tunnus.";
        } else {
            unset($this->virheet['tunnus']);
        }
    }

    //asetetaan käyttäjälle salasana ja tarkastetaan kelpaako se. Sama salasana täytyy antaa kahdesti, jotta se kelpaisi
    public function setSalasana($salasana1, $salasana2) {
        $this->salasana = $salasana1;

        if (trim($this->salasana) == '') {
            $this->virheet['salasana'] = "Salasana ei saa olla tyhjä.";
        } elseif (strlen($this->salasana) > 20) {
            $this->virheet['salasana'] = "Salasanan on oltava alle 20 merkkiä pitkä.";
        } elseif ($this->salasana != $salasana2) {
            $this->virheet['salasana'] = "Anna sama salasana kahdesti";
        } else {
            unset($this->virheet['salasana']);
        }
    }

    //haetaan kaikki käyttäjät tietokannasta
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

    //etsitään tietty käyttäjä tietokannasta
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

    //haetaan tietty käyttäjä tietokannasta
    public static function etsi($id) {
        $sql = "SELECT id, nimi, tunnus, salasana FROM kayttaja WHERE kayttaja.id = ? LIMIT 1";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($id));
        $tulos = $kysely->fetchObject();
        if ($tulos == null) {
            return null;
        } else {
            $kayttaja = new Kayttaja($tulos->id, $tulos->nimi, $tulos->tunnus, $tulos->salasana);
            return $kayttaja;
        }
    }

    //tarkastetaan, onko käyttäjätunnus jo käytössä
    public static function loytyykoTunnusta($tunnus) {
        $sql = "SELECT id, nimi, tunnus, salasana from kayttaja where tunnus = ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($tunnus));

        $tulos = $kysely->fetchObject();
        if ($tulos == null) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    //tarkastaa onko käyttäjässä virheitä
    public function onkoKelvollinen() {
        return empty($this->virheet);
    }

    //lisää uuden käyttäjän tietokantaan
    public function lisaaKantaan() {
        $sql = "INSERT INTO kayttaja(nimi, tunnus, salasana) VALUES(?,?,?) RETURNING id";
        $kysely = getTietokantayhteys()->prepare($sql);

        $ok = $kysely->execute(array($this->getNimi(), $this->getTunnus(), $this->getSalasana()));
        if ($ok) {
            $this->id = $kysely->fetchColumn();
        }
        return $ok;
    }

    //muokkaa tietyn käyttäjän tietoja kannassa
    public function muokkaaKantaa($id) {

        $sql = "UPDATE kayttaja SET nimi=?, tunnus=?, salasana=? WHERE id=?";
        $kysely = getTietokantayhteys()->prepare($sql);

        $ok = $kysely->execute(array($this->nimi, $this->tunnus, $this->salasana, $id));
        if ($ok) {
            $this->id = $kysely->fetchColumn();
        }
        return $ok;
    }
    
    //poistaa tietyn käyttäjän kannasta
    public function poistaKannasta($id) {
        $sql = "DELETE FROM kayttaja WHERE id=?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($id));
    }

}