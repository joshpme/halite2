<?php

namespace Halite;

use Halite\Object\Entity;
use Halite\Object\Planet;
use Halite\Object\Ship;

class GameMap
{
    /**
     * @var integer
     */
    private $myId;

    /**
     * @var integer
     */
    private $width;

    /**
     * @var integer
     */
    private $height;

    /**
     * @var Planet[]
     */
    private $planets;

    /**
     * @var Ship[]
     */
    private $ships;

    /**
     * @var Player[]
     */
    private $players;

    public function __construct($myId, $width, $height) {
        $this->myId = $myId;
        $this->width = $width;
        $this->height = $height;
    }

    public function addPlayer($id) {
        $this->players[$id] = new Player($id, $this);
        return $this->players[$id];
    }

    public function addPlanet(Planet $planet) {
        $this->planets[$planet->id()] = $planet;
    }

    public function addShip(Ship $ship) {
        $this->ships[$ship->id()] = $ship;
    }

    public function ship($id) {
        return $this->ships[$id];
    }

    public function planet($id) {
        return $this->planets[$id];
    }

    public function player($id) {
        return $this->players[$id];
    }

    public function ships() {
        return $this->ships;
    }

    public function planets() {
        return $this->planets;
    }

    public function players() {
        return $this->players;
    }

    /**
     * @return Player
     */
    public function me() {
        return $this->players[$this->myId];
    }

    public function numberOfPlayers() {
        return count($this->players);
    }

    /**
     * @return Player[]
     */
    public function enemies() {
        $enemies = array();
        foreach ($this->players() as $player) {
            if ($player !== $this->me()) {
                $enemies[] = $player;
            }
        }
        return $enemies;
    }

    public function enemyShips() {
        $ships = array();
        foreach ($this->ships as $ship) {
            if ($ship->owner() !== $this->me()) {
                $ships[] = $ship;
            }
        }
        return $ships;
    }
}