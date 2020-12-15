<?php

$path = realpath(dirname(__FILE__));

require_once($path . '/../helpers/transpose.php');
require_once($path . '/SyndromeTable.php');
require_once($path . './../helpers/comb.php');

class IndexGenerator
{

    function get_random_index_by_probability($input = [[]], $probability = [50,50]){
        $accumulatedWeight = [];
        $sum = 0;
        for($i = 0; $i < sizeof($probability); $i++){
            $sum += $probability[$i];
            $accumulatedWeight[$i] = $sum;
        }
        $r = rand(0, $sum);

        for($i = 0; $i < sizeof($accumulatedWeight); $i++){
            if($accumulatedWeight[$i] >= $r){
                return rand($input[$i][0], sizeof($input[$i]));
            }
        }
    }
}
?>


