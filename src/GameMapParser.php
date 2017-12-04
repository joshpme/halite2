<?php

namespace Halite;

use Halite\Object\Planet;
use Halite\Object\Ship;

class GameMapParser {
    private $map;
    /**
     * GameMapParser constructor.
     * @param integer $playerId
     * @param integer $width
     * @param integer $height
     */
    public function __construct($playerId, $width, $height) {
        $this->id = rand(0,1000);
        $this->map = new GameMap($playerId, $width, $height);
    }

    public function log($message, $data) {
       // file_put_contents("/srv/examplebot/output" . $this->id . ".txt",$message . "\n" . implode(" ", $data) . "\n", FILE_APPEND);
    }

    /**
     * @param array $data
     * @return GameMap
     */
    public function parse(array $data) {
        $data = $this->players($data);
        $this->planets($data);
        return $this->map;
    }

    private function players($data) {
        $players = array_shift($data);

        $this->log("Players: " . $players, $data);

        for ($i = 0; $i < $players; $i++) {
            $playerId = array_shift($data);
            $this->map->addPlayer($playerId);
            $data = $this->ships($data, $this->map->player($playerId));
        }
        return $data;
    }

    private function planets($data) {
        $planets = array_shift($data);
        $params = array(
            "id",
            "x",
            "y",
            "health",
            "radius",
            "dockingSpots",
            "currentProduction",
            "remainingProduction",
            "owned",
            "ownerId",
            "totalShips");

        $this->log("Planets: " . $planets, $data);
        for ($i = 0; $i < $planets; $i++) {
            $info = array();
            foreach ($params as $param) {
                $info[$param] = array_shift($data);
            }
            $owner = null;
            $dockedShips = array();
            if ($info["owned"] == 1) {
                $owner = $this->map->player($info['ownerId']);
                for ($s = 0; $s < $info['totalShips']; $s++) {
                    $shipId = array_shift($data);
                    $dockedShips[] = $owner->ship($shipId);
                }
            }

            $planet = new Planet($this->map,
                $info["id"],
                $info["health"],
                $info["x"],
                $info["y"],
                $info["radius"],
                $info["dockingSpots"],
                $info["currentProduction"],
                $info["remainingProduction"],
                $dockedShips,
                $owner);

            $this->map->addPlanet($planet);
        }
        return $data;
    }

    private function ships(array $data, Player $player) {
        $ships = array_shift($data);
        $params = array(
            "id",
            "x",
            "y",
            "health",
            "velocityX",
            "velocityY",
            "dockingStatus",
            "dockedPlanetId",
            "dockingProgress",
            "weaponCooldown");
        $this->log("Ships: " . $ships, $data);
        for ($i = 0; $i < $ships; $i++) {


            $info = array();
            foreach ($params as $param) {
                $info[$param] = array_shift($data);
            }

            $ship = new Ship($this->map,
                $player,
                $info['id'],
                $info['x'],
                $info['y'],
                $info['health'],
                $info['dockingStatus'],
                $info['dockedPlanetId'],
                $info['dockingProgress'],
                $info['weaponCooldown']
            );
            $this->map->addShip($ship);
            $player->addShip($ship);
        }

        return $data;
    }
}