<?php
$state = $_POST["state"];
$proc = $_POST["proc"];
$type = $_POST["type"];

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
		
		for($i = 0; $i < count($products); $i++){
		    if ($type != "Все"){
				$pos_type_product = strpos($products[$i]["title"], $type);
				if ($pos_type_product === false){
					continue;
				}
			}
		
			$pos_company = strpos($products[$i]["title"], $proc);
			if ($pos_company !== false){
				continue;
			}
			
			if ($state == "rich"){
				if($products[$i]["price"] >= 30000){
					print($products[$i]["title"]);
				}
			}
			else {
				print($products[$i]["title"]);
			}
			print("<br>");
		}
		
?>