<?php
ini_set('display_errors', 1);
include ("../dbaccess.php");


$request = $fm->newFindCommand('Map');
$request->addFindCriterion('mapAssignmentId', '*');
$request->addFindCriterion('isPhoneMap', 0);
$result = $request->execute();


$availableMaps = array();
$records = $result->getRecords();
foreach($records as $record) {
    $availableMaps [] = array(
        "map" => $record->getField('Map'),
        "suburb" => $record->getField('MapSuburb::suburb'),
        "colour" => $record->getField('Suburb::badgeColour'),
        "firstName" => $record->getField('MapAssignment::cFirstName')
    );
}

//echo print_r($availableMaps);
//header("Content-Type: application/json; charset=UTF-8");
//echo json_encode($availableMaps, JSON_NUMERIC_CHECK); // JSON_NUMERIC_CHECK to prevent integers 

$fp = fopen('map-list.json', 'w');
fwrite($fp, json_encode($availableMaps, JSON_NUMERIC_CHECK));
fclose($fp);
echo 'Map list saved.';

?>

