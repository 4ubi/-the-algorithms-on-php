<?php

/**
 * @param array  $graph
 * @param string $from
 * @param string $to
 *
 * @return array
 */
function DikstraShortPath(array $graph, string $from, string $to)
{
    $shortPathToNode     = [];
    $progenitorToAllNode = [];
    $queue               = new SplPriorityQueue();

    foreach ($graph as $vertex => $path) {
        print_r($path);
        exit;
        # устанавливаем изначальные расстояния как бесконечность
        $shortPathToNode[$vertex] = INF;
        # никаких узлов позади нет
        $progenitorToAllNode[$vertex] = null;
        foreach ($path as $w => $cost) {
            # воспользуемся ценой связи как приоритетом
            $queue->insert($w, $cost);
        }
    }

    $shortPathToNode[$from] = 0;

    while (!$queue->isEmpty()) {
        # извлечем минимальную цену
        $minimalCost = $queue->extract();
        if (!empty($graph[$minimalCost])) {
            # пройдемся по всем соседним узлам
            foreach ($graph[$minimalCost] as $vertex => $cost) {
                # установим новую длину пути для соседнего узла
                $newLengthNeighborNode = $shortPathToNode[$minimalCost] + $cost;
                # если он оказался короче
                if ($newLengthNeighborNode < $shortPathToNode[$vertex]) {
                    # update minimum length to vertex установим как минимальное расстояние до этого узла
                    $shortPathToNode[$vertex] = $newLengthNeighborNode;
                    # добавим соседа как предшествующий этому узла
                    $progenitorToAllNode[$vertex] = $minimalCost;
                }
            }
        }
    }

    # обратный проход для поиска  к.пути
    $shortPath   = new SplStack();
    $minimalCost = $to;
    $distance    = 0;

    # проход от целевого узла до стартового
    while (isset($progenitorToAllNode[$minimalCost]) && $progenitorToAllNode[$minimalCost]) {
        $shortPath->push($minimalCost);
        $distance    += $graph[$minimalCost][$progenitorToAllNode[$minimalCost]]; // добавим дистанцию для предшествующих
        $minimalCost = $progenitorToAllNode[$minimalCost];
    }

    if ($shortPath->isEmpty()) {
        print_r(sprintf('Путь из %s в %s отсутствует"\n"', $from, $to));
    } else {
        $shortPath->push($from);
        print_r('Кратчайший маршрут: ');

        foreach ($shortPath as $vertex) {
            print_r($vertex . ' ');
        }

        print_r("\nРасстояние: " . $distance . "\n");
    }

    return $progenitorToAllNode;
}

$graph = [
    'A' => ['B' => 25, 'C' => 15, 'D' => 3, 'E' => 2],
    'B' => ['A' => 25, 'C' => 8],
    'C' => ['A' => 15, 'B' => 8, 'D' => 4],
    'D' => ['A' => 3, 'C' => 4, 'E' => 3],
    'E' => ['A' => 2, 'D' => 3],
];


$graphR = file('graph.txt');

$progenitor = DikstraShortPath($graphR, 'B', 'E');


