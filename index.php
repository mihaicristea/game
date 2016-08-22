<?php

/*
 * TODO: What happens when speed and luck have same values? (not mentioned in game)
 * Feature added: Fight more than 2 players
 */

require_once __DIR__.'/vendor/autoload.php';

use Game\Player;
use Game\Game;

$hero = array(
    'name' => 'hero',
    'health' => rand(70, 100),
    'strength'  => rand(70, 80),
    'defence' => rand(45, 55),
    'speed' => rand(40, 50),
    'luck' => rand(10, 30),
    'skills' => array(
        'rapidStrike' => array(
            'attack' => 1,
            'chance' => 10
        ),
        'magicShield' => array(
            'defence' => 1,
            'chance' => 20
        ),
    ),
);

$beast = array(
    'name' => 'beast',
    'health' => rand(60, 90),
    'strength'  => rand(60, 90),
    'defence' => rand(40, 60),
    'speed' => rand(40, 60),
    'luck' => rand(25, 40),
);

//$monster = array(
//    'name' => 'monster',
//    'health' => rand(60, 90),
//    'strength'  => rand(60, 90),
//    'defence' => rand(40, 60),
//    'speed' => rand(40, 60),
//    'luck' => rand(25, 40),
//    'skills' => array(
//        'rapidStrike' => array(
//            'attack' => 1,
//            'chance' => 50
//        ),
//        'magicShield' => array(
//            'defence' => 1,
//            'chance' => 100
//        ),
//    ),
//);

try {
    $game = new Game;

    $game->addPlayer($hero);
    $game->addPlayer($beast);
    $game->addPlayer($monster); // Feature

    $game->startFight();

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . " on line " . $e->getLine() . "\n\n";
}