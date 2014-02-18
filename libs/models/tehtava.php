<?php

require_once 'tarkeysaste.php';

class Tehtava {

    private $id;
    private $kuvaus;
    private $kayttaja_id;
    private $tarkeysaste_id;
    private $tarkeysaste;
    private $virheet = array();
    private $luokat = array();

    public function __construct($id, $kuvaus, $kayttaja_id, $tarkeysaste_id, $tarkeysaste) {
        $this->id = $id;
        $this->kuvaus = $kuvaus;
        $this->kayttaja_id = $kayttaja_id;
        $this->tarkeysaste_id = $tarkeysaste_id;
        $this->tarkeysaste = $tarkeysaste;
        $this->luokat = array();
        $this->virheet = array();
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

    public function getLuokat($tehtava_id) {
        $sql = "SELECT tehtava.id as tehtava_id, tehtava.kayttaja_id as kayttaja_id, luokka.id as luokka_id, luokka.nimi as nimi, luokka.kayttaja_id
            FROM tehtava, luokka, tehtavanluokat WHERE tehtava.id = ? and tehtava.id = tehtavanluokat.tehtava_id and luokka.id = tehtavanluokat.luokka_id and tehtava.kayttaja_id = luokka.kayttaja_id";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($tehtava_id));

        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $luokka = new Luokka($tulos->luokka_id, $tulos->nimi, $tulos->kayttaja_id);
            $tulokset[] = $luokka;
        }
        return $tulokset;
    }
    
    public function onkoTehtavanLuokka($tehtava_id, $luokka_id){
        $tehtavanLuokat = $this->getLuokat($tehtava_id);
        foreach ($tehtavanLuokat as $luokka){
            if ($luokka->getId()==$luokka_id){
                return TRUE;
            }
        }
        return FALSE;
    }

    public function setId($id) {
        $this->id = $id;
    }

    //asetetaan tehtävän kuvaus ja tarkastetaan, että se on 1-1000 merkkiä pitkä
    public function setKuvaus($kuvaus) {
        $this->kuvaus = $kuvaus;

        if (trim($this->kuvaus) == '') {
            $this->virheet['kuvaus'] = "Kuvaus ei saa olla tyhjä.";
        } elseif (strlen($this->kuvaus) > 1000) {
            $this->virheet['kuvaus'] = "Tehtävän kuvauksen on oltava alle 1000 merkkiä pitkä.";
        } else {
            unset($this->virheet['kuvaus']);
        }
    }

    //tarkastetaan, että käyttäjä_id on sama kuin kirjautuneella käyttäjällä
    public function setKayttaja_id($kayttaja_id) {
        $this->kayttaja_id = $kayttaja_id;

        if ($this->kayttaja_id != $_SESSION['kayttaja_id']) {
            $this->virheet['kayttaja_id'] = "Voit muokata vain omia tehtäviä.";
        } else {
            unset($this->virheet['kayttaja_id']);
        }
    }

    //tarkastetaan, että haluttu tärkeysaste on olemassa
    public function setTarkeysaste_id($tarkeysaste_id, $kayttaja_id) {
        $this->tarkeysaste_id = $tarkeysaste_id;

        if (Tarkeysaste::etsi($tarkeysaste_id, $kayttaja_id) == null) {
            $this->virheet['tarkeysaste_id'] = "Tärkeysastetta ei löytynyt tietokannasta";
        } else {
            unset($this->virheet['tarkeysaste_id']);
        }
    }

    public function setLuokat($luokka_id, $kayttaja_id) {
        $this->luokat[] = $luokka_id;

        if (Luokka::etsi($luokka_id, $kayttaja_id) == null) {
            $this->virheet['luokka_id'] = "Luokkaa ei löytynyt tietokannasta";
        } else {
            unset($this->virheet['luokka_id']);
        }
    }

    //listaa kaikki tehtävät, käytetty testaamiseen, mutta oikeasti kannattaa käyttää vain
    // tietyn käyttäjän tehtävät listaavaa funktiota
    public static function getTehtavat($sivu, $montako) {

        $sql = "SELECT tehtava.id as id, tehtava.kuvaus as kuvaus, tehtava.kayttaja_id as kayttaja_id,
            tehtava.tarkeysaste_id as tarkeysaste_id, tarkeysaste.nimi as tarkeysaste 
            FROM tehtava, tarkeysaste WHERE tehtava.tarkeysaste_id=tarkeysaste.id
            ORDER by kuvaus LIMIT ? OFFSET ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($montako, ($sivu - 1) * $montako));

        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $tehtava = new Tehtava($tulos->id, $tulos->kuvaus, $tulos->kayttaja_id, $tulos->tarkeysaste_id, $tulos->tarkeysaste);
            $tulokset[] = $tehtava;
        }
        return $tulokset;
    }

    //listaa tietyn käyttäjän tehtävät, jotka ovat sillä sivulla, jota halutaan nyt tarkastella
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

    //listaa tietyn käyttäjän tehtävät, joilla on tietty tärkeysaste ja jotka ovat tietyllä sivulla, jota halutaan nyt tarkastella
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

    //listaa tietyn käyttäjän tehtävät, joilla on tietty luokka ja jotka ovat tietyllä sivulla, jota halutaan nyt tarkastella
    public static function getKayttajanTehtavatLuokalla($id, $sivu, $montako, $luokka_id) {

        $sql = "SELECT tehtava.id as id, tehtava.kuvaus as kuvaus,
            tehtava.kayttaja_id as kayttaja_id, tehtava.tarkeysaste_id as tarkeysaste_id,
            tarkeysaste.nimi as tarkeysaste, luokka.id as luokka_id FROM tehtava, tarkeysaste, luokka, tehtavanluokat 
            WHERE tehtava.kayttaja_id = ? and tehtava.tarkeysaste_id=tarkeysaste.id and luokka.id = ? and tehtavanluokat.tehtava_id = tehtava.id and tehtavanluokat.luokka_id = luokka.id
            ORDER by kuvaus LIMIT ? OFFSET ?";

        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($id, $luokka_id, $montako, ($sivu - 1) * $montako));

        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $tehtava = new Tehtava($tulos->id, $tulos->kuvaus, $tulos->kayttaja_id, $tulos->tarkeysaste_id, $tulos->tarkeysaste);
            $tulokset[] = $tehtava;
        }
        return $tulokset;
    }

    //listaa tietyn käyttäjän tehtävät, joilla on tietty luokka ja tärkeysaste ja jotka ovat tietyllä sivulla, jota halutaan nyt tarkastella
    public static function getKayttajanTehtavatTarkeysasteellaJaLuokalla($id, $sivu, $montako, $tarkeysaste_id, $luokka_id) {

        $sql = "SELECT DISTINCT tehtava.id as id, tehtava.kuvaus as kuvaus,
            tehtava.kayttaja_id as kayttaja_id, tehtava.tarkeysaste_id as tarkeysaste_id,
            tarkeysaste.nimi as tarkeysaste, luokka.id FROM tehtava, tarkeysaste, luokka, tehtavanluokat 
            WHERE tehtava.kayttaja_id = ? and tehtava.tarkeysaste_id = ? and tehtava.tarkeysaste_id=tarkeysaste.id and tehtavanluokat.luokka_id = ? and tehtavanluokat.tehtava_id = tehtava.id and tehtavanluokat.luokka_id = luokka.id
            ORDER by kuvaus LIMIT ? OFFSET ?";

        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($id, $tarkeysaste_id, $luokka_id, $montako, ($sivu - 1) * $montako));

        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $tehtava = new Tehtava($tulos->id, $tulos->kuvaus, $tulos->kayttaja_id, $tulos->tarkeysaste_id, $tulos->tarkeysaste);
            $tulokset[] = $tehtava;
        }
        return $tulokset;
    }

    //kertoo tietyn käyttäjän tehtävien lukumäärän
    public static function lukumaara($id) {
        $sql = "SELECT count(*) FROM tehtava WHERE kayttaja_id = ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($id));
        return $kysely->fetchColumn();
    }

    //kertoo tietyn käyttäjän tietyn tärkeysasteen tehtävien lukumäärän
    public static function lukumaaraTarkeysasteella($id, $tarkeysaste_id) {
        $sql = "SELECT count(*) FROM tehtava WHERE kayttaja_id = ? and tarkeysaste_id = ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($id, $tarkeysaste_id));
        return $kysely->fetchColumn();
    }

    //kertoo tietyn käyttäjän tietyn luokan tehtävien lukumäärän
    public static function lukumaaraLuokalla($id, $luokka_id) {
        $sql = "SELECT count(*) FROM tehtava, tehtavanluokat WHERE tehtava.kayttaja_id = ? and tehtava.id = tehtavanluokat.tehtava_id and tehtavanluokat.luokka_id = ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($id, $luokka_id));
        return $kysely->fetchColumn();
    }

    //kertoo tietyn käyttäjän tietyn tärkeysasteen ja luokan tehtävien lukumäärän
    public static function lukumaaraTarkeysasteellaJaLuokalla($id, $tarkeysaste_id, $luokka_id) {
        $sql = "SELECT DISTINCT count(*) FROM tehtava, tehtavanluokat WHERE tehtava.kayttaja_id = ? and tehtava.tarkeysaste_id = ? and tehtava.id = tehtavanluokat.tehtava_id and tehtavanluokat.luokka_id = ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($id, $tarkeysaste_id, $luokka_id));
        return $kysely->fetchColumn();
    }

    //tarkastaa onko tehtävässä virheitä
    public function onkoKelvollinen() {
        return empty($this->virheet);
    }

    //lisää uuden tehtävän tietokantaan
    public function lisaaKantaan() {
        $sql = "INSERT INTO tehtava(kuvaus, kayttaja_id, tarkeysaste_id) VALUES(?,?,?) RETURNING id";
        $kysely = getTietokantayhteys()->prepare($sql);

        $ok = $kysely->execute(array($this->getKuvaus(), $this->getKayttaja_id(), $this->getTarkeysaste_id()));
        if ($ok) {
            $this->id = $kysely->fetchColumn();
            if (!empty($this->luokat)) {
                $this->lisaaLuokatKantaan($this->id);
            }
        }
        return $ok;
    }

    public function lisaaLuokatKantaan($id) {
        foreach ($this->luokat as $luokka) {
            $sql = "INSERT INTO tehtavanluokat(tehtava_id, luokka_id) VALUES(?,?) RETURNING tehtava_id";
            $kysely = getTietokantayhteys()->prepare($sql);

            $ok = $kysely->execute(array($id, $luokka));
            if ($ok) {
                $this->id = $kysely->fetchColumn();
            }
        }
    }
    
    public function poistaLuokatKannasta($id) {
        $sql = "DELETE FROM tehtavanluokat WHERE tehtava_id=?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($id));
    }

    //palauttaa tietyn käyttäjäjn tietyn tehtävän
    public static function etsi($id, $kayttaja_id) {
        $sql = "SELECT tehtava.id as id, tehtava.kuvaus as kuvaus,
            tehtava.kayttaja_id as kayttaja_id, tehtava.tarkeysaste_id as tarkeysaste_id,
            tarkeysaste.nimi as tarkeysaste FROM tehtava, tarkeysaste
            WHERE tehtava.id = ? and tehtava.kayttaja_id = ? and tehtava.tarkeysaste_id = tarkeysaste.id LIMIT 1";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($id, $kayttaja_id));
        $tulos = $kysely->fetchObject();
        if ($tulos == null) {
            return null;
        } else {
            $tehtava = new Tehtava($tulos->id, $tulos->kuvaus, $tulos->kayttaja_id, $tulos->tarkeysaste_id, $tulos->tarkeysaste);
            return $tehtava;
        }
    }

    //muokkaa tiettyä tehtävää tietokannassa
    public function muokkaaKantaa($id) {

        $sql = "UPDATE tehtava SET kuvaus=?, kayttaja_id=?, tarkeysaste_id=? WHERE id=?";
        $kysely = getTietokantayhteys()->prepare($sql);

        $ok = $kysely->execute(array($this->kuvaus, $this->kayttaja_id, $this->tarkeysaste_id, $id));
        if ($ok) {
            $this->id = $kysely->fetchColumn();
            if (!empty($this->luokat)) {
                $this->poistaLuokatKannasta($id);
                $this->lisaaLuokatKantaan($id);
            }
        }
        return $ok;
    }

    //poistaa tietyn tehtävän tietokannasta
    public function poistaKannasta($id) {
        $sql = "DELETE FROM tehtava WHERE id=?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($id));
    }

}