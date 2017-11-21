<?php

namespace Halite;

use Halite\Object\Planet;
use Halite\Object\Ship;

class Player {

    protected $gameMap;
    /**
     * @var integer
     */
    public $id;
    /**
     * @var Ship[]
     */
    public $ships;
    /**
     * @var Planet[]
     */
    public $planets;

    public function __construct($id, $gameMap) {
        $this->id = $id;
        $this->ships = array();
        $this->planets = array();
        $this->gameMap = $gameMap;
    }

    public function id() {
        return $this->id;
    }

    public function ships() {
        return $this->ships;
    }

    public function ship($id) {
        return $this->ships[$id];
    }

    public function planets() {
        return $this->planets;
    }

    public function addShip(Ship $ship) {
        $this->ships[$ship->id()] = $ship;
        $ship->setOwner($this);
    }

    public function addPlanet(Planet $planet) {
        $this->planets[$planet->id()] = $planet;
        $planet->setOwner($this);
    }
}