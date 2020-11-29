<?php
include ("dbaccess.php"); 
require 'vendor/autoload.php';
//ini_set('display_errors', 1);

$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader);
$template = $twig->load('index.html.twig');


$request = $fm->newFindCommand('Map');
$request->addFindCriterion('mapAssignmentId', '*');
//$request->addFindCriterion('isPhoneMap', 0);
$result = $request->execute();

# Trap for errors
if (FileMaker::isError($result)) {
    $errorMessage = $result->getMessage();
} else {
    $records = $result->getRecords();

    $availableMaps = array();
    foreach($records as $record) {
        $availableMaps[] = array(
            'Map' => $record->getField('Map'),
            'Suburb' => $record->getField('MapSuburb::suburb'),
            'Colour' => $record->getField('Suburb::badgeColour'),
            'Name' => $record->getField('MapAssignment::cFirstName'),
            'coverageType' => $record->getField('MapAssignment::coverageType'),

            //'toContact' => $record->getField('nhTotal'),
        );
    }
}

echo $template->render(array(
    'availableMaps' => $availableMaps,
    'errorMessage' => $errorMessage
    )
);

?>
