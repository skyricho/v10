<?php
include ("../dbaccess.php");
ini_set('display_errors', 1);

if (isset($_POST['update'])) {
    $edit = $fm->newEditCommand('LocalBusiness', $_POST['id']);
    $edit->setField('assignedTo', $_POST['assignedTo']);
    $edit->setField('map', $_POST['map']);
    $edit->setField('block', $_POST['block']);
    $edit->setField('businessName', $_POST['businessName']);
    $edit->setField('streetAddressRaw', $_POST['address']);
    $edit->setField('contactName', $_POST['contactName']);
    $edit->setField('contactPosition', $_POST['contactPosition']);
    $edit->setField('contactEmail', $_POST['contactEmail']);
    $edit->setField('FormSubmissionUser', $_POST['user']);
    $edit->execute();

    echo 'Saved.';
}


?>