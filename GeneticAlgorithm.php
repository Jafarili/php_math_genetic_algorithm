<?php

/**
 * The main class is this
 * this class is going to calculate the algorithm
 *
 * Created by PhpStorm.
 * User: ali
 * Date: 1/20/2017
 * Time: 13:41:20
 */
class GeneticAlgorithm
{
    public $chromosome = array();

    public function __construct()
    {
        for ($i=0;$i<5;$i++)
            $chromosome[$i] = array(rand(0,10),rand(0,10),rand(0,10));

        var_dump($chromosome);
    }
}