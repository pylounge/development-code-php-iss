<?php

ini_set('max_execution_time', 900); // файл может быть большим и долго грузиться, поэтому увеличиваем время ожидания работы скрипта 

/**
 * Загружает файл на Яндекс.Диск
 * 
 * @param string $token Access-токен приложения для доступа к Яндекс.Диск REST API.
 * @param string $ydisk_path Папка на Яндекс.Диске в которую будет загружаться файл (должна быть создана заранее).
 * @param string $file Путь и имя файла, который мы собираемся заружать на Яндекс.Диск.
 * @return boolean Булево выражение, true - если файл успешно загружен на ЯД, в противном случае false.
 */
function upload_file_on_ydisk($token, $ydisk_path, $file)
{
  if (!file_exists($file)) return false;

  $ydisk_upload_url = get_ydisk_url_upload($token, $ydisk_path, $file);
  if (!is_null($ydisk_upload_url))
  {
      $ydisk_upload_url = $ydisk_upload_url["href"];  // полученный URL для загрузки файла на ЯД
      $file_size = filesize($file);

      $query_options = array(
        'http' => array(
          'method' => "PUT",
          'header' =>
            "Content-Type: application/x-www-form-urlencoded\r\n" .
            "Content-Length: $file_size\r\n",
          'content' => file_get_contents($file)
        )
      );
      $context = stream_context_create($query_options);
      file_get_contents($ydisk_upload_url, false, $context);

      $http_status_code = get_http_response_status_code($http_response_header); 
      return (in_array($http_status_code, array(201, 202)))? true : false; // API-код 201 Created(файл загружен без ошибок), 202 Accepted (файл принят сервером, но еще не перенесен в ЯД).
  } 
  else return false;
}

/**
 * Получаете URL для обращения к загрузчику файлов Яндекс.Диска
 * 
 * @param string $token Access-токен приложения для доступа к Яндекс.Диск REST API.
 * @param string $ydisk_path Папка на Яндекс.Диске в которую будет загружаться файл (должна быть создана заранее).
 * @param string $file Путь и имя файла, который мы собираемся заружать на Яндекс.Диск.
 * @return array Ассоциативный массив, содержащий ссылку (ключ href) для загрузки файла на ЯД.
 */
function get_ydisk_url_upload($token, $ydisk_path, $file)
{
  $base_upload_url = "https://cloud-api.yandex.net/v1/disk/resources/upload"; // https://cloud-api.yandex.net - базовый uri ЯД API, disk/resources/ - метод управления ресурсами
  $query_params = "?path=" . urlencode($ydisk_path . basename($file)) . "&overwrite=true"; // path - путь, по которому следует загрузить файл, overwrite - разрешаем перезапись файлов на диске
  $request_url =  $base_upload_url . $query_params;
  return make_ydisk_request_to_get_link($token, $request_url);
}

/**
 * Формирует и отправляет запрос к API на получение URL для обращения к загрузчику файлов ЯД
 * @param string $token Access-токен приложения для доступа к Яндекс.Диск REST API.
 * @param string $request_url Базовый URL Яндекс.Диск API для управления ресурсами диска (загрузкой и скачиванием) с дополнительными Query-параметрами.
 * @return array Ассоциативный массив, содержащий ссылку (ключ href) для загрузки файла на ЯД.
 */
function make_ydisk_request_to_get_link($token, $request_url)
{
  $query_options = array(
    'http' => array(
      'method' => "GET",
      'header' => "Accept-language: en\r\n" .
        "Content-Type: application/json\r\n" .
        "Content-Length: 0\r\n" .
        "Authorization: OAuth " . $token
    )
  );
  $context = stream_context_create($query_options);
  return json_decode(file_get_contents($request_url, false, $context), $assoc = true);
}


/**
 * Получает HTTP-статус последнего запроса 
 * 
 * @param array $http_response_header Массив, содержащий заголовки ответов HTTP. Создаётся в локальной области видимости, после применения file_get_contents.
 * @return string Часть строки, соответствующая первой подмаске (цифры в статус-коде -> (\d{3})).
 */
function get_http_response_status_code($http_response_header)
{
  $status = $http_response_header[0]; // получаем последний http header
  preg_match('{HTTP\/\S*\s(\d{3})}', $status, $match_status); // ищем значение статус-кода 
  return $match_status[1]; 
}

/**
 * Скачивает файл с Яндекс.Диска
 * 
 * @param string $token Access-токен приложения для доступа к Яндекс.Диск REST API.
 * @param string $ydisk_file Путь и имя файла на Яндекс.Диске, который необходимо скачать.
 * @param string $save_file_path Директория куда будет сохранён скачанный файл.
 * @return boolean Булево выражение, true - если файл успешно скачан с ЯД, в противном случае false.
 */
function download_file_from_ydisk($token, $ydisk_file, $save_file_path)
{
  if (!file_exists($save_file_path)) return false;

  $ydisk_download_url = get_ydisk_url_download($token, $ydisk_file);
  if (!is_null($ydisk_download_url)) 
  {
    $filename_for_download = $save_file_path . "\\" . basename($ydisk_file);
    $ydisk_download_url = $ydisk_download_url["href"];

      $query_options = array(
        'http' => array(
          'method' => "GET",
          'header' => "Accept-language: en\r\n" .
              "Content-Type: application/json\r\n" .
              "Content-Length: ". strlen($ydisk_file) ."\r\n" .      
              "Authorization: OAuth " . $token,
          'content' => $ydisk_file
        )
      );
      $context = stream_context_create($query_options);
      file_put_contents($filename_for_download, file_get_contents($ydisk_download_url, false, $context));
      return true;
  } 
  else return false;
}

/**
 * Получаете URL для скачивания файлов с Яндекс.Диска
 * 
 * @param string $token Access-токен приложения для доступа к Яндекс.Диск REST API.
 * @param string $ydisk_file Путь и имя файла на Яндекс.Диске, который необходимо скачать.
 * @return array Ассоциативный массив, содержащий ссылку (ключ href) для скачки файла с ЯД.
 */
function get_ydisk_url_download($token, $ydisk_file)
{
  $base_download_url = "https://cloud-api.yandex.net/v1/disk/resources/download";
  $query_params = "?path=" . urlencode($ydisk_file); // path - путь к скачиваемому файлу
  $request_url =  $base_download_url . $query_params;
  return make_ydisk_request_to_get_link($token, $request_url);
}


// Токен хранится в переменной окружения TOKEN, устанвоить переменную можно скриптом yd_env.bat (win) или yd_env.sh (linux)
echo (upload_file_on_ydisk(getenv('TOKEN'), "/uploads/", __DIR__ . "\hh_pro.php"))? "Файл успешно загружен на ЯД" : "Ошибка зарузки файла на ЯД";
echo "<br><br>";
echo (download_file_from_ydisk(getenv('TOKEN'), "/uploads/header.jpg", __DIR__))? "Файл успешно скачан с ЯД" : "Ошибка скачивания файла с ЯД";
