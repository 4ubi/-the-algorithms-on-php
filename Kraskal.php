<?php

function showNode(array $md)
{
    $count = 0;
    $minimal = $md[0]['to'];
    $sort = [];


    foreach ($md as $item) {

        if ($item['to'] <= $minimal) {
            $minimal = $item['to'];
            $sort [] = $item;
        }else {
            $sort [] = $item;
        }
    }





    foreach ($md as $item) {

        if ($item['result'] === 'Не берем') {
            $count++;

            if ($count > 2) {
                continue;
            }
        }

        echo $item['result'] . "(". $item['to'].",".$item['from'].")\n";
    }
}

/**
 * @param array $graph
 *
 * @return array
 */
function kraskal(array $graph): array
{
    $lenght = count($graph);
    $tree   = [];

    $count = 7;

    $set = [];

    foreach ($graph as $key => $value) {
        $set[$key] = [$key];
    }

    $edges = [];

    $mda = [];

    for ($i = 0; $i < $lenght; $i++) {
        for ($j = 0; $j < $i; $j++) {

            if ($graph[$i][$j]) {
                $edges[$i . ',' . $j] = $graph[$i][$j];

                //     echo "($i,$j) + \n";
                continue;
            }
            //  echo "($i,$j) - \n";
        }
    }

    asort($edges);

    foreach ($edges as $key => $w) {

        list($i, $j) = explode(',', $key);

        $iSet = findSetKey($set, $i);
        $jSet = findSetKey($set, $j);

        $flag = 0;

        if ($iSet != $jSet) {
            $flag   = 1;
            $tree[] = ["from" => $i, "to" => $j, "cost" => $graph[$i][$j]];
            unionSet($set, $iSet, $jSet);
        }

        if ($flag == 1) {
            $flag   = 0;
            $mda [] = [
                'from'   => $i,
                'to'     => $j,
                'result' => 'Берем',
            ];
        } else {
            if ($flag === 0) {

                $mda [] = [
                    'from'   => $i,
                    'to'     => $j,
                    'result' => 'Не берем',
                ];
            }
        }
    }

    showNode($mda);

    return $tree;
}

/**
 * @param array $set
 * @param int   $index
 *
 * @return bool|int|string
 */
function findSetKey(array &$set, int $index)
{
    foreach ($set as $key => $value) {

        if (in_array($index, $value)) {
            return $key;
        }
    }

    return false;
}

/**
 * @param array $set
 * @param int   $i
 * @param int   $j
 */
function unionSet(array &$set, int $i, int $j)
{
    $a = $set[$i];
    $b = $set[$j];

    unset($set[$i], $set[$j]);
    $set[] = array_merge($a, $b);
}

$graph = [
    [0, 2, 0, 0, 0, 2, 1],
    [2, 0, 5, 0, 0, 0, 4],
    [0, 5, 0, 3, 0, 0, 9],
    [0, 0, 3, 0, 1, 0, 1],
    [0, 0, 0, 1, 0, 2, 2],
    [2, 0, 0, 0, 2, 0, 3],
    [1, 4, 9, 1, 2, 3, 0],
];

$kraskal = kraskal($graph);

$minimumCost = 0;

echo "\n";

foreach ($kraskal as $v) {
    echo "Из {$v['from']} в {$v['to']} стоимость {$v['cost']} \n";
    $minimumCost += $v['cost'];
}

echo "Минимальная стоимость: $minimumCost \n";
