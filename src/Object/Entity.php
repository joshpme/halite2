<?php

namespace Halite\Object;

use Halite\Player;

class Entity extends Circle {

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var float
     */
    protected $health;

    /**
     * @var Player|null
     */
    protected $owner;

    /**
     * @var GameMap
     */
    protected $gameMap;

    /**
     * @return int
     */
    public function id() {
        return $this->id;
    }

    /**
     * @return Player|null
     */
    public function owner() {
        return $this->owner;
    }

    /**
     * @return float
     */
    public function health() {
        return $this->health;
    }

    /**
     * @return GameMap
     */
    public function gameMap() {
        return $this->gameMap;
    }

    public function __construct($gameMap, $id, $health, $x, $y, $radius, $owner = null) {
        $this->gameMap = $gameMap;
        $this->id = $id;
        $this->health = $health;
        $this->owner = $owner;
        parent::__construct($x, $y, $radius);
    }

    public function isOwnedByMe() {
        return $this->owner() === $this->gameMap()->me();
    }

    public function isOwnedByEnemy() {
        return !$this->isOwnedByMe();
    }

    public function setOwner($owner) {
        $this->owner = $owner;
    }
};