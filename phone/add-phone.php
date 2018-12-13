<?php
include ("../dbaccess.php");
require '../vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('../views');
$twig = new Twig_Environment($loader);
$template = $twig->load('phone/phone-numbers.twig');

$form = $fm->createRecord('PhoneNumber');
$form->setField('phoneNumber', $_POST['phoneNumber']);
$form->setField('propertyID', $_POST['propertyID']);
$result=$form->commit();

$form = $form->getRecordID();
//echo $form . '<br>';
$records = $fm->getRecordByID('PhoneNumber', $form);


# all phone numbers for this address
/*$request = $fm->newFindCommand('PhoneNumber');
$request->addFindCriterion('propertyID', $_POST['propertyID']); 
$result = $request->execute();
$records = $result->getRecords();*/

$phones = array();
foreach($records as $record) {
    $phones[] = array(
        'recID' => $record->getField('recID'),
        'phone' => $record->getField('phoneNumber'),
        'phoneSafe' => str_replace(" ","",$record->getField('phoneNumber')),
        'notInService' => $record->getField('notInService'),
    );
}

# prepare variables for template
echo $template->render(array(
    'phones' => $phones,
    )
);

# render record just created
/*$form = $form->getRecordID();
//echo $form . '<br>';
$record = $fm->getRecordByID('PhoneNumber', $form);
$phoneSafe = str_replace(" ","",$record->getField('phoneNumber'));
echo '<a href="tel:' . $phoneSafe . '">' . $record->getField('phoneNumber') . '</a>';*/

?>