<?php

namespace Game\Player;

class Player
{
    public $name;
    public $health;
    public $strength;
    public $defence;
    public $speed;
    public $luck;

    public $skills = array();

    public $hasLuck = false;
    private $requiredStats = array('name', 'health', 'strength', 'defence', 'speed', 'luck');

    public function __construct(array $player) {

        // Check for required properties
        if ($needed = array_diff($this->requiredStats, array_keys($player))) {
            $needed = implode(", ", $needed);
            die("$needed properties missing!");
            // @TODO: requiredProperties needed!
        }
        foreach ($player as $property => $value) {
            if (property_exists('Player', $property)) {
                $this->{$property} = $value;
            } else {
                die('Property doesn\'t exists');
                // @TODO: Property doesn't exists
            }
        }
    }
}