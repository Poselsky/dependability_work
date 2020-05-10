<?php



function buildTable($S)
{
    $Rp = array();
    $rows = sizeof($S);
    $columns = sizeof($S[0]);

    for ($i = 0; $i < $rows; $i++) {
        for ($k = 0; $k < $columns; $k++) {
            $h = $k + 1;

            $nextOneRight = ($k + 1) % $columns;
            $nextTwoRight = ($k + 2) % $columns;

            if($S[$i][$k] === 1) {
                $Rp[$i][2 * $h - 1] = 'X';
                $Rp[$i][2 * $h - 2] = 'X';
            } else {
                if ($S[$i][$nextOneRight] === 0) {
                    $Rp[$i][2 * $h - 1] = 0;
                }else {
                    $Rp[$i][2 * $h - 1] = 1;
                }

                if ($S[$i][$nextTwoRight] === 0) {
                    $Rp[$i][2 * $h - 2] = 0;
                }else {
                    $Rp[$i][2 * $h - 2] = 1;
                }
            }
        }
    }

    return $Rp;
}
