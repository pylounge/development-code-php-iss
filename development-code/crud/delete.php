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
	
    if (isset($_POST['id'])) {
		$id = $_POST['id'];
		
            $query = $connection->prepare("DELETE FROM users WHERE id=:id");
            $query->bindParam("id", $id, PDO::PARAM_STR);
            $result = $query->execute();
			echo json_encode($result);
    }
?>