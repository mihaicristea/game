<?php

namespace Game;

class Player
{
    // Required states
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

            throw new \Exception("'$needed' properties missing!");
        }
        foreach ($player as $property => $value) {
            if (property_exists($this, $property)) {
                $this->{$property} = $value;
            } else {
                throw new \Exception("Property '$property' doesn't exists");
            }
        }
    }
}