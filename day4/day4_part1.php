<?php

$handle = fopen("input.txt", "r");
$passport_count = 0;
$passport = [];
$line_array =[];
$invalid_passport_count = 0;
$valid_passport_format = [
    'byr', //(Birth Year)
    'iyr', // (Issue Year)
    'eyr', // (Expiration Year)
    'hgt', // (Height)
    'hcl', // (Hair Color)
    'ecl', // (Eye Color)
    'pid', // (Passport ID)
    'cid' // (Country ID)
    ];

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

if ($handle) {
    while (($buffer = fgets($handle, 512)) !== false) {
        if ($buffer[0] != "\n") {
            if (str_word_count($buffer, 0, ' ') > 0) {
                $line_array[] = explode(" ", trim($buffer));
            } else {
                $line_array[] = trim($buffer);
            }
        } elseif ($buffer[0] == "\n") {
            $line_array = nestedArrayToSingleArray($line_array);
            foreach ($line_array as $value) {
                $passport[] = strtok($value, ":");
            }
            if (count($passport) < 7) {
                $invalid_passport_count++;
            } elseif (count($passport) == 7)    {
                $missing_items = array_diff($valid_passport_format, $passport);
                if (!empty($missing_items)) {
                    foreach ($missing_items as $item) {
                        if ($item != 'cid') {
                            print(implode(" ", $passport).PHP_EOL);
                            $invalid_passport_count++;
                        }
                    }
                }
            }
            if (!empty($passport)) {
                $passport_count++;
                unset($passport);
            }
            unset($line_array);
        }
    }
    fclose($handle);
}
print("Total Count of Valid Passports: ".($passport_count - $invalid_passport_count).PHP_EOL);
