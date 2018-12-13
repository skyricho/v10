
<?php 
include ("../dbaccess.php");
require '../vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('../views');
$twig = new Twig_Environment($loader);
$template = $twig->load('phone/phone-numbers.twig');

$request = $fm->newFindCommand('PhoneNumber');
$request->addFindCriterion('propertyID', $_GET['propertyID']);  
$result = $request->execute();

$records = $result->getRecords();
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

?>