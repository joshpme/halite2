<?php

namespace Halite\Tests;

use Halite\Geometry;
use Halite\Object\Circle;
use Halite\Object\Point;

use PHPUnit_Framework_TestCase;

class GeometryTest extends PHPUnit_Framework_TestCase {
    public function test_distance() {
        $start = new Point(3,2);
        $end = new Point(6,6);
        $distance = Geometry::distance($start, $end);
        $this->assertEquals(5, $distance);
    }

    public function test_angle_in_rad() {
        $start = new Point(3,3);
        $end = new Point(6,6);
        $rad = Geometry::angleInRad($start,$end);
        $this->assertEquals(0.78, $rad, '', 0.01);
    }

    public function test_angle_in_degree() {
        $start = new Point(3,3);
        $end = new Point(6,6);
        $rad = Geometry::angleInDegree($start,$end);
        $this->assertEquals(45, $rad, '', 1);
    }

    public function test_rotate_end() {
        $start = new Point(0,0);
        $end = new Point(10,10);
        $destination = Geometry::rotateEnd($start,$end, 180);
        $this->assertEquals(-10, $destination->x());
        $this->assertEquals(-10, $destination->y());
    }

    public function test_degree_to_rad() {
        $degree = 20;
        $rad = Geometry::toRad($degree);
        $this->assertEquals(0.349, $rad,'',0.001);
    }

    public function test_rad_to_degree() {
        $rad = 1.5;
        $degree = Geometry::toDegree($rad);
        $degree = round($degree, 6);

        $this->assertEquals(85.9437, $degree,'',0.001);
    }

    public function test_line_intersects_circle() {
        $start = new Point(0,0);
        $end = new Point(100,0);
        $circle = new Circle(50, -1, 1);
        $padding = 0.5;
        $this->assertTrue(Geometry::intersectsSegmentCircle($start, $end, $circle, $padding));

        $end = new Point(0,100);
        $circle = new Circle(50, 50, 1);
        $padding = 0.5;
        $this->assertFalse(Geometry::intersectsSegmentCircle($start, $end, $circle, $padding));

        $end = new Point(100,100);
        $circle = new Circle(50, 50, 1);
        $padding = 0.5;
        $this->assertTrue(Geometry::intersectsSegmentCircle($start, $end, $circle, $padding));

        $end = new Point(-100,-100);
        $circle = new Circle(-40, -20, 1);
        $padding = 14;
        $this->assertTrue(Geometry::intersectsSegmentCircle($start, $end, $circle, $padding));
    }

    public function test_point_on_line() {
        $start = new Point(4,4);
        $end = new Point(-4,-4);
        $distance = $start->distanceBetween($end) / 2;

        $point = Geometry::pointOnLine($start,$end,$distance);

        $this->assertEquals(0, $point->x());
        $this->assertEquals(0, $point->y());

        $start = new Point(-4,4);
        $end = new Point(4,-4);
        $distance = $start->distanceBetween($end) / 2;

        $point = Geometry::pointOnLine($start,$end,$distance);

        $this->assertEquals(0, $point->x());
        $this->assertEquals(0, $point->y());

    }
}