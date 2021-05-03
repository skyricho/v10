<?php
ini_set('display_errors', '1');
//$foo["a"] = "bar";
//var_dump($foo);


$regularCallers = [
    'Call-In User_1' => '1',
    '61284112945' => '1',  
    '61477002316' => '1',
    '61299491191' => '2', // Moore sisters
    'Call-In User_2' => '1', 
    '61452398893' => '1', // Samthana
];

//echo $regularCallers['61284112945'] . "<br>"; 

require_once '../vendor/autoload.php';
 
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

//$uuid = 'SyO65327TyqMjWa7AL6vVw==';
$$uuid - ''
//echo "<button onclick=\"history.go(-1);\">Back </button><br>";
echo "<a href=\"get-meeting-instances.php?d=" . $_GET["d"] . "\">Back</a>";
if(isset($_GET['uuid'])) {
    $uuid = $_GET['uuid'];
    echo "<h3>Meeting Attendance Worksheet for " . $_GET["d"] . "</h3>";
    echo "(Zoom Meeting Instance " . urldecode($uuid) . ")";
}

$body = "";
function getParticipantsList($uuid) {
    $client = new Client([
        // Base URI is used with relative requests
        'base_uri' => 'https://api.zoom.us',
        'verify' => 'cacert.pem', // or false
    ]);
 
    $response = $client->request("GET", "/v2/report/meetings/" . $uuid . "/participants?page_size=300&next_page_token=&include_fields=", [
        "headers" => [
            "Authorization" => "Bearer " . getZoomAccessToken(), 
        ]
    ]);
 
    if (200 == $response->getStatusCode()) {
        //echo "Success.<br>";
        
        if ($response->getBody()) {
            global $body;
            $body = array(json_decode($response->getBody()));
            
        }


    }
}
 
getParticipantsList($uuid); // uuid
//print_r($body);


$body1 = "";

//{{baseUrl}}/report/meetings/hmphZpuYRoi3l1pVyOFohg==/polls
function getPollReport($uuid) {
    $client = new Client([
        // Base URI is used with relative requests
        'base_uri' => 'https://api.zoom.us',
        'verify' => 'cacert.pem', // or false
    ]);
 
    $response = $client->request("GET", "/v2/report/meetings/" . $uuid . "/polls", [
        "headers" => [
            "Authorization" => "Bearer " . getZoomAccessToken()
        ]
    ]);
 
    if (200 == $response->getStatusCode()) {
        //echo "Success.<br>";
        
        if ($response->getBody()) {
            global $body1;
            $body1 = array(json_decode($response->getBody()));
            
        }


    }
    //var_dump($body1[0]->questions);
    if (empty($body1[0]->questions)) {
    	echo "No poll report for this meeting";
    }
}
 
getPollReport($uuid); // uuid





// Find Delta
echo "<h5>Poll Non Respondants</h5>";
echo "<table>";
//echo "<tr><th>Name</th><th>Attendance</th></tr>";
//version 2
// create array of poll report names
$pollRespondants = array();
$callers = array();
$pollNonRespondants = array();
foreach ($body1[0]->questions as $value) {
	$pollRespondants [] = $value->name;
}
//var_dump($pollRespondants);

foreach ($body[0]->participants as $value) {
	if (in_array($value->name, $pollRespondants)) {
		echo "";
	} else {
        if (array_key_exists($value->name, $regularCallers)) {
        	$callers[$value->name] = $regularCallers[$value->name];
        } else {
            $pollNonRespondants[] =  $value->name;
        }
	}
}
$uniquePollNonRespondants = array_unique($pollNonRespondants);
$xx = 1;
foreach ($uniquePollNonRespondants as $value) {
	//echo $x++ . ". " . $value . "<br>"; 
    //echo $value . "<input onblur=/"findTotal()/" type=/"text/" name=/"Attendance/" id=/"qty" . $x++ . "/"/><br>"; 
    echo "<tr><td>" . $value . "</td><td><input input onblur=\"findTotal()\" type=\"text\"  size=\"4\" name=\"qty\" id=\"qty" . $xx++ . "\"/></td><tr>"; 
}
//echo "Total: <p id=\"total\"></p>";
echo "</table>";
echo "Total: <input type=\"text\" size=\"4\" name=\"total\" id=\"total\"/>";

echo "<h5>Callers</h5>";
$xxx = 1;
$tally = 0;
foreach ($callers as $key => $value) {
	echo $xxx++ . " " . $key . ": " . $value . "<br>";
	$tally = $tally + intval($value);
}
echo "Total: " . $tally;
//var_dump($callers);



//version 1 (failure)
/*foreach ($body[0]->participants as $value) {
	$x = $value->name;
	foreach ($body1[0]->questions as $value) {
		if ($value->name == $x) {
			echo $x . "<br>";
		}
	}
}*/


echo "<h5>Poll Respondants</h5>";
//var_dump($body1[0]->questions[0]->question_details[0]->answer);
//echo intval($body1[0]->questions[0]->question_details[0]->answer);
$tally = 0;
$x = 1;
foreach ($body1[0]->questions as $value) {
    echo $x++ . ". " .    $value->name . ': ' . $value->question_details[0]->answer . "<br>";
    $tally = $tally + intval($value->question_details[0]->answer);

}
//var_dump($body[0]->questions[1]);
//echo $body[0]->questions[2]->name . ': ' . $body[0]->questions[2]->question_details[0]->answer;

echo  "Total= " . $tally;


echo "<h5>Participants</h5>";

            $x = 1;
            foreach ($body[0]->participants as $value) {
                echo $x++ . ". " . $value->id . ": " . $value->name . "<br>";
            }

?>
<script type="text/javascript">
function findTotal(){
    var arr = document.getElementsByName('qty');
    var tot=0;
    for(var i=0;i<arr.length;i++){
        if(parseInt(arr[i].value))
            tot += parseInt(arr[i].value);
    }
    document.getElementById('total').value = tot;
}

</script>
