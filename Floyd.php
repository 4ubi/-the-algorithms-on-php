<?php
$graph = [];

for ($vertex = 0; $vertex < 10; ++$vertex) {
    $graph[] = [];
    for ($edge = 0; $edge < 10; ++$edge) {
        $graph[$vertex][] = $vertex == $edge ? 0 : INF;
    }
}

for ($vertex = 1; $vertex < 10; ++$vertex) {
    $graph[0][$vertex] = $graph[$vertex][0] = rand(1, 9);
}


for ($k = 0; $k < 10; ++$k) {
    for ($vertex = 0; $vertex < 10; ++$vertex) {
        for ($edge = 0; $edge < 10; ++$edge) {
            if ($graph[$vertex][$edge] > $graph[$vertex][$k] + $graph[$k][$edge]) {
                $graph[$vertex][$edge] = $graph[$vertex][$k] + $graph[$k][$edge];
            }
        }
    }
}

print_r($graph);

