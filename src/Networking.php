<?php

namespace Halite;

class Networking
{
    /**
     * Read output data from game
     *
     * @return array
     */
    public function read() {
        $input = fgets(STDIN);

        if ($input === false) {
            exit();
        }
        return explode(" ",trim($input));
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