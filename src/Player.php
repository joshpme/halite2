<?php
namespace Halite;

use Halite\Object\Planet;
use Halite\Object\Ship;

class Player {

    protected $gameMap;
    /**
     * @var integer
     */
    protected $id;
    /**
     * @var Ship[]
     */
    protected $ships;
    /**
     * @var Planet[]
     */
    protected $planets;

    public function __construct($id, $gameMap) {
        $this->id = $id;
        $this->ships = array();
        $this->planets = array();
        $this->gameMap = $gameMap;
    }

    public function ships() {
        return $this->ships;
    }

    public function planets() {
        return $this->planets;
    }

    public function addShip(Ship $ship) {
        $this->ships[] = $ship;
        $ship->setOwner($this);
    }

    public function addPlanet(Planet $planet) {
        $this->planets[] = $planet;
        $planet->setOwner($this);
    }
}