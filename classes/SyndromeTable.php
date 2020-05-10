<?php 
class SyndromeTable {
    public static function get_table () : Array
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
}