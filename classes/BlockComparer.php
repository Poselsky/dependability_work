<?php
require_once(realpath(dirname(__FILE__) . '/../helpers/transpose.php'));

class BlockComparer
{
    function __construct(array $tableOfPotentionalSyndromes, array $tableOfRandomSyndromes)
    {
        $this->tableOfPotentionalSyndromes = $tableOfPotentionalSyndromes;
        $this->tableOfRandomSyndromes = $tableOfRandomSyndromes;
    }

    private function generic_compare($tableOfPotentialSyndromes, $randomSyndromeRow) 
    {
        $syndromeTableRowSize= sizeof($tableOfPotentialSyndromes);

        $count = 0;

        for ($i = 0; $i < $syndromeTableRowSize; $i++) {
            for ($j = 0; $j < sizeof($randomSyndromeRow); $j++) {

                $count++;
                $sTableValue = $tableOfPotentialSyndromes[$i][$j];
                $colValue = $randomSyndromeRow[$j];

                if ($sTableValue !== $colValue && $sTableValue !== 'X') {
                    break;
                }else{
                    if($j === (sizeof($randomSyndromeRow) - 1)){
                        echo "<br>";
                        print_r($tableOfPotentialSyndromes[$i]);
                        echo "<br>";
                        echo "Searched column:";
                        echo "<br>";
                        print_r($randomSyndromeRow);
                        echo "<br>";
                        echo "<br>";


                        return ["indexOfRow" => $i, "numberOfCompares" => $count];
                    }
                }
            }
        }
    }

    public function compare_columns()
    {
        $transposed_potentional_syndromes = transpose($this->tableOfPotentionalSyndromes);
        $size = sizeof($transposed_potentional_syndromes); 
        $column = array_column($this->tableOfRandomSyndromes, rand(0, $size-1));

        return $this->generic_compare($transposed_potentional_syndromes, $column);
    }

    public function compare_rows() 
    {
        $size = sizeof($this->tableOfPotentionalSyndromes);
        return $this->generic_compare($this->tableOfPotentionalSyndromes, $this->tableOfRandomSyndromes[rand(0, $size - 1)]);
    }
}

class StatInfo
{

}
