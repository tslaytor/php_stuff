<?php
require_once 'Car.php';

class Plane extends Car{

    public string $size;

    public function __construct($make, $model, $top_speed, $size){
        $this->size = $size;
        parent::__construct($make, $model, $top_speed);
    }
}

// private properties cannot be accessed by other classes
// procected properties can