<?php

class BlockComparer
{

    static function compare($syndromeTable, $columns)
    {
        $count = 0;

        for ($i = 0; $i < sizeof($syndromeTable); $i++) {
            for ($j = 0; $j < sizeof($columns); $j++) {

                $count++;
                $sTableValue = $syndromeTable[$i][$j];
                $colValue = $columns[$j];

                if ($sTableValue !== $colValue && $sTableValue !== 'X') {
                    break;
                }else{
                    if($j === (sizeof($columns) - 1)){
                        echo "<br>";
                        print_r($syndromeTable[$i]);
                        echo "<br>";
                        echo "Searched column";
                        echo "<br>";
                        print_r($columns);
                        echo "<br>";
                        echo "<br>";


                        return ["indexOfRow" => $i, "numberOfCompares" => $count];
                    }
                }
            }
        }
    }
}
