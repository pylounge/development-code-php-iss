<?php
function calc_flower($count, $price){
    return $count * $price;
}

function get_total_price($array){
    $total_price = 0;
    foreach($array as $item){
        $total_price += calc_flower($item[1], $item[2]);
    }
    return $total_price;
}

$flowers = [
    ["rose", 100, 100],
    ["sunflower", 10, 1000],
    ["iris", 1, 50],
];

$money = get_total_price($flowers);
print("Всего денях {$money}");