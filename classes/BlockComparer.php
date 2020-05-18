<?php
require_once(realpath(dirname(__FILE__) . '/../helpers/transpose.php'));
require_once(realpath(dirname(__FILE__) . '/SyndromeTable.php'));

class BlockComparer
{
    function __construct(array $tableOfPotentionalSyndromes, array $tableOfRandomSyndromes)
    {
        $this->tableOfPotentionalSyndromes = $tableOfPotentionalSyndromes;
        $this->tableOfRandomSyndromes = $tableOfRandomSyndromes;
    }

    private function generic_compare($tableOfPotentialSyndromes, $randomSyndromArray, $rowOrColumn = "row") 
    {
        $syndromeTableRowSize= sizeof($tableOfPotentialSyndromes);

        $count = 0;

        for ($i = 0; $i < $syndromeTableRowSize; $i++) {
            for ($j = 0; $j < sizeof($randomSyndromArray); $j++) {

                $count++;
                $sTableValue = $tableOfPotentialSyndromes[$i][$j];
                $colValue = $randomSyndromArray[$j];

                if ($sTableValue !== $colValue && $sTableValue !== 'X') {
                    break;
                }else{
                    if($j === (sizeof($randomSyndromArray) - 1)){
                        return new StatInfo($tableOfPotentialSyndromes, $i, $randomSyndromArray, $count, $rowOrColumn);
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

        return $this->generic_compare($transposed_potentional_syndromes, $column, "column");
    }

    public function compare_rows() 
    {
        $size = sizeof($this->tableOfPotentionalSyndromes);
        return $this->generic_compare($this->tableOfPotentionalSyndromes, $this->tableOfRandomSyndromes[rand(0, $size - 1)], "row");
    }
}
?>

<?php
class StatInfo
{
    public function __construct($potentionalSyndromeTable,$index, $syndromeArray, $numberOfCompares, $rowOrColumn = "row")
    {
        $this->potentionalSyndromeTable = $potentionalSyndromeTable;
        $this->index = $index;
        $this->syndromeArray = $syndromeArray;
        $this->numberOfCompares = $numberOfCompares;
        $this->rowOrColumn = $rowOrColumn;
    }

    public function pretty_print() {
        echo "<h2>Matching table of potential syndromes with actual syndromes: " . $this->rowOrColumn . "</h2>";
        echo "<p>Index where failure occured: " . $this->index. "</p>";
        echo "<p>Number of iterations to find faulty unit: " . $this->numberOfCompares . "</p>";
        $this->pretty_print_syndrome_table();
        echo "<p>Faulty units: " . SyndromeTable::get_table_combinations_units()[$this->index] ."</p>";
    }

    private function pretty_print_syndrome_table() 
    {
        $tableSize = sizeof($this->potentionalSyndromeTable);

        echo "<div class=\"grid_wrapper\">";


            echo "<div class=\"potentional_syndrome_table_wrapper\">";
                for($i = 0; $i < $tableSize; $i++) {
                    echo "<span>|</span>";
                    for($j = 0; $j < sizeof($this->potentionalSyndromeTable[0]); $j++)  {
                        echo "<span>" . $this->potentionalSyndromeTable[$i][$j] . "</span>";
                    }
                    echo "<span>|</span><br>";
                }
            echo "</div>";


            echo "<div class=\".actual_syndrome_array_wrapper\">";
                for($i = 0; $i < $tableSize; $i++) {
                    if($i === $this->index) {
                        for($j = 0; $j < sizeof($this->syndromeArray); $j++)  {
                            echo "<span>" . $this->syndromeArray[$j] . "</span>";
                        }
                    } else {
                        echo "<br>";
                    }
                }
            echo "</div>";


        echo "</div>";
    }
}
