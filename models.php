<?php
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/vendor/autoload.php';
use Dotenv\Dotenv;
use GuzzleHttp\Client;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$apiKey = $_ENV['OPENAI_API_KEY'];

$client = new Client();

$response = $client->get('https://api.openai.com/v1/models',['headers' => [
    'Content-Type' => 'application/json',
    'Authorization' => 'Bearer ' . $apiKey,
]]);
$models =json_decode($response->getBody(), true);
echo json_encode($models);
