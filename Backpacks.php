<?php

/**
 * @param int   $capacity
 * @param array $subjectsWeight
 * @param array $subjectsCost
 * @param int   $limit
 *
 * @return mixed
 */
function limitedBackpack(int $capacity, array $subjectsWeight, array $subjectsCost, int $limit)
{
    $result = [];

    for ($object = 0; $object <= $limit; ++$object) {
        for ($weight = 0; $weight <= $capacity; ++$weight) {

            if ($object == 0 || $weight == 0) {
                $result[$object][$weight] = 0;
            } else {

                if ($subjectsWeight[$object - 1] <= $weight) {
                    $result[$object][$weight] = max(
                        $subjectsCost[$object - 1] + $result[$object - 1][$weight - $subjectsWeight[$object - 1]],
                        $result[$object - 1][$weight]
                    );
                } else {
                    $result[$object][$weight] = $result[$object - 1][$weight];
                }
            }
        }
    }

    return $result[$limit][$capacity];
}

#$limitedBackpack = limitedBackpack(20, [3, 5, 8], [8, 14, 23], 3);

#print_r('Максимальная стоимость  ограниченного рюкзака: ' . $limitedBackpack . "\n");

/**
 * @param int   $capacity
 * @param array $subjectsWeight
 * @param array $subjectsCost
 *
 * @return mixed
 */
function unlimitedBackpack(int $capacity, array $subjectsWeight, array $subjectsCost)
{
    $subjectsCount = count($subjectsWeight);
    $result        = [];

    for ($weight = 0; $weight <= $capacity; $weight++) {
        $result[$weight] = 0;
    }

    for ($weight = 0; $weight <= $capacity; $weight++) {
        for ($object = 0; $object < $subjectsCount; $object++) {

            if ($subjectsWeight[$object] <= $weight) {
                $result[$weight] = max(
                    $result[$weight],
                    $result[$weight - $subjectsWeight[$object]] +
                    $subjectsCost[$object]
                );
            }
        }
    }

    return $result[$capacity];
}

//
//$unlimitedBackpack = unlimitedBackpack(20, [3, 5, 8], [8, 14, 23]);
//
//print_r("Limited: " . $unlimitedBackpack . "\n");

function unlimitBackpacks(int $countVariousThings, int $capacityBackpack, array $weightObjects, array $costObjects)
{
    $flag    = 0;
    $bufMax  = 0;
    $d[1000] = [0];

    while (!$flag) {
        $flag = 1;

        for ($i = 0; $i < $countVariousThings - 1; $i++) {

            if ($weightObjects[$i] > $weightObjects[$i + 1]) {
                swap($weightObjects[$i], $weightObjects[$i+1]);
                swap($costObjects[$i], $costObjects[$i+1]);
                $flag = 0;
            }
        }
    }

    for ($x = 1; $x <= $capacityBackpack; $x++) {
        $bufMax = 0;

        for ($i = 0; $i < $countVariousThings; $i++) {

            if (($x - $weightObjects[$i]) >= 0 && ($d[$x - $weightObjects[$i]] + $costObjects[$i]) > $bufMax) {
                $bufMax = $d[$x - $weightObjects[$i]] + $costObjects[$i];
            }
        }

        $d[$x] = $bufMax;
    }
//
//    for ($i = 0; $i <= $capacityBackpack; $i++) {
//        echo "$d[$i] ";
//    }

    echo "\n";

    echo "Стоимость рюкзака: $d[$capacityBackpack] \n";
    echo "Вещей в  рюкзаке: \n";

    while ($capacityBackpack > 0) {
        for ($i = 0; $i < $countVariousThings; $i++) {

            if ($capacityBackpack - $weightObjects[$i] >= 0) {

                if (($d[$capacityBackpack] - $costObjects[$i]) === $d[$capacityBackpack - $weightObjects[$i]]) {

                    echo "$weightObjects[$i] $costObjects[$i] \n";
                    $capacityBackpack -= $weightObjects[$i];
                    break;
                }
            }
        }
    }
}

$weightObjects = [1, 3, 5, 6, 15];
$costObjects   = [23, 65, 15, 70, 3];

unlimitBackpacks(10, 50, $weightObjects, $costObjects);

/**
 * @param $left
 * @param $right
 */
function swap(&$left, &$right)
{
    if ($left === $right) {
        return;
    }

    $tmp = $left;
    $left = $right;
    $right = $tmp;
}
