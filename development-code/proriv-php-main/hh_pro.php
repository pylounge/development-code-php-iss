<?php

/**
 * Отправляет HTTP-запрос методом GET к HeadHunter API
 * 
 * @param array $parameters Набор GET-параметров запроса (?key1=value1&key2=value2).
 * @param string $api_method API-методы, доступные без авторизации и регистрации приложения (/vacancies, /vacancies/favorited/, /employers и т.д.).
 * @return array Ассоциативный массив, полученных от API записей вида: {["field1"]=>"value1" ["field2"]=> value2 ["field3"]=> value3}.
 */
function get_hh_query($parameters,  $api_method="vacancies")
{
  $base_url = "https://api.hh.ru/";
  $request_uri = $base_url . $api_method;

  $query = http_build_query($parameters); // Генерирует URL-кодированную строку запроса из ассоциативного массива ([key]=>value певращает в key=value)
  $query_options = array(                 // Заполняем поля заголовка запроса
    'http'=>array(
      'method'=>"GET",
      'header'=>"Accept-language: en\r\n" .
                "User-agent: HH-User-Agent \r\n".                         // Обязательное требование запроса передавать заголовк User-Agent или HH-User-Agent, иначе 400 Bad Request
                "Content-Type: application/x-www-form-urlencoded\r\n".    // Т.к. будем передавать строку парметров 
                "Content-Length: ".strlen($query)."\r\n",
      'content' => $query
    )
  );
  $context = stream_context_create($query_options);
  $response =  json_decode(file_get_contents($request_uri, false, $context), $assoc=true); // true - объекты JSON будут возвращены как ассоциативные массивы (array)
  return $response["items"];
}


// 2 первых вакансии по Москве, с 1 страницы, в которых в заголовке содердится "php"
$data = array(
  'text' => 'php',
  'area' => '1',
  'page' => '0',
  'per_page' => '2'
);


$vacancies = [];
$i=0;
foreach(get_hh_query($data) as $vac)
{
  $vacancies[]=[
    "name" => $vac["name"]?? "",
    "area" => $vac["area"]["name"]?? "",
    "salary_from" => $vac["salary"]["from"]?? "",
    "salary_to" => $vac["salary"]["to"]?? "",
    "currency" => $vac["salary"]["currency"]?? "",
    "address" =>  $vac["address"]["city"]?? "",
    "address_lat" => $vac["address"]["lat"]?? "",
    "address_lng" => $vac["address"]["lng"]?? "",
    "employer" => $vac["employer"]["name"]?? "",
    "published_At" => $vac["published_at"]?? "",
    "url" => $vac["alternate_url"]?? "",
    "requirement" => $vac["snippet"]["requirement"]?? "",
    "responsibility" => $vac["snippet"]["responsibility"]?? "",
    "employer_logo" => $vac["employer"]["logo_urls"][90]?? "",
    "type" => "hh"
  ];
  var_dump($vacancies[$i++]);
  echo "<br><br>";
}



/*
name 
area name
salary from to currency
address city lat lng
employer name logo_urls
published_at
alternate_url
snippet requirement responsibility
type
*/
//var_dump(get_hh_query($data)[0]);

