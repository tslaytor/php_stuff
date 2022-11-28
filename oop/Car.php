<?php

class Car{
    public $make;
    public $model;
    private $top_speed;
    // static properties belong to the class, not the instance
    public static $counter = 0;

    public function __construct($make, $model, $top_speed) {
        $this->make = $make;
        $this->model = $model;
        $this->top_speed = $top_speed;
        self::$counter++;
    }

    public function getSpeed(){
        return $this->top_speed;
    }

    public static function getCounter(){
        return self::$counter;
    }

}

?>