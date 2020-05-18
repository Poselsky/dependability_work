<?php

require_once('./classes/SyndromeTable.php');
require_once('./classes/RandomSyndromeGenerator.php');
require_once('./classes/BlockComparer.php');



$syndrome_table_X = SyndromeTable::generate_possible_points_of_failure();

$syndrome_table_rand = RandomSyndromeGenerator::generate_random_failure($syndrome_table_X);

$row = $syndrome_table_rand[rand(0, 9)];

$something = new BlockComparer($syndrome_table_X, $syndrome_table_rand);

$something->compare_columns()->pretty_print();
$something->compare_rows()->pretty_print();

echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"style.css\"/>";
