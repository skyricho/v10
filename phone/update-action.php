<?php
include ("../dbaccess.php"); 

# Check the POST recID and assign action.
if (isset($_POST['recID'])) {
    $edit = $fm->newEditCommand('Phone', $_POST['recID']);
    $edit->setField('phoneActionID', $_POST['actionID']);
    $edit->execute();


} else {
    echo 'Houston we have a problem'; 
}

    # Render updated record
$record = $fm->getRecordByID('Phone', $_POST['recID']);

echo '<span class="badge badge-' . $record->getField('PhoneActionState::badgeColour') . '">' . $record->getField('PhoneActionState::action') . '</span>';

?>



