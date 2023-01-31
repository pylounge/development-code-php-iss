<?php

/**
 * Получает access_token 
 *
 * @param string $client_id Идентификатор приложения (ID приложения).
 * @param string $client_secret Защищенный ключ Вашего приложения (указан в настройках приложения).
 * @param string $redirect_ur URL, который использовался при получении code на первом этапе авторизации. Должен быть аналогичен переданному при авторизации.
 * @return array Cозданный access_token. Вместе с access_token серверу возвращается время жизни ключа expires_in в секундах. expires_in содержит 0, если токен бессрочный (при использовании scope = offline). Процедуру авторизации приложения необходимо повторять в случае истечения срока действия access_token, смены пользователем своего логина или пароля или удаления приложения из настроек.
 */
function get_vk_token($client_id, $client_secret, $redirect_uri)
{
    if (isset($_GET['code']))
    {
        $params = array(
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'code' => $_GET['code'],
            'redirect_uri' =>  $redirect_uri
        );

        if (!$content = file_get_contents('https://oauth.vk.com/access_token?' . http_build_query($params))) 
        {
            $error = error_get_last();
            throw new Exception('HTTP request failed. Error: ' . $error['message']);
        }

        $response = json_decode($content);

        if(isset($response->erro))
        {
            throw new Exception('При получении токена произошла ошибка. Error: ' . $response->error . '. Error description: ' . $response->error_description);
        }

        return $response;
    } 
    elseif (isset($_GET['error']))
    {
            throw new Exception( 'При авторизации произошла ошибка. Error: ' . $_GET['error'] . '. Error reason: ' . $_GET['error_reason'] . '. Error description: ' . $_GET['error_description'] );
    }
}

/**
 * Получает информацию о пользователе из его профиля VK по access_token
 * 
 * @param array $token Cозданный VK API access_token.
 * @param string $fields Список опциональных полей из профиля пользователя https://vk.com/dev/objects/user.
 * @return array Массив, содержащий информацию о пользователи из полей $fields и базовых (id, first_name, last_name и т.д).
 */
function get_vk_user_info($token, $fields)
{
    $params = array(
        'v' => '5.120', 
        'access_token' => $token->access_token, 
        'user_ids' => $token->user_id, 
        'fields' => $fields // Список опциональных полей https://vk.com/dev/objects/user
    );
     
    if (!$content = file_get_contents('https://api.vk.com/method/users.get?' . http_build_query($params))) 
    {
        $error = error_get_last();
        throw new Exception('HTTP request failed. Error: ' . $error['message']);
    }
     
    $response = json_decode($content);
     
    if (isset($response->error)) 
    {
        var_dump('При отправке запроса к API VK возникла ошибка. Error: ' . $response->error . '. Error description: ' . $response->error_description);
    }
     
    $response = $response->response;
     
    $user_info = array(
        'id' => $response[0]->id,
        'first_name' => $response[0]->first_name,
        'last_name' => $response[0]->last_name,
        'photo' => $response[0]->photo_100,
        'sex' => $response[0]->sex,
        'bdate' => $response[0]->bdate,
        'city' => $response[0]->city,
        'about' =>$response[0]->about
    );

    return $user_info;
}
// Example 

//$client_id = getenv('CLIENT_ID');    
//$client_secret = getenv('CLIENT_SECRET');
//$redirect_uri = getenv('REDIRECT_URI');


$client_id = '7635404';    
$client_secret = 'JYbr3yJtH425L9iV366g';
$redirect_uri = 'http://localhost/vk_auth/vk_auth.php';

$token = get_vk_token($client_id, $client_secret, $redirect_uri);

//echo $token->access_token;
var_dump(get_vk_user_info($token, 'sex,bdate,city,photo_100,about'));
