<?php

function nestedArrayToSingleArray(array $array) : array
{
    $singleDimArray = [];

    foreach ($array as $item) {

        if (is_array($item)) {
            $singleDimArray = array_merge($singleDimArray, nestedArrayToSingleArray($item));

        } else {
            $singleDimArray[] = $item;
        }
    }
    return $singleDimArray;
}


