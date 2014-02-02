<?php

class Tehtavanluokat {

    private $tehtava_id;
    private $luokka_id;

    public function __construct($tehtava_id, $luokka_id) {
        $this->tehtava_id = $tehtava_id;
        $this->luokka_id = $luokka_id;
    }

    public function getTehtava_id() {
        return $this->tehtava_id;
    }

    public function getLuokka_id() {
        return $this->luokka_id;
    }

    public function setTehtava_id($tehtava_id) {
        $this->tehtava_id = $tehtava_id;
    }

    public function setLuokka_id($luokka_id) {
        $this->luokka_id = $luokka_id;
    }

}