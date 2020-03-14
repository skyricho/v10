<?php
include ("dbaccess.php");
ini_set('display_errors', 1);

$request = $fm->newFindCommand('AddressList');
$request->addFindCriterion('Map', $_GET['Map']);
$request->addFindCriterion('isDNC', 'yes'); 
$result = $request->execute();

if (FileMaker::isError($result)) {
    if (! isset($result->code) || strlen(trim($result->code)) < 1) {
        echo 'A System Error Occured';
    } else {
        echo 'No DNCs';
    }
} else {
    $records = $result->getRecords();
    echo '<h4>DNCs</h4>';
    foreach($records as $record) {
        echo $record->getField('cNumber') . ' ' . $record->getField('Street') . ' ' . '(Block ' . $record->getField('Block') . ')<br>';
    }
}


$request = $fm->newFindCommand('HousingUnits');
$request->addFindCriterion('Map', $_GET['Map']);
$request->addFindCriterion('isDNC', 'yes'); 
$result = $request->execute();

if (FileMaker::isError($result)) {
    if (! isset($result->code) || strlen(trim($result->code)) < 1) {
        echo 'A System Error Occured';
    } else {
        echo '...';
    }
} else {
    $records = $result->getRecords();
    echo '<h4>DNCs (Units)</h4>';
    foreach($records as $record) {
        echo $record->getField('Number') . ' ' . $record->getField('StreetNumber::Street') . ' ' . '(Block ' . $record->getField('StreetNumber::Block') . ')<br>';
    }
}


?>
