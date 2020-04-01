<?php

/**
 * @param array $matrixs
 *
 * @return mixed
 */
function hooks(array $matrixs)
{
    $countMatrix = count($matrixs) - 1;
    $result      = [];

    for ($i = 1; $i <= $countMatrix; $i++) {
        $result[$i][$i] = 0;
    }

    for ($i = 2; $i <= $countMatrix; $i++) {
        for ($k = 1; $k <= ($countMatrix - $i + 1); $k++) {
            $j              = $k + $i - 1;
            $result[$k][$j] = INF;
            for ($h = $k; $h <= $j - 1; $h++) {
                $result[$k][$j] = min(
                    $result[$k][$j],
                    $result[$k][$h] + $result[$h + 1][$j] + $matrixs[$k - 1] * $matrixs[$h] * $matrixs[$j]
                );
            }
        }
    }

    show($result);

    return $result[1][$countMatrix];
}

function show(array $result)
{
    print_r('Расстановка скобок: ');

    foreach ($result as $items => $values) {
        $l = $items;
        foreach ($values as $item => $res) {
            $r = $item;

            if ($l == $r) {
                print_r("\n" . "A" . ($l + 1));
            } else {
                print_r('(');
                print_r(sprintf('%s', $l));
                print_r(" x ");
                print_r(sprintf('%s', $r));
                print_r(")");
            }
        }
    }
}

$matrixs = [10, 20, 50, 1, 100];

$hooks = hooks($matrixs);

print_r("\n" . "Результат: " . $hooks . "\n");