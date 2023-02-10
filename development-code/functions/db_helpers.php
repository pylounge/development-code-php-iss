<?php
/*Возвращает подключение к базе данных
$user (string) - логин пользователя БД
$user_password (string) - пароль пользователя БД
...
return - (PDO) объект соединения с БД*/
function get_connection_db($user, $user_password,
                            $host, $database)
{
    $connection = new PDO(
        "mysql:host=".$host."
        ;dbname=".$database, $user, $user_password
    );
  return $connection;
}