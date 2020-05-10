<?php

require('./classes/SyndromeTable.php');
require('./potentionalSyndromTableBuilder.php');
require('./syndromGenerator.php');
require('./blockComparer.php');


$syndrome_table_X = buildTable(SyndromeTable::get_table(), 5);

$syndrome_table_rand = SyndromeGenerator::getSyndromeGeneratedTable($syndrome_table_X);

$row = $syndrome_table_rand[rand(0, 9)];

print_r(BlockComparer::compare($syndrome_table_X, $row));
