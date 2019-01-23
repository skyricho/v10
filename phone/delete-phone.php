<?php
include ("../dbaccess.php"); 

$record = $fm->getRecordById('PhoneNumber', $_GET['recID']);
//$record = $fm->getRecordById('PhoneNumber', $_POST['recID']);
$record->delete();

echo 'Phone number deleted';

?>