<?php

namespace Halite\Tests;

use Halite\Object\Point;

use PHPUnit_Framework_TestCase;

class PointTest extends PHPUnit_Framework_TestCase {
    public function test_construct() {
        $x = rand(-100,100);
        $y = rand(-100,100);
        $position = new Point($x,$y);
        $this->assertEquals($x, $position->x());
        $this->assertEquals($y, $position->y());
    }

    public function test_angle_between() {
        $start = new Point(0,0);

        // same location
        $end = new Point(0,0);
        $angle = $start->angleBetweenInDegree($end);
        $this->assertEquals(0, $angle);

        // 45 degrees
        $end = new Point(5,5);
        $angle = $start->angleBetweenInDegree($end);
        $this->assertEquals(45, $angle);

        // 90 degrees
        $end = new Point(0,5);
        $distance = $start->angleBetweenInDegree($end);
        $this->assertEquals(90, $distance);

        // 135 degrees
        $end = new Point(-5,5);
        $distance = $start->angleBetweenInDegree($end);
        $this->assertEquals(135, $distance);

        // 180 degrees
        $end = new Point(-5,0);
        $distance = $start->angleBetweenInDegree($end);
        $this->assertEquals(180, $distance);

        // 225 degrees
        $end = new Point(-5,-5);
        $distance = $start->angleBetweenInDegree($end);
        $this->assertEquals(225, $distance);

        // 270 degrees
        $end = new Point(0,-5);
        $distance = $start->angleBetweenInDegree($end);
        $this->assertEquals(270, $distance);

        // 315 degrees
        $end = new Point(5,-5);
        $distance = $start->angleBetweenInDegree($end);
        $this->assertEquals(315, $distance);
    }

    public function test_distance() {
        $start = new Point(0,0);

        // only x
        $end = new Point(5,0);
        $distance = $start->distanceBetween($end);
        $this->assertEquals(5, $distance);

        // only y
        $end = new Point(0,5);
        $distance = $start->distanceBetween($end);
        $this->assertEquals(5, $distance);

        // on angle
        $end = new Point(3,4);
        $distance = $start->distanceBetween($end);
        $this->assertEquals(5, $distance);

        // different direction
        $end = new Point(-3,-4);
        $distance = $start->distanceBetween($end);
        $this->assertEquals(5, $distance);
    }

}