<?php

class Tehtava {

    private $id;
    private $kuvaus;
    private $kayttaja_id;
    private $tarkeysaste_id;

    public function __construct($id, $kuvaus, $kayttaja_id, $tarkeysaste_id) {
        $this->id = $id;
        $this->kuvaus = $kuvaus;
        $this->kayttaja_id = $kayttaja_id;
        $this->tarkeysaste_id = $tarkeysaste_id;
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

    public function setId($id) {
        $this->id = $id;
    }

    public function setKuvaus($kuvaus) {
        $this->kuvaus = $kuvaus;
    }

    public function setKayttaja_id($kayttaja_id) {
        $this->kayttaja_id = $kayttaja_id;
    }

    public function setTarkeysaste_id($tarkeysaste_id) {
        $this->tarkeysaste_id = $tarkeysaste_id;
    }

}