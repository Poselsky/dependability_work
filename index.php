<?php

require('./classes/SyndromeTable.php');
require('./potentionalSyndromTableBuilder.php');
require('./syndromGenerator.php');

$syndrome_table = buildTable(SyndromeTable::get_table(), 5);
print_r($syndrome_table);
