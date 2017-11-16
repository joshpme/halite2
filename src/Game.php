<?php
/**
 * Created by PhpStorm.
 * User: Josh
 * Date: 16/11/2017
 * Time: 7:26 PM
 */

namespace Halite;


class Game
{
    private $network;

    public function init() {
        $this->network = new Networking();
        $init = $this->network->read();
        file_put_contents("temp.txt", $init);
        exit();
    }

    public function ready($botName) {

    }

    public function move($moves) {

    }
}