<?php 
include ("../dbaccess.php");

$request = $fm->newFindAllCommand('AddressChange');
$result = $request->execute();


$records = $result->getRecords();
foreach($records as $record) {
    echo $record->getField('streetNumber') . ' ' . $record->getField('streetName') . '<br>';
}

?>