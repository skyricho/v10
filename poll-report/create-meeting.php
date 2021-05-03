<?php
require_once '../vendor/autoload.php';
ini_set('display_errors', 1);
date_default_timezone_set("Australia/Sydney");
echo date_default_timezone_get();



use \Firebase\JWT\JWT;
use GuzzleHttp\Client;
 
define('ZOOM_API_KEY', 'h-dT3f6ASLehEW_GA6NUhQ');
define('ZOOM_SECRET_KEY', 'HWsJZ75SPACsect0kkGf19hY51adhheF21kW');

function getZoomAccessToken() {
    $key = ZOOM_SECRET_KEY;
    $payload = array(
        "iss" => ZOOM_API_KEY,
        'exp' => time() + 3600,
    );
    return JWT::encode($payload, $key);    
}

function createZoomMeeting() {
    $client = new Client([
        // Base URI is used with relative requests
        'base_uri' => 'https://api.zoom.us', 'verify' => false 
    ]);
 
    $response = $client->request('POST', '/v2/users/me/meetings', [
        "headers" => [
            "Authorization" => "Bearer " . getZoomAccessToken()
        ],
        'json' => [
            "topic" => "Let's Learn WordPress",
            "type" => 2,
            "start_time" => "2021-01-30T20:30:00",
            "duration" => "30", // 30 mins
            "password" => "123456"
        ],
    ]);
 
    $data = json_decode($response->getBody());
    echo "Join URL: ". $data->join_url;
    echo "<br>";
    echo "Meeting Password: ". $data->password;
}
 
createZoomMeeting();

?>