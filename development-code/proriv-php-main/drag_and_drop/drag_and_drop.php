<?php

/**
 * Загружает полученный файл на сервер
 * 
 * @param array $file Ассоциативный массив элементов, загруженных в текущий скрипт через метод HTTP POST.
 * @param string $upload_dir Директория в которую будет загружен файл.
 * @return boolean Возвращает true - когда файл успешно сохранён на сервере, в противном случае false
 */
function upload_file($file, $upload_dir)
{
    if (!empty($file))
    {
        $upload_file = $upload_dir . basename($file['name']);
        return move_uploaded_file($file['tmp_name'], $upload_file);
    }
    return false;
}

upload_file($_FILES['file'], __DIR__ . '\\upload\\');



