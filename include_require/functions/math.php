<?php

function add(...$args) {
    $sum = 0;
    foreach ($args as $arg){
        $sum += $arg;
    }
    return $sum;
}

function subtract(...$args) {
    $sum = 0;
    foreach ($args as $arg){
        $sum -= $arg;
    }
    return $sum;
}


?>