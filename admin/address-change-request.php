<?php 
include ("../dbaccess.php");

if (isset($_POST['addAddress'])) {
    $request = $fm->createRecord('AddressChange');
	$request->setField('streetNumber', $_POST['streetNumber']);
	$request->setField('StreetNumber::Number', $_POST['streetNumber']);
    $request->setField('note', $_POST['note']);
	$request->setField('streetName', $_POST['streetName']);
    $request->setField('StreetNumber::Street', $_POST['streetName']);
	$request->setField('map', $_POST['map']);
    $request->setField('StreetNumber::Map', $_POST['map']);
	$request->setField('block', $_POST['block']);
    $request->setField('StreetNumber::Block', $_POST['block']);
	$request->setField('userName', $_POST['userName']);
	$request->setField('date', date('n/j/Y'));
	$request->setField('action', $_POST['action']);
	$result=$request->commit();

  	$request = $request->getRecordID();
  	$record = $fm->getRecordByID('AddressChange', $request);
	$msg = $record->getField("streetNumber") . ' ' . $record->getField("streetName") . ' added. Thanks for making the address list more accurate.';
  	$mapBlockId = $record->getField('MapBlock AddressChange::MapBlockID');

  	//Add map block ID
  	$edit = $fm->newEditCommand('AddressChange', $request);
  	$edit->setField('StreetNumber::MapBlockID', $mapBlockId);
    // Execute the request.
    $edit->execute();

} elseif (isset($_POST['deleteAddress'])) {
	$request = $fm->createRecord('AddressChange');
	$request->setField('streetNumber', $_POST['streetNumber']);
	$request->setField('streetName', $_POST['streetName']);
	$request->setField('map', $_POST['map']);
	$request->setField('block', $_POST['block']);
	$request->setField('userName', $_POST['userName']);
	$request->setField('date', date('n/j/Y'));
	$request->setField('action', $_POST['action']);
	$result=$request->commit();

	$request = $request->getRecordID();
  	$record = $fm->getRecordByID('AddressChange', $request);
	$msg = $record->getField("streetNumber") . ' ' . $record->getField("streetName") . ' deleted. Thanks for making the address list more accurate.';
  	$mapBlockId = $record->getField('MapBlock AddressChange::MapBlockID');

  	//Delete map number, block number and map block ID
  	$edit = $fm->newEditCommand('AddressChange', $request);
  	$edit->setField('StreetNumber::Map', '');
  	$edit->setField('StreetNumber::Block', '');
  	$edit->setField('StreetNumber::MapBlockID', '');
    // Execute the request.
    $edit->execute();

} elseif (isset($_POST['addDnc'])) {
    $request = $fm->createRecord('AddressChange');
	$request->setField('streetNumber', $_POST['streetNumber']);
	$request->setField('streetName', $_POST['streetName']);
	$request->setField('note', $_POST['note']);
	$request->setField('map', $_POST['map']);
	$request->setField('block', $_POST['block']);
	$request->setField('userName', $_POST['userName']);
	$request->setField('date', date('n/j/Y'));
	$request->setField('action', $_POST['action']);
	$result=$request->commit();

	$request = $request->getRecordID();
  	$record = $fm->getRecordByID('AddressChange', $request);
	$msg = $record->getField("streetNumber") . ' ' . $record->getField("streetName") . ' is now a Do Not Call. The map servant may contact you to learn more.';
  	$mapBlockId = $record->getField('MapBlock AddressChange::MapBlockID');

  	//Change status to Do Not Call
  	$edit = $fm->newEditCommand('AddressChange', $request);
  	$edit->setField('StreetNumber::isDNC', 'yes');
  	// Execute the request.
    $edit->execute();

} else {
    $msg = 'error';
}

$map = $_POST['urlMap'];
$block = $_POST['urlBlock'];
$street = $_POST['urlStreet'];
header('Location: https://qc.r2labs.com/ah/v10/index.php?Map=' . $map . '&Block=' . $block . '&Street=' . $street . '&msg=' . $msg); 
?>