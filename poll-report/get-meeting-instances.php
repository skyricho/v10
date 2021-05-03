<?php
require_once '../vendor/autoload.php';
ini_set('display_errors', '1');
date_default_timezone_set("Australia/Sydney");
//echo date_default_timezone_get();
 
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

$filterStr = "";
if (isset($_GET['d'])) {
    $filterStr = $_GET['d'];
    echo "<h3>Meeting date: " . $filterStr . "</h3>";
} else {
    if (date('w') == 6 or date('w') == 2) {
        $filterStr = date('Y-m-d');
        echo "<h4>Today's Zoom Meeting</h4>";
    } else {
        $filterStr = "%";
        echo "<h3>Meeting date not set</h3>";
        echo "Try ...?d=YYYY-MM-DD<br><br>";
    }
}

//$weekday = date('w'); //gets day of week as number(0=sunday,1=monday...,6=sat)




function getZoomMeetingInstances($meeting_id,$filterStr) {
    $client = new Client([
        // Base URI is used with relative requests
        'base_uri' => 'https://api.zoom.us',
        'verify' => 'cacert.pem',
    ]);
 
    $response = $client->request("GET", "/v2/past_meetings/$meeting_id/instances", [
        "headers" => [
            "Authorization" => "Bearer " . getZoomAccessToken()
        ]
    ]);
 
    if (200 == $response->getStatusCode()) {
        //echo "Success.<br>";
        

        //$response = GuzzleHttp\get('http://httpbin.org/get');
        if ($response->getBody()) {
            //echo $response->getBody();
            // JSON string: { ... }
            $participants = array(json_decode($response->getBody()));
            //var_dump($participants[0]->meetings[90]);
            foreach ($participants[0]->meetings as $value) {
                if (strpos($value->start_time, $filterStr) !== false) {
                    echo $value->start_time . " <a href=\"participants-list.php?uuid=" . urlencode($value->uuid) . "&d=" . $filterStr . "\">" . $value->uuid . "</a><br>";
                }     
            }
            echo "<br><br><br><br>";
            echo "<h4>Previous Zoom Meetings</h4>";
            //$instances = $participants[0]->meetings;


            //echo "Date: " . $participants[0]->meetings[0]->start_time . " uuid: " . $participants[0]->meetings[0]->uuid . "<br><hr>";


            foreach ($participants[0]->meetings as $value) {
              echo date('D m M Y-m-d', strtotime($value->start_time)) . ": " . $value->uuid . "<br>";
            }
            echo "<hr>";
            print_r($participants.[0].[0].[0].[0].[0].[0]);
            echo "<hr>";
            var_dump($participants);


            echo "<hr>";
            print_r($participants);

            
        }
    }
}
 
getZoomMeetingInstances('86823378010',$filterStr); // MEETING_ID_HERE was 82506263260

?>
