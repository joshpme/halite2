<?php

namespace Halite\Object;

use Halite\GameMap;

class Planet extends Entity {
    /**
     * @var Ship[]
     */
    protected $dockedShips;

    /**
     * @var integer
     */
    protected $dockingSpots;

    /**
     * @var integer
     */
    protected $currentProduction;

    /**
     * @var integer
     */
    protected $remainingProduction;

    /**
     * @return Ship[]
     */
    public function dockedShips() {
        return $this->dockedShips;
    } 

    /**
     * Planet constructor.
     * @param GameMap $gameMap
     * @param float $id
     * @param $health
     * @param $x
     * @param $y
     * @param $radius
     * @param null $dockingSpots
     * @param $currentProduction
     * @param $remainingProduction
     * @param $dockedShips
     * @param null $owner
     */
    public function __construct(GameMap $gameMap, $id, $health, $x, $y, $radius, $dockingSpots, $currentProduction, $remainingProduction, $dockedShips, $owner = null)
    {
        $this->dockingSpots = $dockingSpots;
        $this->currentProduction = $currentProduction;
        $this->remainingProduction = $remainingProduction;
        $this->dockedShips = $dockedShips;
        parent::__construct($gameMap, $id, $health, $x, $y, $radius, $owner);
    }

    /**
     * @return integer
     */
    public function dockingSpots() {
        return $this->dockingSpots;
    }

    /**
     * @return integer
     */
    public function currentProduction() {
        return $this->currentProduction;
    }

    /**
     * @return integer
     */
    public function remainingProduction() {
        return $this->remainingProduction;
    }

    /**
     * @return integer
     */
    public function numberOfDockedShips() {
        return count($this->dockedShips());
    }

    /**
     * @return bool
     */
    public function hasDockingSpot() {
        return $this->dockingSpots() > count($this->dockedShips());
    }

    /**
     * @return bool
     */
    public function isFree() {
        return ($this->owner() === null);
    }

    /**
     * @return bool
     */
    public function isOwned() {
        return (!$this->isFree());
    }


};