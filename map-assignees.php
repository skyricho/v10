<?php
include ("dbaccess.php"); 
ini_set('display_errors', 1);


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
    echo json_encode($var);
    //Save the JSON string to a text file.
    file_put_contents('assignees.json', json_encode($var));

}

?>
