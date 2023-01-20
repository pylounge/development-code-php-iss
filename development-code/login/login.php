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
	
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $query = $connection->prepare("SELECT * FROM users WHERE email=:email");
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            echo '<p>Неверные пароль или почта!</p>';
        } else {
            if ($password ==  $result['password']) {
                echo '<p>Привет, '.$result['login'].'!</p>';
            } else {
                echo '<p>Неверные пароль или почта!</p>';
            }
        }
    }
?>