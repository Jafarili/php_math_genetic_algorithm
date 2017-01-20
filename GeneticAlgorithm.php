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
    public $probability = array();
    public $cumulative_probability = array();

    public $total_fitness = 0;

    public function __construct()
    {
        for ($i=0;$i<5;$i++)
            $this->chromosome[$i] = array(rand(0,10),rand(0,10),rand(0,10));

        $this->calcFx();

        $this->calcFitness();
        $this->calcProbability();

        var_dump($this->cumulative_probability);
    }

    public function calcFx(){
        for ($i=0;$i<5;$i++)
            $this->fx[$i] = abs(($this->chromosome[$i][0] + ($this->chromosome[$i][1] * 2) + ($this->chromosome[$i][2] * 3)) - 10);
    }

    public function calcFitness(){
        for ($i=0;$i<5;$i++) {
            $this->fitness[$i] = 1 / (1 + $this->fx[$i]);
            $this->total_fitness += $this->fitness[$i];
        }
    }

    public function calcProbability(){
        $sum = 0;
        for ($i=0;$i<5;$i++) {
            $this->probability[$i] = $this->fitness[$i] / $this->total_fitness;
            $sum += $this->probability[$i];
            $this->cumulative_probability[$i] = $sum;
        }
    }
}