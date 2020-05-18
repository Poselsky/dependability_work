<?php

function factorial(int $num, $acc = 1)
{
    if($num <= 1) {
        return $acc;
    } else {
        return factorial($num-1, $num * $acc);
    }
}
?>

<?php
function combination_number ($n, $k) 
{
    if ($k > $n) {
        throw new Exception("N must be bigger than K");
    }
    return factorial($n) / (factorial($n - $k) * factorial($k));
}
?>