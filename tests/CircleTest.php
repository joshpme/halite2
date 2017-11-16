<?php

namespace Halite\Tests;

use Halite\Object\Circle;

use PHPUnit_Framework_TestCase;

class CircleTest extends PHPUnit_Framework_TestCase {
    public function test_construct() {
        $x = rand(-100,100);
        $y = rand(-100,100);
        $radius = rand(0,20);
        $circle = new Circle($x,$y,$radius);
        $this->assertEquals($x, $circle->x());
        $this->assertEquals($y, $circle->y());
        $this->assertEquals($radius, $circle->radius());
    }
}