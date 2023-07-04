<?php
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/vendor/autoload.php';
use GuzzleHttp\Client;
$apiKey = "";
if(!empty($_SERVER['HTTP_AUTHORIZATION'])){
    $apiKey = $_SERVER['HTTP_AUTHORIZATION'];
}
$client = new Client();
$uri = $_SERVER['REQUEST_URI'];

// Remove the script filename and everything before it
$uri = preg_replace('/^.+?index\.php/', '', $uri);

// Remove any leading slashes
$uri = ltrim($uri, '/');
$url = 'https://api.openai.com/'.$uri;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try{
        $response = $client->get($url ,['headers' => [
        'Content-Type' => 'application/json',
        'Authorization' =>  $apiKey,
        ]   ]);
        echo $response->getBody()->getContents();
    }catch(GuzzleHttp\Exception\ClientException $ex){
        echo $ex->getResponse()->getBody()->getContents();
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {

    try{
        $requestBody = json_decode(file_get_contents('php://input'));

        $response = $client->post($url ,['headers' => [
        'Content-Type' => 'application/json',
        'Authorization' =>  $apiKey,
        ],
        "json"=>$requestBody
         ]);
        echo $response->getBody()->getContents();
    }catch(GuzzleHttp\Exception\ClientException $ex){
        echo $ex->getResponse()->getBody()->getContents();
    }
} else {
    echo "{}";
}


