<?php

/**
 * Определяет координаты (широту и долготу) по строке, содержащей адрес места
 * 
 * @param string $api_key API-ключ Яндекс.Карты.
 * @param string $address Строка, содержащая адрес места.
 * @return array|null Массив, содержащий широту и долготу места, расположенного по адресу $address. Если адрес не корректный, то возвращает null.
 */
function get_cords_by_address($api_key, $address)
{
    $base_url = "https://geocode-maps.yandex.ru/1.x/?";
    $parameters = array(
        'apikey' => $api_key,
        'geocode' => urldecode($address),
        'format' => 'json'
    );
    $query = http_build_query($parameters); 
    $response = json_decode(file_get_contents($base_url . $query), true)["response"]["GeoObjectCollection"]["featureMember"];

    if (empty($response)) return null;

    $pos = explode(' ', $response[0]["GeoObject"]["Point"]["pos"]);
    return array(
        'lat' => $pos[1],
        'lng' => $pos[0]
    );
}

// Example 
var_dump(get_cords_by_address(getenv('APIKEY'),'Елец, Клубная 1г'));
