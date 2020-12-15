<?php
require_once('./classes/SyndromeTable.php');
require_once('./classes/IndexGenerator.php');
require_once('./classes/RandomSyndromeGenerator.php');
require_once('./classes/BlockComparer.php');
require_once('./helpers/comb.php');


echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"style.css\"/>";
// echo "-----------------------------------------------------------------";
// echo "<br>";

$syndrome_table_X = SyndromeTable::generate_possible_points_of_failure();
$syndrome_table_rand = RandomSyndromeGenerator::generate_random_failure($syndrome_table_X);


$input = [[0,1,2,3,4],
          [5,6,7,8,9,10,11,12,13,14]];
$prop = [80,20];

$indexGenerator = new IndexGenerator();

$randomRowIndex = $indexGenerator->get_random_index_by_probability($input, $prop);
$randomRow = $syndrome_table_rand[$randomRowIndex];

echo "Index of generated syndrom: " . $randomRowIndex;
echo "<br>";
// doplneni nahodne 0 / 1 za X v radku
for ($i=0; $i < sizeof($randomRow); $i++) {
    if($randomRow[$i] === 'X'){
        $randomRow[$i] = rand(0,1);
    }
}
// $randomRow ted obsahuje nas novy syndrom, ktery budu porovnavat vuci tabulce
print_r ($randomRow);

$blockComparer = new BlockComparer($syndrome_table_X, $syndrome_table_rand);
$blockComparer->commonRandomSyndromArray = $randomRow;

$blockComparer->compare_columns()->pretty_print();
$blockComparer->compare_rows()->pretty_print();

///////////////////////////////////////////////////
/// 4 UNITS SYSTEM
///////////////////////////////////////////////////
echo "<br>";
echo "<br>";
print_r("4 Units system");

$syndrome_table_X_four_units = SyndromeTable::generate_possible_points_of_failure_four_units();
$syndrome_table_rand_four_units = RandomSyndromeGenerator::generate_random_failure($syndrome_table_X_four_units);


$input_four_units = [[0,1,2,3],
          [4,5,6,7,8,9]];
$prop_four_units = [80,20];

$randomRowIndex_four_units = $indexGenerator->get_random_index_by_probability($input_four_units, $prop_four_units);
$randomRow_four_units = $syndrome_table_rand_four_units[$randomRowIndex_four_units];

echo "Index of generated syndrom: " . $randomRowIndex_four_units;
echo "<br>";
// doplneni nahodne 0 / 1 za X v radku
for ($i=0; $i < sizeof($randomRow_four_units); $i++) {
    if($randomRow_four_units[$i] === 'X'){
        $randomRow_four_units[$i] = rand(0,1);
    }
}
// $randomRow ted obsahuje nas novy syndrom, ktery budu porovnavat vuci tabulce


$blockComparer_four_units = new BlockComparer($syndrome_table_X_four_units, $syndrome_table_rand_four_units);
$blockComparer_four_units->commonRandomSyndromArray = $randomRow_four_units;

// TODO ALG NEED TO BE REDESIGN
//$blockComparer_four_units->compare_columns()->pretty_print();

$blockComparer_four_units->compare_rows()->pretty_print();

///////////////////////////////////////////////////
/// END OF 4 UNITS SYSTEM
///////////////////////////////////////////////////


///////////////////////////////////////////////////
/// DATABASE
///////////////////////////////////////////////////

$servername = "localhost";
$username = "root";
$password = "";
try {
    $conn = new PDO("mysql:host=$servername;dbname=dependability", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
    for ($j=0; $j < 0; $j++) {
     
        $syndrome_table_X = SyndromeTable::generate_possible_points_of_failure();
        $syndrome_table_rand = RandomSyndromeGenerator::generate_random_failure($syndrome_table_X);


        $input = [[0,1,2,3,4],
                [5,6,7,8,9,10,11,12,13,14]];
        $prop = [80,20];

        $indexGenerator = new IndexGenerator();

        $randomRowIndex = $indexGenerator->get_random_index_by_probability($input, $prop);
        $randomRowOriginal = $syndrome_table_X[$randomRowIndex];
        $randomRow = $syndrome_table_rand[$randomRowIndex];
        $randomRowStr = "";
        $randomRowOriginalStr = "";

        // doplneni nahodne 0 / 1 za X v radku
        for ($i=0; $i < sizeof($randomRow); $i++) {
    
            if($randomRow[$i] === 'X'){
                $randomRow[$i] = rand(0,1);
            }
            $randomRowOriginalStr = $randomRowOriginalStr . $randomRowOriginal[$i];

            $randomRowStr = $randomRowStr . $randomRow[$i];
        }
    

        $blockComparer = new BlockComparer($syndrome_table_X, $syndrome_table_rand);
        $blockComparer->commonRandomSyndromArray = $randomRow;

        $infoRows = $blockComparer->compare_rows();
        $iterationsRows = $infoRows->numberOfCompares;
        $faultyUnitsRows = $infoRows->faultyUnites;

        // echo $something->compare_columns()->numberOfCompares;
        // echo $something->compare_columns()->numberOfCompares;
        $infoCols = $blockComparer->compare_columns();
        $iterationsCols = $infoCols->numberOfCompares;
        $faultyUnitsCols = $infoCols->faultyUnites;
    
        // prop_four_units[0] - prop for 1 faulty unit
        // prop for replacing X with 0 -  50

        $prob = strval($prop_four_units[0]);

    
        $sqlCol = "INSERT INTO statistic (devVersion,numberOfUnits,comparisonType, probability_gen_syndrom,probability_x_replacement, syndromeOriginal, syndromeRandom, rowIndex, iterationToFaultyUnit, faultyUnits, description)
            VALUES ('0','5','col','$prob','50', '$randomRowOriginalStr', '$randomRowStr', '$randomRowIndex','$iterationsCols','$faultyUnitsCols' , '' )";

        $sqlRow = "INSERT INTO statistic (devVersion,numberOfUnits,comparisonType, probability_gen_syndrom,probability_x_replacement, syndromeOriginal, syndromeRandom, rowIndex, iterationToFaultyUnit, faultyUnits, description)
        VALUES ('0','5','row','$prob','50', '$randomRowOriginalStr', '$randomRowStr', '$randomRowIndex','$iterationsRows','$faultyUnitsRows' , '' )";
            
          $conn->exec($sqlCol);
         $conn->exec($sqlRow);
   
       
    }
   
   
   
   
   } catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
   }

//   SELECT AVG(iterationToFaultyUnit) FROM `statistic` WHERE comparisonType = "row" AND numberOfUnits = "5"
//   SELECT AVG(iterationToFaultyUnit) FROM `statistic` WHERE comparisonType = "row" AND numberOfUnits = "4"

// try {
//     $conn = new PDO("mysql:host=$servername;dbname=dependability", $username, $password);
//     // set the PDO error mode to exception
//     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
//     for ($j=0; $j < 200; $j++) {
     
//         $syndrome_table_X = SyndromeTable::generate_possible_points_of_failure();
//         $syndrome_table_rand = RandomSyndromeGenerator::generate_random_failure($syndrome_table_X);


//         $input = [[0,1,2,3,4],
//                 [5,6,7,8,9,10,11,12,13,14]];
//         $prop = [80,20];

//         $indexGenerator = new IndexGenerator();

//         $randomRowIndex = $indexGenerator->get_random_index_by_probability($input, $prop);
//         $randomRowOriginal = $syndrome_table_X_four_units[$randomRowIndex];
//         $randomRow = $syndrome_table_rand[$randomRowIndex];
//         $randomRowStr = "";
//         $randomRowOriginalStr = "";

//         // doplneni nahodne 0 / 1 za X v radku
//         for ($i=0; $i < sizeof($randomRow); $i++) {
    
//             $randomRowOriginalStr = $randomRowOriginalStr . $randomRowOriginal[$i];
//             if($randomRow[$i] === 'X'){
//                 $randomRow[$i] = rand(0,1);
//             }

//             $randomRowStr = $randomRowStr . $randomRow[$i];
//         }
//         // $randomRow ted obsahuje nas novy syndrom, ktery budu porovnavat vuci tabulce
//         print_r ($randomRow);

//         $blockComparer = new BlockComparer($syndrome_table_X, $syndrome_table_rand);
//         $blockComparer->commonRandomSyndromArray = $randomRow;

//         $infoRows = $blockComparer->compare_rows();
//         $iterationsRows = $infoRows->numberOfCompares;
//         $faultyUnitsRows = $infoRows->faultyUnites;

//         // echo $something->compare_columns()->numberOfCompares;
//         // echo $something->compare_columns()->numberOfCompares;
//         $infoCols = $blockComparer->compare_columns();
//         $iterationsCols = $infoCols->numberOfCompares;
//         $faultyUnitsCols = $infoCols->faultyUnites;
    
//         // prop_four_units[0] - prop for 1 faulty unit
//         // prop for replacing X with 0 -  50

//         $prob = strval($prop_four_units[0]);

    
//         $sqlCol = "INSERT INTO statistic (devVersion,numberOfUnits,comparisonType, probability_gen_syndrom,probability_x_replacement, syndromeOriginal, syndromeRandom, rowIndex, iterationToFaultyUnit, faultyUnits, description)
//             VALUES ('0','5','col','$prob','50', '$randomRowOriginalStr', '$randomRowStr', '$randomRowIndex','$iterationsCols','$faultyUnitsCols' , '' )";

//         $sqlRow = "INSERT INTO statistic (devVersion,numberOfUnits,comparisonType, probability_gen_syndrom,probability_x_replacement, syndromeOriginal, syndromeRandom, rowIndex, iterationToFaultyUnit, faultyUnits, description)
//         VALUES ('0','5','row','$prob','50', '$randomRowOriginalStr', '$randomRowStr', '$randomRowIndex','$iterationsRows','$faultyUnitsRows' , '' )";
            
//           $conn->exec($sqlCol);
//           $conn->exec($sqlRow);
   
       
//     }
   
   
   
   
//    } catch(PDOException $e) {
//     echo "Connection failed: " . $e->getMessage();
//    }


//////////////////////////////////// N - 4 ROWS
// try {
//     $conn = new PDO("mysql:host=$servername;dbname=dependability", $username, $password);
//     // set the PDO error mode to exception
//     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
//     for ($j=0; $j < 300; $j++) {
     
      
//         $syndrome_table_X_four_units = SyndromeTable::generate_possible_points_of_failure_four_units();
//         $syndrome_table_rand_four_units = RandomSyndromeGenerator::generate_random_failure($syndrome_table_X_four_units);


//         $input_four_units = [[0,1,2,3],
//                 [4,5,6,7,8,9]];
//         $prop_four_units = [80,20];

//         $randomRowIndex_four_units = $indexGenerator->get_random_index_by_probability($input_four_units, $prop_four_units);
//         $randomRow_four_units = $syndrome_table_rand_four_units[$randomRowIndex_four_units];
//         $randomRow_four_units_ori = $syndrome_table_X_four_units[$randomRowIndex_four_units];

//         $randomRowOriginalStr= "";
//         $randomRowStr= "";
     
//         for ($i=0; $i < sizeof($randomRow_four_units); $i++) {

//             $randomRowOriginalStr = $randomRowOriginalStr . $randomRow_four_units_ori[$i];

//             if($randomRow_four_units[$i] === 'X'){
//                 $randomRow_four_units[$i] = rand(0,1);
//             }

//             $randomRowStr = $randomRowStr . $randomRow_four_units[$i];
//         }

//         $blockComparer_four_units = new BlockComparer($syndrome_table_X_four_units, $syndrome_table_rand_four_units);
//         $blockComparer_four_units->commonRandomSyndromArray = $randomRow_four_units;
  
//         $infoRows = $blockComparer_four_units->compare_rows();
//         $iterationsRows = $infoRows->numberOfCompares;
//         $faultyUnitsRows = $infoRows->faultyUnites;

//         $prob = strval($prop_four_units[0]);


//         $sqlRow = "INSERT INTO statistic (devVersion,numberOfUnits,comparisonType, probability_gen_syndrom,probability_x_replacement, syndromeOriginal, syndromeRandom, rowIndex, iterationToFaultyUnit, faultyUnits, description)
//         VALUES ('0','4','row','$prob','50', '$randomRowOriginalStr', '$randomRowStr', '$randomRowIndex','$iterationsRows','$faultyUnitsRows' , '' )";

//           $conn->exec($sqlRow);

//     }

//    } catch(PDOException $e) {
//     echo "Connection failed: " . $e->getMessage();
//    }