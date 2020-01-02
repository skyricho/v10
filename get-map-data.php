<?php
ini_set('display_errors', 1);
include ("dbaccess.php");

$mapData = array();
for ($x = 1; $x <= 50; $x+=1) {
	# Query available blocks
	$request = $fm->newFindCommand('MapBlock');
	$request->addFindCriterion('Map', $x); 
	$result = $request->execute();
	$records = $result->getRecords();

	$var = array();
	

	foreach($records as $record) {
	    $var[] = $record->getField('Block');
	}

    $blockStreets = array();
	$yy = count($var);
	for ($y = 1; $y <= $yy; $y+=1) {
		# Query available streets
	    $request = $fm->newFindCommand('BlockStreet');
	    $request->addFindCriterion('MapBlock::Map', $x);
	    $request->addFindCriterion('MapBlock::Block', $y); 
	    $result = $request->execute();
	    $records = $result->getRecords();

	    $streets = array();
	    foreach($records as $record) {
	        $streets[] = $record->getfield('Street');
	    }

	    //echo json_encode($streets) . "<br>";	    
	    $blockStreets[] = $streets;

	}

	$mapArray = array();
	$mapArray[] = $x;
	$mapArray[] = $var;
	$mapArray[] = $blockStreets;

	//echo $var;
	//echo json_encode($var);
	$mapData[] = $mapArray;


}

//echo json_encode($mapData);


# Save as json file
$fp = fopen('map-data.json', 'w');
fwrite($fp, json_encode($mapData, JSON_NUMERIC_CHECK));
fclose($fp);
echo '<p>Map data including blocks and streets has been saved to json.<p>
<p>Take a look at <a href="map-data.json">map-data.json</a></p>
';


?>

