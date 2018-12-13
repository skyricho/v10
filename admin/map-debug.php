<?php
include ("../dbaccess.php"); 

if (isset($_POST['id'])) {
# Make map not avialable
$edit = $fm->newEditCommand('Map', $_POST['id']);
$edit->setField('notAvailableDate', date("m/d/Y"));
$edit->execute();

# Get updated record to update the list item
$record = $fm->getRecordByID('Map', $_POST['id']);
echo 'Map ' . $record->getField('Map') . ' not available from ' . $record->getField('notAvailableDate');
}

echo '<form action="map.php" method="POST">
    ID:<br>
    <input type="text" name="id" value="1">
    <br>
    Date:<br>
    <input type="text" name="date" value="1/1/2017">
    <br>
    <input type="submit" value="Submit">
</form>';
?>
