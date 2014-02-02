<?php

class Luokka {

    private $id;
    private $nimi;
    private $kayttaja_id;

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

    public function setId($id) {
        $this->id = $id;
    }

    public function setNimi($nimi) {
        $this->nimi = $nimi;
    }

    public function setKayttaja_id($kayttaja_id) {
        $this->kayttaja_id = $kayttaja_id;
    }

}