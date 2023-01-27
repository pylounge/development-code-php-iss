<?php

 $DB_USER = 'root';
		$DB_PASSWORD = '';
		$DB_HOST = 'localhost';
		$DB_DATABASE = 'code-development';
		try {
			$connection = new PDO("mysql:host=".$DB_HOST.";dbname=".$DB_DATABASE, $DB_USER, $DB_PASSWORD);
			} catch (PDOException $e) {
				exit("Error: " . $e->getMessage());
			}
		$query = $connection->query("SELECT * FROM users");
        $data = $query->fetchAll();
		echo json_encode($data);