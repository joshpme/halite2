<?php
/**
 * Created by PhpStorm.
 * User: Josh
 * Date: 16/11/2017
 * Time: 7:20 PM
 */

namespace Halite;


class Networking
{
    /**
     * Read output data from game
     *
     * @return string
     */
    public function read() {
        $input = fgets(STDIN);
        if ($input === false) {
            exit();
        }
        return rtrim($input);
    }

    /**
     * Send data to game (eg. BotName or Moves)
     *
     * @param string $data
     */
    public function send($data) {
        fwrite(STDOUT, $data . "\n");
    }
}