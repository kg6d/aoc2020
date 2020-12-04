<?php

$handle = fopen("day2_input.txt", "r");
$total_cnt = 0;
if ($handle) {
    while (($buffer = fgets($handle, 50)) !== false) {
        $line_array = explode(" ", $buffer );
        list($min, $max) = explode("-", $line_array[0]);
        $needle = $line_array[1][0];
        $haystack = $line_array[2];
        $cnt = substr_count($haystack, $needle);
        if ($cnt >= $min && $cnt <= $max) {
            $total_cnt++;
        }
    }
    fclose($handle);
}
print("Total Count: ".$total_cnt.PHP_EOL);
