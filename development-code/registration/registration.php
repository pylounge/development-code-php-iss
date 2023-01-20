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
	
    if (isset($_POST['email']) && isset($_POST['password']) && $_POST['login']) {
		$login = $_POST['login'];
        $email = $_POST['email'];
        $password = $_POST['password'];
		
            $query = $connection->prepare("INSERT INTO users(login,email,password) VALUES (:login,:email,:password)");
            $query->bindParam("login", $login, PDO::PARAM_STR);
			$query->bindParam("email", $email, PDO::PARAM_STR);
            $query->bindParam("password", $password, PDO::PARAM_STR);
            $result = $query->execute();
            if ($result) {
                echo '<p>Регистрация прошла успешно!</p>';
            } else {
                echo '<p>Неверные данные!</p>';
            }
        
		
    }
?>

<!-- http://localhost/development-code/registration/registration.html -->