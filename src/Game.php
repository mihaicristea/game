<?php

namespace Game;

use Game\Player;
use Game\View;

class Game
{
    private $attackers  = array();
    private $defenders = array();
    public $players = array();

    /**
     * @param array $player
     */
    public function addPlayer(array $player)
    {
        $this->players[] = new Player($player);
    }

    /**
     * Sort players by speed, health, etc...
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
    }

    /**
     * @param int $rounds
     */
    public function startFight($rounds = 20)
    {
        View::add("-------------------------------------------------------------------\n");
        View::add("------------------------ The fight started ------------------------\n");
        View::add("-------------------------------------------------------------------\n");

        for ($i=1; $i<=$rounds; $i++) {

            if ($i == 1) {
                $this->setFirstAttack();
            }

            View::add("\n------------------------ Round number: $i ------------------------\n");
            View::add("*** The fight is carried by '{$this->attackers[0]->name}' ***\n");

            /** @var Player $attacker */
            foreach ($this->attackers as $attacker) {

                View::add("{$attacker->name} attacks (strength: {$attacker->strength}, health: {{$attacker->strength}})  the ");

                /** @var Player $defender */
                foreach ($this->defenders as $k => $defender) {

                    if ( ! self::getLuck($defender->luck)) {
                        $this->attack($attacker, $defender);

                        if ($defender->health < 0) {
                            View::add($defender->name . " is out! \n");
                            unset($this->defenders[$k]);
                        }

                    } else {
                        View::add( "attacker has missed :)) \n");
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
                View::add("\nGAME OVER! \nThe winners is: \n\n");
                print_r($winners);
                View::output();
                die();
            }

            // Switch attackers with defenders...
            list($this->attackers,$this->defenders) = array($this->defenders,$this->attackers);
        }

        View::output();
    }
    /**
     * @var Player $attacker
     * @var Player $defender
     */
    private function attack(Player $attacker, Player $defender)
    {
        $params = array();

        $params['damage'] = $attacker->strength - $defender->defence;

        $this->useSkills($attacker, $params, 'attack');
        $this->useSkills($defender, $params, 'defence');

        View::add('(' . $attacker->strength . " - " . $defender->defence . ") \n\n");

        View::add("{$defender->name} with {$defender->defence} defence wich have {$params['damage']} damage from {$defender->health} health. \n");
        $defender->health -= $params['damage'];
        View::add("Health remaining: {$defender->health} \n");

    }

    /**
     * @param Player $player
     * @param array $params
     * @param string $useWhen
     * @return array $params
     */
    private function useSkills(Player $player, array $params = array(), $useWhen)
    {
        if (isset($player->skills) && count($player->skills) > 0) {
            foreach ($player->skills as $skill => $value) {
                if (isset($value[$useWhen]) && $value[$useWhen] == 1 ) {
                    $params = $this->{"set$skill"}($player, $params); // setmagicShield // not ok
                    return $params;
                }
            }
        }
    }

    /**
     * @param Player $player
     * @param array $params
     * @return array
     */
    private function setMagicShield(Player $player, array $params)
    {
        // Magic shield
        if (isset($player->skills['magicShield']) && self::getLuck($player->skills['magicShield']['chance'])) {
            if ( ! isset($params['damage'])) {
                // @TODO: damage params missing!
                die('Damagae params missing!');
            }
            View::add("\n+++ {$player->name} is using magic shield +++\n");
            $params['damage'] = $params['damage'] / 2;

            return $params;
        }
    }

    /**
     * @param Player $player
     * @param array $params
     * @return array
     */
    private function setRapidStrike(Player $player, array $params)
    {
        // Rapid strike
        if (isset($player->skills['rapidStrike']) && self::getLuck($player->skills['rapidStrike']['chance'])) {
            View::add("\n+++ {$player->name} is using rapid strike +++\n");
            $params['damage'] = $params['damage'] * 2;
            return $params;
        }
    }

    /**
     * @param int $chance
     * @return bool
     */
    private static function getLuck($chance)
    {
        if (rand(1, 100) <= $chance) {
            View::add("Has luck this time! :) ($chance%) \n");
            return true;
        }

        return false;
    }

}