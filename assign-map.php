<?php
include ("dbaccess.php"); 

# Check the POST recID and assign map.
if (isset($_POST['recID'])) {
    $edit = $fm->newEditCommand('Map', $_POST['recID']);
    $edit->setField('userID MATCH FIELD', $_POST['userID']);
    //Filemaker expects date filed to be month/date/year
    $date = date('m/d/Y');
    $edit->setField('checkOut', $date);
    $edit->execute();


} else {
    echo 'Houston we have a problem'; 
}

    # Render shipped value
$record = $fm->getRecordByID('Map', $_POST['recID']);

echo '<p>Assigned to ' . '<a href="sms:' . $record->getField('User::mobile') . '">' . $record->getField('User::firstLast') . '</p>';


?>



