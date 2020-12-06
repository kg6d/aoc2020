<?php

$lines = explode("\n", file_get_contents('input.txt'));
$max_id = 0;
$seat_taken = [];

foreach ($lines as $line) {
    $front_plane = 0;
    $back_plane = 127;
    $left_side = 0;
    $right_side = 7;

    for ($k = 0; $k < strlen($line); $k++) {
        switch ($line[$k]) {
            case 'F':
                $back_plane = ($front_plane  + $back_plane +1)/2 - 1;
                break;

            case 'B':
                $front_plane = ($front_plane + $back_plane + 1)/2;
                break;

            case 'R':
                $left_side = ($left_side + $right_side+1)/2;
                break;

            case 'L':
                $right_side = ($left_side + $right_side+1)/2 - 1;
                break;

            default:
                break;
        }
    }

    $seat_id = ($front_plane * 8) + $left_side;
    $seat_taken[$seat_id] = 1;
    if($seat_id > $max_id) {
        $max_id = $seat_id;
    }
}

print("Maximum Seat number is: $max_id".PHP_EOL);

for ($j = $max_id; $j >= 0; $j--) {
    if (!isset($seat_taken[$j])) {
        print("My seat number is: $j".PHP_EOL);
        break;
    }
}


