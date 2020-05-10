<?php



function buildTable($S, $n)
{
    $Rp = [5][15];

    for ($i = 0; $i < 15; $i++) {
        for ($k = 0; $k < 5; $k++) {

            $h = $k + 1;

            if ($S[$i][$k] == 1) {
                $Rp[$i][2 * $h - 2] = 'X';
                $Rp[$i][2 * $h - 1] = 'X';
            } else {

                if ($k == ($n - 2)) {
                    if ($S[$i][$k + 1] == 0) {
                        $Rp[$i][2 * $h - 2] = 0;
                    } else {
                        $Rp[$i][2 * $h - 2] = 1;
                    }

                    if ($S[$i][0] == 0) {
                        $Rp[$i][2 * $h - 1] = 0;
                    } else {
                        $Rp[$i][2 * $h - 1] = 1;
                    }
                } else if ($k == ($n - 1)) {
                    $z = 0;

                    if ($S[$i][$z] == 0) {
                        $Rp[$i][2 * $h - 2] = 0;
                    } else {
                        $Rp[$i][2 * $h - 2] = 1;
                    }

                    if ($S[$i][$z + 1] == 0) {
                        $Rp[$i][2 * $h - 1] = 0;
                    } else {
                        $Rp[$i][2 * $h - 1] = 1;
                    }
                }
            }
        }
    }

    return $Rp;
}
