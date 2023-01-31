<?php

/**
 * Возвращает строки из БД, соответвующие шаблону из POST-запроса.
 * 
 * @param $host Хост-сервера с БД.
 * @param $db Название базы данных.
 * @param $user Имя пользователя базы.
 * @param $pass Пароль пользователя базы.
 * @param $charset Кодировка БД.
 * @param $table Название таблицы таблицы БД, к которой идёт запрос.
 * @param $search_field Название поля таблицы, значение которого сравнивается с шаблоном.
 * @return array|null Массив строк из БД в формате json. Null если ни одна строка не удоволетворяет шаблону.
 */
function get_db_data($host, $db, $user, $pass, $charset, $table, $search_field)
{
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $opt = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $pdo = new PDO($dsn, $user, $pass, $opt);

    if(!empty($_POST["referal"]))
    { 
        $referal = trim(strip_tags(stripcslashes(htmlspecialchars($_POST["referal"]))));
 
        $stmt = $pdo->query("SELECT $search_field FROM $table WHERE $search_field LIKE '$referal%'");
        $rows = $stmt->fetchAll();

        if (!empty($rows))
        {
            return json_encode($rows);
        } 
        else  return json_encode(null);
    }
}


// Example
$host = 'localhost';
$db = 'chto_smotrish';
$user = 'root';
$pass = 'root';
$charset = 'utf8';
$table = 'ne_smotri';
$search_field = 'name';

echo get_db_data($host, $db, $user, $pass, $charset, $table, $search_field);