<?php 
include ("dbaccess.php"); 
require 'vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader);
$template = $twig->load('housing_units.html.twig');

# Make sure there is a record that corresponds to the RecordID. If not, stop the script.
if (empty($_REQUEST['id'])) {
    die('The record no longer exists.');
}

$record = $fm->getRecordByID('AddressList', $_GET['id']);
$related_records = $record->getRelatedSet('HousingUnit');

$housing_units = array();
foreach($related_records as $related_record) {
    $housing_units[] = array(
        'unitID' => $related_record->getField('HousingUnit::unitID'),
        'Number' => $related_record->getField('HousingUnit::Number'),
        'cStatus' => $related_record->getField('HousingUnit::cStatus'),
        'Date' => $related_record->getField('HousingUnit::modDate'),
    );
}

# prepare variables for template
echo $template->render(array(
         'recID' => $record->getField('recID'),
         'streetNumber' => $record->getField('Number'),
         'housing_units' => $housing_units,
    )
);

?>

