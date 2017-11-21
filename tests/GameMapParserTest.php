<?php

namespace Halite\Tests;

use Halite\GameMapParser;

use PHPUnit_Framework_TestCase;

class GameMapParserTest extends PHPUnit_Framework_TestCase {
    private $map = '2 0 3 0 75.0000 100.0000 255 0.0000 0.0000 0 0 0 0 1 75.0000 97.0000 255 0.0000 0.0000 0 0 0 0 2 75.0000 103.0000 255 0.0000 0.0000 0 0 0 0 1 3 3 225.0000 100.0000 255 0.0000 0.0000 0 0 0 0 4 225.0000 97.0000 255 0.0000 0.0000 0 0 0 0 5 225.0000 103.0000 255 0.0000 0.0000 0 0 0 0 14 0 161.6405 111.6405 1971 7.7311 3 0 1113 0 0 0 1 138.3595 111.6405 1971 7.7311 3 0 1113 0 0 0 2 138.3595 88.3595 1971 7.7311 3 0 1113 0 0 0 3 161.6405 88.3595 1971 7.7311 3 0 1113 0 0 0 4 157.3554 170.8320 1227 4.8138 2 0 693 0 0 0 5 61.2322 139.6428 1227 4.8138 2 0 693 0 0 0 6 53.8768 68.8108 1227 4.8138 2 0 693 0 0 0 7 142.6446 29.1680 1227 4.8138 2 0 693 0 0 0 8 238.7678 60.3572 1227 4.8138 2 0 693 0 0 0 9 246.1232 131.1892 1227 4.8138 2 0 693 0 0 0 10 206.3571 172.6796 1501 5.8877 2 0 847 0 0 0 11 89.0666 167.2211 1501 5.8877 2 0 847 0 0 0 12 93.6429 27.3204 1501 5.8877 2 0 847 0 0 0 13 210.9334 32.7789 1501 5.8877 2 0 847 0 0 0 ';

    public function test_parse() {
        $data = explode(" ", $this->map);
        $parser = new GameMapParser(0, 200, 200);
        $map = $parser->parse($data);

        // my ships and construct
        $this->assertEquals(2, count($map->players()));
        $this->assertEquals(3, count($map->me()->ships()));

        // ship data
        $shipZero = $map->me()->ship(0);
        $this->assertEquals(75,$shipZero->x());
        $this->assertEquals(100, $shipZero->y());
        $this->assertEquals(255, $shipZero->health());

        // enemy ships
        $this->assertEquals(3,count($map->enemyShips()));

        // planet checks
        $this->assertEquals(14,count($map->planets()));
        $this->assertEquals(210.9334, $map->planet(13)->x());
        $this->assertEquals(32.7789, $map->planet(13)->y());
        $this->assertEquals(1501, $map->planet(13)->health());

        // reference mapping
        $map->ship(1)->speed = 7;
        $this->assertEquals(7, $map->me()->ship(1)->speed);
    }
}