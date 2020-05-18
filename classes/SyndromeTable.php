<?php 
class SyndromeTable {
    public static function get_table_combinations () : Array
    {
        $table = array();
         // n = 5 k = 1
        $table[0][0] = 1;
        $table[0][1] = 0;
        $table[0][2] = 0;
        $table[0][3] = 0;
        $table[0][4] = 0;

        $table[1][0] = 0;
        $table[1][1] = 1;
        $table[1][2] = 0;
        $table[1][3] = 0;
        $table[1][4] = 0;

        $table[2][0] = 0;
        $table[2][1] = 0;
        $table[2][2] = 1;
        $table[2][3] = 0;
        $table[2][4] = 0;

        $table[3][0] = 0;
        $table[3][1] = 0;
        $table[3][2] = 0;
        $table[3][3] = 1;
        $table[3][4] = 0;

        $table[4][0] = 0;
        $table[4][1] = 0;
        $table[4][2] = 0;
        $table[4][3] = 0;
        $table[4][4] = 1;

        $table[4][0] = 0;
        $table[4][1] = 0;
        $table[4][2] = 0;
        $table[4][3] = 0;
        $table[4][4] = 1;

        // n = 5 k = 2

        $table[5][0] = 1;
        $table[5][1] = 1;
        $table[5][2] = 0;
        $table[5][3] = 0;
        $table[5][4] = 0;

        $table[6][0] = 1;
        $table[6][1] = 0;
        $table[6][2] = 1;
        $table[6][3] = 0;
        $table[6][4] = 0;

        $table[7][0] = 1;
        $table[7][1] = 0;
        $table[7][2] = 0;
        $table[7][3] = 1;
        $table[7][4] = 0;

        $table[8][0] = 1;
        $table[8][1] = 0;
        $table[8][2] = 0;
        $table[8][3] = 0;
        $table[8][4] = 1;

        $table[9][0] = 0;
        $table[9][1] = 1;
        $table[9][2] = 1;
        $table[9][3] = 0;
        $table[9][4] = 0;

        $table[10][0] = 0;
        $table[10][1] = 1;
        $table[10][2] = 0;
        $table[10][3] = 1;
        $table[10][4] = 0;

        $table[11][0] = 0;
        $table[11][1] = 1;
        $table[11][2] = 0;
        $table[11][3] = 0;
        $table[11][4] = 1;

        $table[12][0] = 0;
        $table[12][1] = 0;
        $table[12][2] = 1;
        $table[12][3] = 1;
        $table[12][4] = 0;

        $table[13][0] = 0;
        $table[13][1] = 0;
        $table[13][2] = 1;
        $table[13][3] = 0;
        $table[13][4] = 1;

        $table[14][0] = 0;
        $table[14][1] = 0;
        $table[14][2] = 0;
        $table[14][3] = 1;
        $table[14][4] = 1;

        return $table;
    }

    public static function get_table_combinations_units() : Array
    {
        $combinedArray = ["u1","u2","u3","u4","u5","u1,u2", "u1,u3", "u1,u4", "u1,u5", "u2,u3", "u2,u4", "u2,u5", "u3,u4", "u3,u5", "u4,u5"];
        
        return $combinedArray;
    }

    public static function generate_possible_points_of_failure() : Array
    {
        $table_combs = self::get_table_combinations();
        $Rp = array();
        $rows = sizeof($table_combs);
        $columns = sizeof($table_combs[0]);

        for ($i = 0; $i < $rows; $i++) {
            for ($k = 0; $k < $columns; $k++) {
                $h = $k + 1;

                $nextOneRight = ($k + 1) % $columns;
                $nextTwoRight = ($k + 2) % $columns;

                if($table_combs[$i][$k] === 1) {
                    $Rp[$i][2 * $h - 1] = 'X';
                    $Rp[$i][2 * $h - 2] = 'X';
                } else {
                    if ($table_combs[$i][$nextOneRight] === 0) {
                        $Rp[$i][2 * $h - 1] = 0;
                    }else {
                        $Rp[$i][2 * $h - 1] = 1;
                    }

                    if ($table_combs[$i][$nextTwoRight] === 0) {
                        $Rp[$i][2 * $h - 2] = 0;
                    }else {
                        $Rp[$i][2 * $h - 2] = 1;
                    }
                }
            }
        }

        return $Rp;
    }
}