<?php
	function getAllProducts(){
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
        $data = $query->fetchAll();
		return $data;
	}
?>