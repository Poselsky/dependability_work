<?php

$path = realpath(dirname(__FILE__));

require_once($path . '/../helpers/transpose.php');
require_once($path . '/SyndromeTable.php');
require_once($path . './../helpers/comb.php');

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
        $syndromeTableColumnSize= sizeof($this->tableOfRandomSyndromes);
        $syndromeTableRowSize = sizeof($this->tableOfRandomSyndromes[0]);
        $randomSyndromeArray = $this->commonRandomSyndromArray;

        $compares = 0;
        $statInfo = null;

        $matchingSyndromes = [];

        for($i = 0; $i < $syndromeTableColumnSize; $i++){
            if($randomSyndromeArray[0] == $this->tableOfRandomSyndromes[$i][0]){
                $matchingSyndromes  = $matchingSyndromes + [$i => $this->tableOfRandomSyndromes[$i]];
            }
            $compares++;
        }

        for($i = 1; $i < $syndromeTableRowSize ; $i++){
            if(sizeof($matchingSyndromes) !== 1 ){
                $placeholder = [];
                foreach($matchingSyndromes as $key => $value){
                    if($value[$i] == $randomSyndromeArray[$i]){
                        $placeholder = $placeholder + [$key => $value];
                    }

                    $compares++;
                }

                $matchingSyndromes = $placeholder;
            }
            else {
                break;
            }
        }

        return new StatInfo($this->tableOfPotentionalSyndromes, array_keys($matchingSyndromes)[0], $this->commonRandomSyndromArray, $compares, "column");

    }

    public function compare_rows()
    {
        return $this->generic_compare($this->tableOfPotentionalSyndromes, $this->commonRandomSyndromArray, "row");
    }
}
?>

<?php
class StatInfo implements IStatInfo
{
    public function __construct($potentionalSyndromeTable,$index, $syndromeArray, $numberOfCompares, $rowOrColumn = "row")
    {
        $this->potentionalSyndromeTable = $potentionalSyndromeTable;
        $this->index = $index;
        $this->syndromeArray = $syndromeArray;
        $this->numberOfCompares = $numberOfCompares;
        $this->rowOrColumn = $rowOrColumn;
        $this->faultyUnites = SyndromeTable::get_table_combinations_units()[$this->index];
    }

    public function pretty_print() {
        echo "<h2>Matching table of potential syndromes with actual syndromes: " . $this->rowOrColumn . " algorithm matching</h2>";
        echo "<p>Index where failure occured: " . $this->index. "</p>";
        echo "<p>Number of iterations to find faulty unit: " . $this->numberOfCompares . "</p>";
        $this->pretty_print_syndrome_table();
        echo "<p>Faulty units: " . SyndromeTable::get_table_combinations_units()[$this->index] ."</p>";
    }

    public function pretty_print_syndrome_table()
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

class EmptyStatInfo implements IStatInfo {
    public function pretty_print()
    {
        echo "found nothing";
    }

    public function pretty_print_syndrome_table()
    {

    }
}

interface IStatInfo {
    function pretty_print();
    function pretty_print_syndrome_table();
}
