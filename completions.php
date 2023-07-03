<?php
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/vendor/autoload.php';
use Dotenv\Dotenv;
use GuzzleHttp\Client;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$apiKey = $_ENV['OPENAI_API_KEY'];
$request = json_decode(file_get_contents('php://input'));

if (empty($request->prompt) && !empty($request->messages[0]["content"])){
    $request->prompt = $request->messages[0]["content"];
    unset($request->messages);
}

if(empty( $request->prompt)){
    echo '{"error":"input error!"}';
    exit;
}
if (empty($request->model)){$request->model = "text-davinci-003";}

if (empty($request->temperature)){$request->temperature = 0.7;}
if (empty($request->max_tokens)){$request->max_tokens =1000;}
    
$request = (array)$request;
$client = new Client();
try{
    $response = $client->post('https://api.openai.com/v1/completions', [
        'headers' => [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $apiKey,
        ],
        'json' =>(array)$request,
    ]);
} catch(Exception $ex){
    print_r($request);
    print_r($ex);
}
echo $response->getBody() ;
