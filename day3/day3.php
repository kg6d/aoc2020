<?php

$handle = fopen("input.txt", "r");
$tree_cnt = 0;
$index = 3;
$incr = 3;

if ($handle) {
    fgets($handle, 40);  // comment out for part 2 and adject $index & $incr as needed
    while (($buffer = fgets($handle, 40)) !== false) {
        print($buffer);
        $line_array = str_split(trim($buffer));
        $line_length = count($line_array);
        if ($line_array[$index] == "#") {
            $tree_cnt++;
        }
        $index += $incr;
        if ($index >= $line_length) {
            $index -= $line_length;
        }
        //@fgets($handle, 40); // uncomment for part2
    }
    fclose($handle);
}
print("Total Count: ".$tree_cnt.PHP_EOL);


