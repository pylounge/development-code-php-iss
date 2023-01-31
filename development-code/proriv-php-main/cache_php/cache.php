<?php

define('CACHE_PATH_FILE', 'tmp_cache/'); // директория где хранятся файлы кэширования
define ('CACHE_EXPIRE', 3600); // время актуальности кэша в секундах

/**
 * Генерирует название файла для кэширования.
 * 
 * @param string $key Название ключа по которому объект будет сохранён в кэш-файл.
 * @return string Строка с названием файла для записи в негог кэша объекта
 */
function get_cache_file_tmp($key)
{
   return CACHE_PATH_FILE . $key . '.tmp';
}

/**
 * Сохраняет данные в файл для кэширования.
 * @param mixed $data Данные, которые необходимо кэшировать.
 * @param string $key Название ключа по которому объект будет сохранён в кэш-файл.
 */
function save_cache_in_tmp_file($data, $key)
{
    file_put_contents(get_cache_file_tmp($key), serialize($data));
}

/**
 * Получает данные из кэш-файла
 * 
 * @param $key Название ключа по которому происходит поиск нужного объекта в кэше (выбирается соответствующий ключу файл).
 * @return mixed|null|boolean Возвращается преобразованное значение из кэша, null - если кэш-файла с таким ключом ($key) не найден, false - если содердимое кэш-файла не поддается десериализации.
 */
function load_cache_from_tmp_file($key)
{
    $cache_filename = get_cache_file_tmp($key);
    if ((!file_exists($cache_filename)) || (filemtime($cache_filename) + CACHE_EXPIRE < time()))
    {
        return null;
    }
    return unserialize(file_get_contents($cache_filename));
}

// Example 
// require_once 'cach.php';
/*$host = '127.0.0.1';
$db   = 'рестораны';
$user = 'root';
$pass = 'root';
$charset = 'utf8';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);

$client_tip = true;
// если нет кэша с ключом 'client_$client_id', то делаем запрос к бд и сохраняем в кэш
if (!($client = load_cache_from_tmp_file("client_tip_$client_tip")))
{
    $res = $pdo->query("select * from `клиенты` where `Чаевые` = '$client_tip'");
    $client = $res->fetchAll();
    save_cache_in_tmp_file($client, "client_tip_$client_tip");
    echo 'Saved in cache: ';
    var_dump($client);
} else 
{
    echo "Msg from cache: ";
    var_dump($client);
}
*/