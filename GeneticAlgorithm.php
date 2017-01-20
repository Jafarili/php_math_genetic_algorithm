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
    public $max_fitness = array();

    public $crossover_rate = 0.5;
    public $mutation_rate = 0.1;
    public $population = 200;
    public $iteration = 0;
    public $total_fitness = 0;

    public function __construct()
    {
        $finish_point = null;
        for ($i=0;$i<5;$i++)
            $this->chromosome[$i] = array(0=>rand(0,10),1=>rand(0,10),2=>rand(0,10));

        echo "init chromosome is:".json_encode($this->chromosome);

        while (is_null($finish_point) && $this->iteration < $this->population) {
            $this->selection();

            echo "<br>$this->iteration => selection chromosome is:" . json_encode($this->chromosome);

            $this->crossOver();

            echo "<br>$this->iteration => crossOver chromosome is:" . json_encode($this->chromosome);

            $this->mutation();

            echo "<br>$this->iteration => mutation chromosome is:" . json_encode($this->chromosome);

            $this->iteration++;

            for ($i = 0; $i < 5; $i++){
                if ($this->chromosome[$i][0] + 2 * $this->chromosome[$i][1] + 3 * $this->chromosome[$i][2] == 10) {
                    $finish_point = $i;
                    $this->calcFx();
                    $this->calcFitness();
                }
            }
        }

        echo "<br>when finish chromosome is:".json_encode($this->chromosome);

        echo "<br>when finish max_fitness is:";
        var_dump($this->max_fitness);

        echo "<br>when finish finish_point is:".$finish_point;
        echo "<br>".$this->chromosome[$finish_point][0] ." + (2*".$this->chromosome[$finish_point][1].") + (3*".$this->chromosome[$finish_point][2].") = 10";
    }

    public function calcFx(){
        for ($i=0;$i<5;$i++)
            $this->fx[$i] = abs(($this->chromosome[$i][0] + ($this->chromosome[$i][1] * 2) + ($this->chromosome[$i][2] * 3)) - 10);
    }

    public function calcFitness(){
        for ($i=0;$i<5;$i++) {
            $this->fitness[$i] = 1 / (1 + $this->fx[$i]);
            if ( !isset($this->max_fitness[$this->iteration]) || ($this->fitness[$i] >  $this->max_fitness[$this->iteration]))
                $this->max_fitness[$this->iteration] = $this->fitness[$i];
            $this->total_fitness += $this->fitness[$i];
        }
    }

    public function maxFitness() {
        return $this->max_fitness;
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

        $new_chromosome = $this->chromosome;
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
        $this->parents = array();

        for($m=0; $m<5 ; $m++) {
            $random = mt_rand() / mt_getrandmax();
            if($random < $this->crossover_rate) {
                $this->parents[] = $m;
            }
        }

        $length = count($this->parents);

        foreach ($this->parents as $n) {
            $cut_position = rand(1,2);

            $dady = array_slice($this->chromosome[$n], 0, $cut_position);

            if($n+1 < $length) {
                $momy = array_slice($this->chromosome[$n+1], $cut_position);
            } else
                $momy = array_slice($this->chromosome[0], $cut_position);

            $newChromosome = array_merge($dady , $momy);

            $this->chromosome[$n] = $newChromosome;
        }
        //var_export($this->chromosome);
    }

    /*public function crossOver() {
        $this->parents = array();

        for($m=0; $m<5 ; $m++) {
            $random = mt_rand() / mt_getrandmax();
            if($random < $this->crossover_rate) {
                $this->parents[] = $m;
            }
        }

        foreach ($this->parents as $n) {
            $cut_position = rand(1,2);

            $dady = array_slice($this->chromosome[$n], 0, $cut_position);
            $momy = array_slice($this->chromosome[$n], $cut_position);

            $newChromosome = array_merge($dady , $momy);

            $this->chromosome[$n] = $newChromosome;
        }

            // echo $this->chromosome[$this->parents[$n]];
            /*for($p = 0; $p < $cut; $p++) {
                $newChromosome[$p] = $this->chromosome[$this->parents[$n]][$p];
            }
            for($t = $cut ;$t < count($this->chromosome[$this->parents[$n]]); $t++) {
                $u = $t + 1;
                if($u > $count) {
                    $newChromosome[$t] = $this->chromosome[0][$t];
                }
                else
                    $newChromosome[$t] = $this->chromosome[$this->parents[$u]][$t];
            }
            var_export($newChromosome);
            // $this->chromosome[$this->parents[$n]] = ??
    }*/

    public function mutation(){

        $mutation_count = floor((3 * 5) * $this->mutation_rate);

        for ($i=0;$i<$mutation_count;$i++){
            $position = rand(1,(3 * 5));
            $chosen_chromosome = ceil($position / 3) - 1;
            $chosen_gen = ($position+2) % 3;

            $this->chromosome[$chosen_chromosome][$chosen_gen] = rand(0,10);
        }
    }

}