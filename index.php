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

class Game
{
    private $attackers  = array();
    private $defenders = array();
    public $players = array();

    public function addPlayer($player)
    {
        $this->players[] = new Player($player);
    }

    public function play()
    {
        $this->setFirstAttack();
        $this->startFight();
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
    private function setFirstAttack()
    {
        $this->sortPlayers();

        $this->attackers = array_slice($this->players, 0, 1);
        $this->defenders = array_slice($this->players, 1);

        print_r($this->players);
    }

    /**
     * @param int $rounds
     */
    public function startFight($rounds = 20)
    {
        for ($i=1; $i<=$rounds; $i++) {

            echo "THE ROUND $i STARTED: \n\n";

            /** @var Player $attacker */
            foreach ($this->attackers as $attacker) {

                echo "{$attacker->name} attacks with {$attacker->strength} strength the ";

                /** @var Player $defender */
                foreach ($this->defenders as $k => $defender) {

                    if ( ! self::getLuck($defender->luck)) {
                        self::attack($attacker, $defender);

                        // Rapid strike
                        if (isset($attacker->rapidStrike) && self::getLuck($attacker->rapidStrike)) {
                            echo "{$defender->name} is using Rapid strike... \n";
                            self::attack($attacker, $defender);
                        }

                        if ($defender->health < 0) {
                            echo $defender->name . " is out! \n";
                            unset($this->defenders[$k]);
                        }

                    } else {
                        echo "attacker has missed :)) \n";
                    }

                }

            }

            $winners = null;

            if ( ! count($this->attackers)) {
                $winners = $this->defenders;
            } else if ( ! count($this->defenders)) {
                $winners = $this->attackers;
            }

            if (isset($winners)) {
                echo "The winners is: \n\n";
                print_r($winners);
                die('GAME OVER');
            }

            // Change attackers with defenders...
            echo "change turn... \n\n";

            list($this->attackers,$this->defenders) = array($this->defenders,$this->attackers);

        }
    }
    /**
     * @var Player $attacker
     * @var Player $defender
     */
    private static function attack($attacker, $defender)
    {
        $damage = $attacker->strength - $defender->defence;

        // Magic shield
        if (isset($defender->magicShield) && self::getLuck($defender->magicShield)) {
            echo "{$defender->name} is using magic shield... \n";
            $damage = $damage/2;
        }

        echo '(' . $attacker->strength . " - " . $defender->defence . ") \n\n";

        echo "{$defender->name} with {$defender->defence} defence wich have $damage damage from {$defender->health} health. \n";
        $defender->health -= $damage;
        echo "Health remaining: {$defender->health} \n";

    }

    /**
     * @param int $chance
     * @return bool
     */
    private static function getLuck($chance)
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
    'health' => rand(70, 100),
    'strength'  => rand(70, 80),
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

$game->play();

//var_dump($game->players);