<?php
include ("../dbaccess.php");

if (isset($_POST['approve'])) {
      $edit = $fm->newEditCommand('AddressChange', $_POST['id']);
      $edit->setField('approveDate', date('n/j/Y'));
    // Execute the request.
    $edit->execute();
echo 'foo ' . $_POST['id'];    
    //$request = $request->getRecordID();
    //$record = $fm->getRecordByID('AddressChange', $_POST['id']);
    //echo 'Reviewed ' . $record->getField("approveDate");
 }
 ?>