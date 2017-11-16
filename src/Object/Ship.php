<?php

namespace Halite\Object;


use Halite\Geometry;
use Halite\Halite;

class Ship extends Entity {

    const ACTION_DOCK = 'd';
    const ACTION_THRUST = 't';
    const ACTION_UNDOCK = 'u';

    /**
     * Queued Action
     * @var string
     */
    public $action;

    /**
     * @var Planet|null
     */
    public $target;

    /**
     * @var integer|null
     */
    public $speed;

    /**
     * @var integer|null
     */
    public $direction;

    /**
     * @var Halite::DOCKING|Halite::DOCKED|Halite:UNDOCKING|Halite::UNDOCKED
     */
    protected $dockingStatus;

    /**
     * @var integer
     */
    protected $dockingProgress;

    /**
     * @var integer
     */
    protected $weaponCooldown;

    public function __construct($gameMap, $owner, $id, $x, $y, $radius) {
        $this->dockingStatus = Halite::UNDOCKED;
        parent::__construct($gameMap, $id, Halite::BASE_SHIP_HEALTH, $x, $y, $radius, $owner);
    }

    public function dockingStatus() {
        return $this->dockingStatus;
    }

    public function dockingProgress() {
        return $this->dockingProgress;
    }

    public function weaponCooldown() {
        return $this->weaponCooldown;
    }

    public function isDocked() {
        return $this->dockingStatus === Halite::DOCKED;
    }

    public function isDocking() {
        return $this->dockingStatus === Halite::DOCKING;
    }

    public function isUndocking() {
        return $this->dockingStatus === Halite::UNDOCKING;
    }

    public function isUndocked() {
        return $this->dockingStatus === Halite::UNDOCKED;
    }

    public function canDock(Planet $planet) {
        // free spot
        if (!$planet->hasDockingSpot()) {
            return false;
        }
        // free or owned by me
        if (!$planet->isFree() && $planet->owner() !== $this->owner()) {
            return false;
        }
        // within range
        if ($this->distanceBetween($planet) > Halite::SHIP_RADIUS + $planet->radius() + Halite::DOCK_RADIUS) {
            return false;
        }
        return true;
    }

    function output() {
        if ($this->action === null) {
            return null;
        }

        $output = $this->action . " " . $this->id() . " ";

        if ($this->action == self::ACTION_DOCK) {
            if ($this->target === null) {
                return null;
            }
            $output .= $this->target->id();
        }

        if ($this->action == self::ACTION_THRUST) {
            if ($this->speed === null || $this->direction === null) {
                return null;
            }
            $this->speed = round($this->speed);
            $this->direction = round($this->direction);

            // if the speed is above max speed, cap it to max speed
            if ($this->speed > Halite::MAX_SPEED) {
                $this->speed = Halite::MAX_SPEED;
            }
            // if direction is below 0 then increase it
            while ($this->direction < 0) {
                $this->direction += 360;
            }
            // if direction is above 360 then modulus it
            if ($this->direction >= 360) {
                $this->direction %= 360;
            }

            $output .= $this->speed . " " . $this->direction;
        }
        return $output;
    }

    public function navigate(Point $target, $speed, $keepDistanceToTarget = 0, $ignoreShips = false, $ignorePlanets = false) {

        $destination = Geometry::pointOnLine($this,$target,$speed);
        $deviation = 0;

        if ($this->distanceBetween($target) + $keepDistanceToTarget < $speed) {
            $speed = $this->distanceBetween($target) + $keepDistanceToTarget;
        }

        while ($deviation < 180) {
            $obstacles = array();
            if (!$ignorePlanets) {
                $obstacles += $this->gameMap()->planetsBetween($this, $target);
            }
            if (!$ignoreShips) {
                $obstacles += $this->gameMap()->shipsBetween($this, $target);
            }

            $valid = true;
            foreach ($obstacles as $obstacle) {
                if (Geometry::intersectsSegmentCircle($this, $destination, $obstacle)) {
                    $valid = false;
                    break;
                }
            }

            if ($valid) {
                $this->speed = $speed;
                $this->direction = Geometry::angleInDegree($this,$destination);
                return;
            }

            $deviation += 10;
            $destination = Geometry::rotateEnd($this, $destination, $deviation);
        }
    }
};