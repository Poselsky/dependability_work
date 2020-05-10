<?php

class BlockComparer
{

    static function compare($syndromeTable, $rows)
    {
        $count = 0;

        for ($i = 0; $i < sizeof($syndromeTable); $i++) {
            for ($j = 0; $j < sizeof($rows); $j++) {

                $count++;
                $sTableValue = $syndromeTable[$i][$j];
                $colValue = $rows[$j];

                if ($sTableValue !== $colValue && $sTableValue !== 'X') {
                    break;
                }else{
                    if($j === (sizeof($rows) - 1)){
                        echo "<br>";
                        print_r($syndromeTable[$i]);
                        echo "<br>";
                        echo "Searched column";
                        echo "<br>";
                        print_r($rows);
                        echo "<br>";
                        echo "<br>";


                        return ["indexOfRow" => $i, "numberOfCompares" => $count];
                    }
                }
            }
        }
    }
}
