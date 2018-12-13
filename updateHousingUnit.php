<?php 
include ("dbaccess.php"); 
require 'vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader);
$template = $twig->load('update_housing_unit.html.twig');

if (isset($_POST['id'])) {
  # This is just a straight forward insert demo.
  $edit = $fm->newEditCommand('updateHousingUnit', $_POST['id']);
  # Set the fields with the values from the $_POST superglobal
  $edit->setField('isHome', $_POST['isHome']);
  # Execute the newEditCommand
  $edit->execute();
}

$record = $fm->getRecordByID("updateHousingUnit", $_POST['id']);

# prepare variables for template
echo $template->render(array(
         'unitID' => $record->getField('unitID'),
         'unitNumber' => $record->getField('Number'),
         'streetNumber' => $record->getField('StreetNumber::Number'),
         'Date' => $record->getField('modDate'),
         'cStatus' => $record->getfield('cStatus'),
    )
);
  
?>