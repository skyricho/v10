<?php
include ("../dbaccess.php"); 
require '../vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('../views');
$twig = new Twig_Environment($loader);
$template = $twig->load('admin/index.html.twig');

$request = $fm->newFindCommand('Map');
if ($_GET['Filter'] == 'deactivated') {
    $request->addFindCriterion('notAvailableDate', '*');
    $request->addSortRule('notAvailableDate', 1);

} elseif ($_GET['Filter'] == 'unassigned') {
    $request->addFindCriterion('mapAssignmentId', '=');
    $request->addFindCriterion('notAvailableDate', '=');

} else {
    $request->addFindCriterion('mapAssignmentId', '*');
} 

$result = $request->execute();
$records = $result->getRecords();

$availableMaps = array();
foreach($records as $record) {
    $availableMaps[] = array(
        'Map' => $record->getField('Map'),
        'mapAssignmentId' => $record->getField('mapAssignmentId'),
        'cAH' => $record->getField('cAH'),
        'cNH' => $record->getField('cNH'),
        'Suburb' => $record->getField('MapSuburb::suburb'),
        'Colour' => $record->getField('Suburb::badgeColour'),
        'Name' => $record->getField('MapAssignment::cFirstName'),
        'id' => $record->getField('recID'),
        'coverageType' => $record->getField('MapAssignment::coverageType'),
        'notAvailableDate' => $record->getField('notAvailableDate'),
        'note' => $record->getField('note'),
        'addressTotal' => $record->getField('addressTotal'),
          
    );
}

# Get List of users
$request = $fm->newFindAllCommand('User');
$result = $request->execute();

$records = $result->getRecords();
$users = array();
foreach($records as $record) {
    $users[] = array(
        'id' => $record->getField('userID'),
        'first' => $record->getField('First'),
        'last' => $record->getField('Last'),
    );
}

# Render vars for template
echo $template->render(array(
    'availableMaps' => $availableMaps,
    'Filter' => $_GET['Filter'],
    'errorMessage' => $_GET['msg'],
    'users' => $users
    )
);





?>
