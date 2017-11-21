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
    protected $myId;
    /**
     * @var integer
     */
    protected $width;
    /**
     * @var integer
     */
    protected $height;

    /**
     * @var Planet[]
     */
    protected $planets;

    /**
     * @var Ship[]
     */
    protected $ships;

    /**
     * @var Player[]
     */
    protected $players;

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

    public function obstaclesBetween(array $obstacles, Ship $ship, Entity $target) {
        $obstacles = array_filter($obstacles, function($obstacle) use ($ship) {
            return ($obstacle !== $ship);
        });
    }
}