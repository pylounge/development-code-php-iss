<?php
$max_price = $_POST["max_price"] ?? 0;
$min_price = $_POST["min_price"] ?? 0;
$type = $_POST["type"] ?? "Все";

$DB_USER = 'root';
$DB_PASSWORD = '';
$DB_HOST = 'localhost';
$DB_DATABASE = 'code-development';
try {
    $connection = new PDO("mysql:host=".$DB_HOST.";dbname=".$DB_DATABASE, $DB_USER, $DB_PASSWORD);
	} catch (PDOException $e) {
			exit("Error: " . $e->getMessage());
	}
$query = $connection->query("SELECT * FROM products");
$products = $query->fetchAll();

$cost_products = 0;
for($i = 0; $i < count($products); $i++){
    $cost_products += $products[$i]["price"];

    if ($type != "Все"){
        $pos = strpos($products[$i]["title"], $type);
        if ($pos === false){
            continue;
        }
    }

    if ($products[$i]["price"] >= $min_price &&
    $products[$i]["price"] <= $max_price){
        print($products[$i]["title"] . " ");
        print($products[$i]["price"]);
        print('<img src="' . $products[$i]["img"] .' "/>');
        print("<br>");
    }
}
print("Всего денях: {$cost_products}");