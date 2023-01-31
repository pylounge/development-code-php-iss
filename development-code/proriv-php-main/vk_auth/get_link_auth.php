<?php

/**
 *  Формирует ссылку для авторизации пользователя и получение токена
 * 
 * @param string $client_id Идентификатор приложения (ID приложения).
 * @param string $redirect_uri Адрес, на который будет передан code (Доверенный redirect URI в настройках приложения).
 * @return string Cсылка для авторизации пользователя.
 */
function get_link_vk_auth($client_id, $redirect_uri)
{
    $params = array(
        'client_id' => $client_id,
        'redirect_uri' => $redirect_uri,
        'response_type' => 'code',
        'v' => '5.120', // версия VK API
        // Если указать "offline", полученный access_token будет "вечным" (токен умрёт, если пользователь сменит свой пароль или удалит приложение).
        // Если не указать "offline", то полученный токен будет жить 12 часов.
        'scope' => 'notify,photos'  // Битовая маска настроек доступа приложения (права жоступа)
    );
    return 'http://oauth.vk.com/authorize?' . http_build_query($params);
}

//$client_id = getenv('CLIENT_ID');      // получаем значения и переменных окружения (скрипт vk_env.bat/.sh)
//$redirect_uri = getenv('REDIRECT_URI');

$client_id = '7635404';    
$redirect_uri = 'http://localhost/vk_auth/vk_auth.php';

header("Location: " . get_link_vk_auth($client_id, $redirect_uri));  // перенаправляем пользователя на сформированный адрес