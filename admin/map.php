<?php
include ("../dbaccess.php"); 


if (isset($_POST['deactivate'])) {
	# Activate map
	$edit = $fm->newEditCommand('Map', $_POST['id']);
	$edit->setField('notAvailableDate', date("m/d/Y"));
	$edit->setField('note', '');
	$edit->execute();

	# Get updated record to update the list item
	$record = $fm->getRecordByID('Map', $_POST['id']);
	#echo 'Map ' . $record->getField('Map') . ' not available from ' . $record->getField('notAvailableDate');
	$url = 'https://qc.r2labs.com/ah/v10/admin/index.php?Filter=unassigned&msg=Map%20' . $record->getField('Map') . '%20has%20been%20deactivated';
	header('Location: ' . $url);

} elseif (isset($_POST['activate'])) {
	# Deactivate map
	$edit = $fm->newEditCommand('Map', $_POST['id']);
	$edit->setField('notAvailableDate', '');
	$edit->setField('note', 'Ready for First pass');
	$edit->execute();

	# Get updated record to update the list item
	$record = $fm->getRecordByID('Map', $_POST['id']);
	#echo 'Map ' . $record->getField('Map') . ' now available';
    $url = 'https://qc.r2labs.com/ah/v10/admin/index.php?Filter=deactivated&msg=Map%20' . $record->getField('Map') . '%20has%20been%20activated';
	header('Location: ' . $url);

} elseif (isset($_POST['unassign'])) {
	# Hand map in
	$edit = $fm->newEditCommand('MapAssignment', $_POST['id']);
	$edit->setField('handInDate', date("m/d/Y"));
    $edit->setField('endContacted', $_POST['cAH']);
    $edit->setField('Map::mapAssignmentId', '');
	$edit->execute();

	$edit1 = $fm->newEditCommand('Map', $_POST['Map']);
	$edit1->setField('userID', '');
    $edit1->setField('coverageType', '');
	$edit1->execute();

	//$output = shell_exec('php ../map-assignees.php');
	//echo "<pre>$output</pre>";
	/* output
	hello world!
	*/

	$request = $fm->newFindCommand('MapAssignees');
$request->addFindCriterion('MapCount', '>0');
$request->addSortRule('First' ,1,FILEMAKER_SORT_ASCEND);
$result = $request->execute();

# Trap for errors
if (FileMaker::isError($result)) {
    $errorMessage = $result->getMessage();
    echo $errorMessage;
} else {
    /*$records = $result->getRecords();

    $availableMaps = array();
    foreach($records as $record) {
        $availableMaps[] = array(
            'firstName' => $record->getField('First'),
            //'Suburb' => $record->getField('MapSuburb::suburb'),
            //'Colour' => $record->getField('Suburb::badgeColour'),
            //'Name' => $record->getField('MapAssignment::cFirstName'),
            //'coverageType' => $record->getField('MapAssignment::coverageType'),

            //'toContact' => $record->getField('nhTotal'),
        );
    }


    print_r($availableMaps);

    echo '<br><hr><br>';*/

    $records = $result->getRecords();
    $var = array();
    foreach($records as $record) {
        $related_records = $record->getRelatedSet('Map');
        $var1 = array();
        foreach($related_records as $related_record) {
            $var1[] = array(
            'mapNumber' => $related_record->getField('Map::Map'),
            'coverageType' => $related_record->getField('Map::coverageType'),
            'suburb' => $related_record->getField('Map::cSuburb'),
            'badgeColour' => $related_record->getField('Map::cBadgeColour')
            );
        }

        $var[] = array(
            'firstName' => $record->getField('First'),
            //'status' => $record->getField('status'),
            'Maps' => $var1
        );

    }

    //print_r($var);
    //echo json_encode($var);
    //Save the JSON string to a text file.
    file_put_contents('../assignees.json', json_encode($var));

}

	echo '<div class="alert alert-success alert-dismissible fade show" role="alert" id="alert-foo">
	        Map ' . $_POST['Map'] . ' has been handed in 
		    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
	        </button>
	      </div>'; 

} elseif (isset($_POST['assign'])) {
	# Hand map out
	$edit = $fm->newEditCommand('Map', $_POST['id']);
	$edit->setField('MapAssignment::map', $_POST['id']);
    $edit->setField('MapAssignment::userId', $_POST['userId']);
    $edit->setField('userID', $_POST['userId']);
    $edit->setField('coverageType', $_POST['coverageType']);
	$edit->setField('MapAssignment::handOutDate', date("m/d/Y"));
    $edit->setField('MapAssignment::coverageType', $_POST['coverageType']);
    $edit->setField('coverageType', $_POST['coverageType']);
    $edit->setField('MapAssignment::startContacted', $_POST['cAH']);
	$edit->execute();

    	$request = $fm->newFindCommand('MapAssignees');
	$request->addFindCriterion('MapCount', '>0');
	$request->addSortRule('First' ,1,FILEMAKER_SORT_ASCEND);
	$result = $request->execute();

	# Trap for errors
	if (FileMaker::isError($result)) {
	    $errorMessage = $result->getMessage();
	    echo $errorMessage;
	} else {
	    /*$records = $result->getRecords();

	    $availableMaps = array();
	    foreach($records as $record) {
	        $availableMaps[] = array(
	            'firstName' => $record->getField('First'),
	            //'Suburb' => $record->getField('MapSuburb::suburb'),
	            //'Colour' => $record->getField('Suburb::badgeColour'),
	            //'Name' => $record->getField('MapAssignment::cFirstName'),
	            //'coverageType' => $record->getField('MapAssignment::coverageType'),

	            //'toContact' => $record->getField('nhTotal'),
	        );
	    }


	    print_r($availableMaps);

	    echo '<br><hr><br>';*/

	    $records = $result->getRecords();
	    $var = array();
	    foreach($records as $record) {
	        $related_records = $record->getRelatedSet('Map');
	        $var1 = array();
	        foreach($related_records as $related_record) {
	            $var1[] = array(
	            'mapNumber' => $related_record->getField('Map::Map'),
	            'coverageType' => $related_record->getField('Map::coverageType'),
	            'suburb' => $related_record->getField('Map::cSuburb'),
	            'badgeColour' => $related_record->getField('Map::cBadgeColour')
	            );
	        }

	        $var[] = array(
	            'firstName' => $record->getField('First'),
	            //'status' => $record->getField('status'),
	            'Maps' => $var1
	        );

	    }

	    //print_r($var);
	    //echo json_encode($var);
	    //Save the JSON string to a text file.
	    file_put_contents('../assignees.json', json_encode($var));

	}

	$record = $fm->getRecordByID('Map', $_POST['id']);
	echo '<div class="alert alert-success alert-dismissible fade show" role="alert" id="alert-foo">
	        Map ' . $_POST['Map'] . ' has been handed out to  ' . $record->getField('MapAssignment::cFirstName') . 
	        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
	        </button>
	      </div>'; 

} elseif (isset($_POST['updateNote'])) {
	# Update map note
	$edit = $fm->newEditCommand('Map', $_POST['id']);
	$edit->setField('note', $_POST['note']);
	$edit->execute();

	$record = $fm->getRecordByID('Map', $_POST['id']);
	echo $record->getField('note');

} elseif (isset($_POST['deleteNote'])) {
	# Delete map note
	$edit = $fm->newEditCommand('Map', $_POST['id']);
	$edit->setField('note', '');
	$edit->execute();

	$record = $fm->getRecordByID('Map', $_POST['id']);
	echo '<div class="alert alert-success alert-dismissible fade show" role="alert" id="alert-foo">
	        Note has been deleted
	        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
	        </button>
	      </div>';

} elseif (isset($_POST['revoke'])) {
	# Deletae map assignment
	$edit = $fm->newEditCommand('MapAssignment', $_POST['id']);
    $edit->setField('Map::mapAssignmentId', '');
	$edit->execute();

	$edit = $fm->getRecordById('MapAssignment', $_POST['id']);
    $edit->delete();

	echo '<div class="alert alert-success alert-dismissible fade show" role="alert" id="alert-foo">
	        Map ' . $_POST['Map'] . ' assignment has been revoked 
		    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
	        </button>
	      </div>'; 


} elseif (isset($_POST['unassign-phone-map'])) {
	# Hand map in
	$edit = $fm->newEditCommand('MapAssignment', $_POST['id']);
	$edit->setField('handInDate', date("m/d/Y"));
    $edit->setField('endContacted', $_POST['cAH']);
    $edit->setField('Map::mapAssignmentId', '');
	$edit->execute();

	$url = 'https://qc.r2labs.com/ah/v10/phone/index.php?msg=Map%20' . $_POST['Map'] . '%20has%20been%20handed%20in';
	header('Location: ' . $url); 

}
 
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

$fp = fopen('../map-list.json', 'w');
fwrite($fp, json_encode($availableMaps, JSON_NUMERIC_CHECK));
fclose($fp);
//echo 'Map list saved.';

# Debug form
/*
echo '<form action="map.php" method="POST">
    ID:<br>
    <input type="text" name="id" value="1">
    <br>
    Date:<br>
    <input type="text" name="date" value="1/1/2017">
    <br>
    <input type="submit" value="Submit">
</form>';
*/

?>
