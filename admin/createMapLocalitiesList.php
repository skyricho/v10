<?php
include ("../dbaccess.php"); 
require '../vendor/autoload.php';
ini_set('display_errors', 1);



$request = $fm->newFindAllCommand('Map Lite');
$result = $request->execute();

$records = $result->getRecords();
$Maps = array();
foreach($records as $record) {
	// Add item to array $arr[$key] = $value
	$Maps[$record->getField('Map')] = $record->getField('MapSuburb::suburb');
}


//var_dump($Maps);
// encode array to json
$json = json_encode($Maps);
//echo $json;


//write json to file
if (file_put_contents("../map-localities.json", $json))
    echo "JSON file created successfully...";
else 
    echo "Oops! Error creating json file...";

// map-localities.json


//$json1 = file_get_contents('../map-localities.json',0,null,null);
//echo $json1;

?>
