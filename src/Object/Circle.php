<?php

namespace Halite\Object;

class Circle extends Point {
    /**
     * @var float
     */
    protected $radius;

    /**
     * Position constructor.
     * @param float $x
     * @param float $y
     * @param $radius
     */
    public function __construct($x, $y, $radius) {
        $this->radius = $radius;
        parent::__construct($x, $y);
    }

    /**
     * @return float
     */
    public function radius(): float
    {
        return $this->radius;
    }
};