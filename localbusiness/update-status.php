<?php
include ("../dbaccess.php"); 

# Check the POST recID and assign action.
if (isset($_POST['id'])) {
    $edit = $fm->newEditCommand('LocalBusiness', $_POST['id']);
    $edit->setField('status', $_POST['status']);
    $edit->execute();


} else {
    echo 'Houston we have a problem'; 
}

    # Render updated record
$record = $fm->getRecordByID('LocalBusiness', $_POST['id']);

echo '<span class="badge badge-secondary">' . $record->getField('status') . '</span>';

?>



