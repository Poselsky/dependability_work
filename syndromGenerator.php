<?php

class SyndromeGenerator{
    function getSyndromeGeneratedTable($syndromeTable){
        for ($i=0; $i < sizeof($syndromeTable); $i++) { 
            for ($k=0; $k < sizeof($syndromeTable[0]); $k++) { 
                if($syndromeTable[$i][$k] === 'X'){
                    $syndromeTable[$i][$k] = rand(0,1);
                }
            }
        }
    }
}