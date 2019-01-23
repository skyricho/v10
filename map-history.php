<?php
include ("dbaccess.php"); 
require 'vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader);
$template = $twig->load('map-history.html.twig');

$request = $fm->newFindCommand('MapAssignment');
$request->addFindCriterion('map', $_GET['Map']);
$request->addSortRule('cLastContactDate', 1, FILEMAKER_SORT_DESCEND);
$result = $request->execute();

$records = $result->getRecords();
$mapAssignments = array();
foreach($records as $record) {
    $mapAssignments[] = array(
        'date' => $record->getField('cLastContactDate'),
        'coverage' => $record->getField('coverageType'),
        'name' => $record->getField('User MapAssignment::First'),
        'contacted' => $record->getField('cContacted'),
        'badgeColour' => $record->getField('CoverageType::badgeColour')
    );
}

echo $template->render(array(
    'mapAssignments' => $mapAssignments,
    'token' => $_GET['token']
        )
    );

?>