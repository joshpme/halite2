<?php

namespace Halite;

class Game
{
    /**
     * @var Networking
     */
    private $network;
    /**
     * @var GameMap
     */
    private $gameMap;

    /**
     * @var integer
     */
    private $playerId;

    /**
     * @var integer
     */
    private $width;
    /**
     * @var integer
     */
    private $height;

    /**
     * @var integer
     */
    private $turn;

    public function __construct() {
        $this->network = new Networking();
    }

    public function init() {
        list($this->playerId) = $this->network->read();
        list($this->width, $this->height) = $this->network->read();

        $parser = new GameMapParser($this->playerId, $this->width, $this->height);

        $this->gameMap = $parser->parse($this->network->read());
        $this->turn = 0;
    }

    public function ready($botName) {
        $this->network->send($botName);
        $this->updateMap();
        $this->turn++;
    }

    public function move() {
        $this->sendMoves();
        $this->updateMap();
        $this->turn++;
    }

    public function sendMoves() {
        $moves = array();
        foreach ($this->gameMap->me()->ships() as $ship) {
            $moves[] = $ship->output();
        }
        $this->network->send(implode(" ",$moves));
    }

    private function updateMap() {
        $parser = new GameMapParser($this->playerId, $this->width, $this->height);
        $this->gameMap = $parser->parse($this->network->read());
    }
}