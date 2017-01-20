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
    public $parents = array();

    public $crossover_rate = 0.25;
    public $mutation_rate = 0.1;
    public $population = 200;
    public $iteration = 0;
    public $total_fitness = 0;

    public function __construct()
    {
        for ($i=0;$i<5;$i++)
            $this->chromosome[$i] = array(rand(0,10),rand(0,10),rand(0,10));

        $this->selection();

        var_dump($this->chromosome);
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

    public function selection(){
        $this->calcFx();

        $this->calcFitness();
        $this->calcProbability();

        $new_chromosome = array();
        for ($i=0;$i<5;$i++) {
            $r[$i] = mt_rand() / mt_getrandmax();

            for ($j=0;$j<5;$j++){
                if ($j == 0) {
                    if ($r[$i] < $this->cumulative_probability[0])
                        $new_chromosome[$i] = $this->chromosome[0];
                }else {
                    if ($r[$i] > $this->cumulative_probability[$j - 1] && $r[$i] < $this->cumulative_probability[$j])
                        $new_chromosome[$i] = $this->chromosome[$j];
                }
            }
        }
        $this->chromosome = $new_chromosome;
    }

    public function crossOver() {
        while($this->iteration < $this->population) {
            for($m=0; $m<4 ; $m++) {
                $random[$m]=mt_rand() / mt_getrandmax();
                if($random[$m] < $this->crossover_rate) {
                    $this->parents[$m] = $this->chromosome[$m];
                }
            }
            $this->iteration += 1;
        }
    }

    public function mutation(){
        $mutation_count = round((3 * 5) * $this->mutation_rate, 0, PHP_ROUND_HALF_DOWN);
        for ($i=0;$i<$mutation_count;$i++){
            $position = rand(1,(3 * 5));
            $chossed_chrom = round($position / 3 , 0 , PHP_ROUND_HALF_UP) - 1;
        }
    }
}