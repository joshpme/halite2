<?php

namespace Halite\Object;


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