<?php

/*
 * TODO: What happens when luck is same?
 */


$hero = array(
    'health' => rand(50, 70),
    'speed'  => rand(40, 60),
    'defence' => rand(45, 55),
    'speed' => rand(40, 50),
    'luck' => rand(10, 30),
    'skills' => array(
        'rapidStrike' => 10,
        'magicShield' => 20,
    ),
);

class Player
{
    public $name;
    public $health;
    public $strength;
    public $defence;
    public $speed;
    public $luck;
    public $hasLuck = false;

    public $rapidStrike;
    public $magicShield;

    public function __construct(array $player) {
        foreach ($player as $property) {
            if (property_exists($property)) {

            } else {
                // @TODO: Property doesn't exists
            }
        }
    }
}

class Hero extends Player
{
    public $player = 'beast';
    public $strike = 10; // strike twice
    public $magicShield = 20; // half from damage when enemy attacks

    public function __construct()
    {
        $this->health = rand(70, 100);
        $this->strength = rand(70, 80);
        $this->defence = rand(45, 55);
        $this->speed = rand(40, 50);
        $this->luck = rand(10, 30);
    }

}


class Battle
{
    public $attack  = array(); // Default attack - hero. (Not mentioned in game...)
    public $defence = array();
    public $players

    public function __construct(array $players)
    {

        $this->players = $this->sortPlayers($players);

        foreach ($players as $player) {
            if (is_array($player) && count($players) > 0) {
                $this->players[] = new Player($player);
            } else {
                // @TODO: no player
            }
        }

        $this->determineFirstAttack();
    }

    /**
     * sort players by speed, health
     * @return array
     */
    private function sortPlayers($players)
    {
        foreach ($players as $k => $player) {
            $speed[$k] = $player['speed'];
            $luck[$k] = $player['luck'];
        }

        array_multisort($speed, SORT_DESC, $luck, SORT_DESC, $players);

        return $players;
    }

    public function determineFirstAttack()
    {




        foreach ($this->players as $k => $player) {

            if ($player)

        }


        if ($this->beast->speed > $this->hero->speed) {
            $this->attack = $this->beast->player;
            $this->defence = $this->hero->player;
        } else if ($this->beast->speed == $this->hero->speed) {
            if ($this->beast->luck > $this->hero->luck) {
                $this->attack = $this->beast->player;
                $this->defence = $this->hero->player;
            }
        }

        echo "First attack is carried by " . $this->attack . "\n";

        $this->fight();

    }

    public function fight($rounds = 1)
    {
        for ($i=1; $i<=$rounds; $i++) {
            $this->attack();
        }
    }

    public function attack()
    {
        $this->hero->hasLuck = $this->getLuck($this->hero->luck);
        $this->beast->hasLuck = $this->getLuck($this->beast->luck);

        $damage = $this->{$this->attack}->strength - $this->{$this->defence}->defence;
        echo "Damage was $damage from {$this->defence} " . $this->{$this->defence}->health . "\n";
        $this->{$this->defence}->health -= $damage;

        var_dump(get_object_vars($this->hero));
        var_dump(get_object_vars($this->beast));
        echo "\n";

    }

    /**
     * @return bool;
     */
    public function getLuck($chance)
    {
        if (rand(1, 100) <= $chance) {
            echo "Has luck this time! :) ($chance%) \n";
            return true;
        }

        echo "No luck this time! :( ($chance%) \n";
        return false;
    }

}


//$hero = new Hero;
//$beast = new Beast;


new Battle;

