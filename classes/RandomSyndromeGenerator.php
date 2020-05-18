<?php

class RandomSyndromeGenerator{
    public static function generate_random_failure($inputTable) : Array
    {
        $syndromeTable = array();
        for ($i=0; $i < sizeof($inputTable); $i++) { 
            for ($k=0; $k < sizeof($inputTable[0]); $k++) { 
                if($inputTable[$i][$k] === 'X'){
                    $syndromeTable[$i][$k] = rand(0,1) ;
                } else {
                    $syndromeTable[$i][$k] = $inputTable[$i][$k];
                }
            }
        }
        return $syndromeTable;
    }
}