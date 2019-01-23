<?php
include ("../dbaccess.php");
require '../vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('../views');
$twig = new Twig_Environment($loader);
$template = $twig->load('phone/phone-number.twig');

$edit = $fm->newEditCommand('PhoneNumber', $_GET['recID']);
$edit->setField('notInService', 'yes');
$edit->execute();

$record = $fm->getRecordByID('PhoneNumber', $_GET['recID']);

/*$records = $fm->getRecordByID('PhoneNumber', $_GET['recID']);
$phones = array();
foreach($records as $record) {
    $phones[] = array(
        'recID' => $record->getField('recID'),
        'phone' => $record->getField('phoneNumber'),
        'phoneSafe' => str_replace(" ","",$record->getField('phoneNumber')),
        'notInService' => $record->getField('notInService'),
    );
}*/

# prepare variables for template
echo $template->render(array(
    //'phones' => $phones,
    'recID' => $record->getField('recID'),
    'phone' => $record->getField('phoneNumber'),
    'phoneSafe' => str_replace(" ","",$record->getField('phoneNumber')),
    'notInService' => $record->getField('notInService'),
    )
);

?>