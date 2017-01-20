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
    public $a;
    public $b;
    public $c;

    public $chromosome = array();
    public $fx = array();
    public $fitness = array();

    public function __construct()
    {
        for ($i=0;$i<5;$i++)
            $this->chromosome[$i] = array(rand(0,10),rand(0,10),rand(0,10));

        $this->calcFx();

        $this->calcFitness();

        var_dump($this->fitness);
    }

    public function calcFx(){
        for ($i=0;$i<5;$i++)
            $this->fx[$i] = abs(($this->chromosome[$i][0] + ($this->chromosome[$i][1] * 2) + ($this->chromosome[$i][2] * 3)) - 10);
    }

    public function calcFitness(){
        for ($i=0;$i<5;$i++)
            $this->fitness[$i] = 1/(1+$this->fx[$i]);
    }
}