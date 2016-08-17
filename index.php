<?php

class Player
{
    public $properties = array(
       'health' => array(50, 70)
    );

    private $requiredProperties = array('health');

    public $errors = array();

    public function __construct(array $properties = array())
    {
        $this->setProperties($properties);

        //var_dump($this->errors);

    }

    public function setProperties(array $properties)
    {
        if (count($properties) > 0) {
            foreach ($properties as $property => $value) {
                if (is_string($property) && count($value) == 2) {
                    $this->$property = rand($value[0], $value[1]);
                } else {
                    $values = implode(', ', $value);
                    $this->errors[] = "$property with values $values was not set!";
                }
            }
        } else {
            $this->errors[] = 'At least 1 property needed';
        }
    }
}

class Battle
{
    public function __construct($player1, $player2)
    {
        $this->firstPlayer = $firstPlayer;
        $this->secondPlayer = $secondPlayer;
    }

    public function attack()
    {

    }

    public function setPlayer($player1, $player2)
    {
    }
}


$properties = array(
    'health' => array(50, 70),
    'speed'  => array(40, 60),
);

$Orderus = new Player($properties);


$properties = array(
    'health' => array(40, 60),
    'speed'  => array(30, 50),
);

$beast = new Player($properties);

for ($i=1; $i<=20; $i++) {
    if ($i == 1) {
        if ($Orderus->speed > $beast->speed) {
            $player1 = $Orderus;
            $player2 = $beast;
        } else if ($Orderus->speed < $beast->speed) {
            $player1 = $beast;
            $player2 = $Orderus;
        } else if ($Orderus->speed == $beast->speed) {
            die('egalitate...');
        }
    }
}






//var_dump(get_object_vars($hero));


