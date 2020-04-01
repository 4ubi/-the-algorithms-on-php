<?php

/**
 * @param array $graph
 * @param int   $from
 *
 * @return array
 */
function fordBellman(array $graph, int $from): array
{
    $vertexCount = count($graph);
    $distance    = [];

    foreach ($graph as $key => $value) {
        $distance[$key] = INF;
    }

    $distance[$from] = 0;

    for ($i = 0; $i < $vertexCount - 1; $i++) {
        for ($j = 0; $j < $vertexCount; $j++) {
            for ($k = 0; $k < $vertexCount; $k++) {

                if ($distance[$j] > ($sum = $distance[$k] + $graph[$k][$j])) {
                    $distance[$j] = $sum;
                }
            }
        }
    }

    for ($i = 0; $i < $vertexCount; $i++) {
        for ($j = 0; $j < $vertexCount; $j++) {

            if ($distance[$i] > $distance[$j] + $graph[$j][$i]) {
                echo 'Граф содержит цикл с отрицательным весом!';

                return [];
            }
        }
    }

    return $distance;
}


$graph = [
    0 => [INF, 25, 15, 3, 2],
    1 => [25, INF, 8, INF, 8],
    2 => [15, 8, INF, 4, INF],
    3 => [3, INF, 4, INF, 3],
    4 => [2, INF, INF, 3, INF],
];

$from = 0;

$fordBellman = fordBellman($graph, $from);

foreach ($fordBellman as $to => $distance) {
    echo "Расстояние от $from до $to равно $distance \n";
}