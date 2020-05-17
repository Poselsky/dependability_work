<?php

function transpose(array $array) : Array
{
    $keys = array_keys($array);
    return array_map(function($array) use ($keys) {
        return array_combine($keys, $array);
    }, array_map(null, ...array_values($array)));
}