<?php

function frog(int $lengthWay)
{
    $kamni = [1, 1, 1, 1, 1, 0, 1, 0, 1, 0, 1, 1];

    $weight  [301]    = array_fill(0, 301, 0);
    $dump [301][1001] = 0;

    for ($i = 0; $i <= 301; $i++) {
        for ($v = 0; $v <= 1001; $v++) {
            $dump[$i][$v] = 0;
        }
    }

    for ($i = 0; $i <= $lengthWay; $i++) {
        $weight[$i] = $kamni[$i];
    }

    for ($i = 0; $i <= $lengthWay; $i++) {
        for ($v = 0; $v <= $lengthWay / 2; $v++) {
            $dump[$v][$i] = 99999;
        }
    }

    $dump[0][0] = 0;

    for ($i = 0; $i < $lengthWay; $i++) {
        for ($v = 0; $v < $lengthWay / 2; $v++) {

            if ($v > 0 && $weight[$i + $v]) {
                $dump[$v][$i + $v] = min($dump[$v][$i + $v], $dump[$v][$i] + 1);
            }

            if ($v > 1 && $weight[$i + $v - 1]) {
                $dump[$v - 1][$i + $v - 1] = min($dump[$v - 1][$i + $v - 1], $dump[$v][$i] + 1);
            }

            if ($weight[$i+$v+1]) {
                $dump[$v + 1][$i + $v + 1] = min($dump[$v + 1][$i + $v + 1], $dump[$v][$i] + 1);
            }
        }
    }

    $answer = [];

    for ($v = 0; $v <= $lengthWay / 2; $v++) {
        $answer [] = $dump[$v][$lengthWay];
    }

    print_r($answer);
}

frog(12);
