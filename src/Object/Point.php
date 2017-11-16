<?php

namespace Halite\Object;

use Halite\Geometry;

class Point {
    /**
     * @var float
     */
    protected $x;

    /**
     * @var float
     */
    protected $y;

    /**
     * Position constructor.
     * @param float $x
     * @param float $y
     */
    public function __construct($x, $y) {
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * @return float
     */
    public function x(): float
    {
        return $this->x;
    }

    /**
     * @return float
     */
    public function y(): float
    {
        return $this->y;
    }

    /**
     * Angle in degree between this object and a target
     * @param Point $target
     * @return float
     */
    public function angleBetweenInDegree(Point $target): float {
        return Geometry::angleInDegree($this, $target);
    }

    /**
     * Distance between this object and a target
     * @param Point $target
     * @return float
     */
    public function distanceBetween(Point $target): float {
        return Geometry::distance($this, $target);
    }
};