<?php

require_once 'NestedArray.php';

$handle = fopen("day4_part1_input.txt", "r");
$passport_count = 0;
$passport = [];
$line_array =[];
$invalid_passport_count = 0;
$skip_passport_check = false;
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

$valid_eye_colors = ['amb', 'blu', 'brn', 'gry', 'grn', 'hzl', 'oth'];

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
                $key = strtok($value, ":");
                if (($pos = strpos($value, ":")) !== FALSE) {
                    $passport[$key] = substr($value, $pos+1);
                }
                print($key." ".$passport[$key].PHP_EOL);
            }
            if (count($passport) < 7) {
                $invalid_passport_count++;
                $skip_passport_check = true;
            } elseif (count($passport) == 7) {
                $keys = array_keys($passport);
                $missing_items = array_diff($valid_passport_format, $keys);
                if (!empty($missing_items)) {
                    foreach ($missing_items as $item) {
                        if ($item != 'cid') {
                            $invalid_passport_count++;
                            $skip_passport_check = true;
                        }
                    }
                }
            }
            if (!$skip_passport_check) {
                $bad_passport = false;
                foreach ($passport as $key => $value) {
                    switch ($key) {
                        case 'byr':
                            if (!(strlen($value) == 4 && intval($value) >= 1920 && intval($value) <= 2002 )) {
                                $bad_passport = true;
                            }
                            break;
                        case 'iyr':
                            if (!(strlen($value) == 4 && intval($value) >= 2010 && intval($value) <= 2020 )) {
                                $bad_passport = true;
                            }
                            break;
                        case 'eyr':
                            if (!(strlen($value) == 4 && intval($value) >= 2020 && intval($value) <= 2030 )) {
                                $bad_passport = true;
                            }
                            break;
                        case 'hgt':
                            $suffix = substr($value, -2);
                            if ($suffix != 'cm' && $suffix != 'in') {
                                $bad_passport = true;
                                break;
                            }
                            $value = substr($value, 0,-2);
                            if ($suffix == 'cm') {
                                if (!(intval($value) >= 150 && intval($value) <= 193 )) {
                                    $bad_passport = true;
                                    break;
                                }
                            } elseif ($suffix == 'in') {
                                if (!(intval($value) >= 59 && intval($value) <= 76)) {
                                    $bad_passport = true;
                                }
                            }
                            break;
                        case 'hcl':
                            if (!preg_match('/^#[0-9a-f]{6}$/', trim($value))) {
                                $bad_passport = true;
                            }
                            break;
                        case 'ecl':
                            if (!in_array($value, $valid_eye_colors)) {
                                $bad_passport = true;
                            }
                            break;
                        case 'pid':
                            if (!preg_match('/^[0-9]{9}$/', trim($value))) {
                                $bad_passport = true;
                            }
                            break;

                        default:
                    }
                }
                if ($bad_passport) {
                    $invalid_passport_count++;

                }
            }
            $skip_passport_check = false;

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

