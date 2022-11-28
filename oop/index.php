<?php
require_once "Car.php";
require_once "Plane.php";

// What is class and instance
class Person{
    public $name;
    public $surname;
    private $age;

    public function setAge($age){
        $this->age = $age;
    }

    public function getAge(){
        return $this->age;
    }
}

$p = new Person();
$p->name = 'Tom';
$p->surname = 'Slaytor';

echo '<pre>';
var_dump($p);
echo '</pre>';

echo $p->name.'<br/>';
$p->setAge(36);
echo $p->getAge().'<br/>'.'<br/>'.'<br/>';

$vehicle = new Car('Mercedes', 's-class', 120);
$vehicle1 = new Car('VW', 'Golf', 105);
echo $vehicle->make.'<br/>';
echo $vehicle->getSpeed().'<br/>';
echo 'Number of cars created: ' . Car::getCounter().'<br/>';

$aircraft = new Plane('Airbus', '388', 2000, 'big');
echo 'This aircraft is made by '. $aircraft->make. 
    '. The model is '. $aircraft->model.
    '. Its top speed is '. $aircraft->getSpeed().
    ' and it is: '.$aircraft->size.'<br/>';

// since php 7.4 you can specify the types in a class e.g. 

class Animal{
    public string $name;
    public string $catagory;
    public int $age;
}

// when you specify the type you can't assing the value null
// unless you put a ? infront of the value, e.g.
class Fish{
    public string $name;
    public string $catagory;
    public ?int $age;
}
// in this case, age CAN be null