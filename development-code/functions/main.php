<?php
// подключает файл в программу 
include 'db_helpers.php';

$conn_mysql = get_connection_db("root", 
                                "",
                                "localhost",
                                "code-development");

$query = $conn_mysql->query("SELECT * FROM products");
$result = $query->fetchAll();
var_dump($result);









