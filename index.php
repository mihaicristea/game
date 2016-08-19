<?php

/*
 * TODO: What happens when speed and luck have same values?
 */

class Player
{
    public $name;
    public $health;
    public $strength;
    public $defence;
    public $speed;
    public $luck;

    public $rapidStrike;
    public $magicShield;

    private $hasLuck = false;
    private $requiredProperties = array('name', 'health', 'strength', 'defence', 'speed', 'luck');

    public function __construct(array $player) {

        // Check for required properties
        if ($needed = array_diff($this->requiredProperties, array_keys($player))) {
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

class Game
{
    private $attackers  = array();
    private $defenders = array();
    public $players = array();

    public function addPlayer($player)
    {
        $this->players[] = new Player($player);
    }

    public function prepareForFight()
    {
        $this->determineFirstAttack();
    }

    /**
     * sort players by speed, health
     * @return array
     */
    private function sortPlayers()
    {
        foreach ($this->players as $k => $player) {
            $speed[$k] = $player->speed;
            $luck[$k] = $player->luck;
        }

        array_multisort($speed, SORT_DESC, $luck, SORT_DESC, $this->players);
    }

    /**
     * First attack is carried by first element. The others elements represents defender (defenders may be a feature)
     */
    private function determineFirstAttack()
    {
        $this->sortPlayers();

        $this->attackers = array_slice($this->players, 0, 1);
        $this->defenders = array_slice($this->players, 1);

        $this->fight();

//        echo "Attacker: ";
//        var_dump($this->attacker);
//        echo "Defender: ";
//        var_dump($this->defender);
//
//        echo "Players: ";
//        var_dump($this->players);
    }

    public function fight($rounds = 1)
    {
        for ($i=1; $i<=$rounds; $i++) {

            /** @var Player $attacker */
            foreach ($this->attackers as $attacker) {

                /** @var Player $defender */
                foreach ($this->defenders as $defender) {
                    $damage = $attacker->health - $defender->defence;
                    $defender->health -= $damage;
                    echo "Damage was $damage from {$defender->health} \n";
                }

            }
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

$hero = array(
    'name' => 'hero',
    'health' => rand(50, 70),
    'strength'  => rand(40, 60),
    'defence' => rand(45, 55),
    'speed' => rand(40, 50),
    'luck' => rand(10, 30),
    'rapidStrike' => 10,
    'magicShield' => 20,
);

$beast = array(
    'name' => 'beast',
    'health' => rand(60, 90),
    'strength'  => rand(60, 90),
    'defence' => rand(40, 60),
    'speed' => rand(40, 60),
    'luck' => rand(25, 40),
);

$monster = array(
    'name' => 'monster',
    'health' => rand(60, 90),
    'strength'  => rand(60, 90),
    'defence' => rand(40, 60),
    'speed' => rand(40, 60),
    'luck' => rand(25, 40),
);


$game = new Game;

$game->addPlayer($hero);
$game->addPlayer($beast);
$game->addPlayer($monster);

$game->prepareForFight();

//var_dump($game->players);