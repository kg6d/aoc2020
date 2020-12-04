<?php

$handle = fopen("day2_input.txt", "r");
$total_cnt = 0;
if ($handle) {
    while (($buffer = fgets($handle, 50)) !== false) {
        $line_array = explode(" ", $buffer );
        list($min, $max) = explode("-", $line_array[0]);
        $needle = $line_array[1][0];
        $haystack_array = str_split(trim($line_array[2]));
        if ($haystack_array[$min-1] == $needle && $haystack_array[$max-1] != $needle ||
            $haystack_array[$min-1] != $needle && $haystack_array[$max-1] == $needle) {
            $total_cnt++;
        }
    }
    fclose($handle);
}
print("Total Count: ".$total_cnt.PHP_EOL);
