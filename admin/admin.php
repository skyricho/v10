<?php
include ("dbaccess.php"); 
require 'vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader);
$template = $twig->load('admin.html.twig');

$filter = $_GET['Filter'];

$request = $fm->newFindCommand('Map');
if ($filter == 'checked-in') {
    $request->addFindCriterion('checkOut', '==');
    $label = 'Checked In'; 
} elseif ($filter == 'show-all') {
    $request->addFindCriterion('Map', '*');
    $label = 'Show All';
} else {
    $request->addFindCriterion('checkOut', '*');
    $label = 'Checked Out';
}

$request->addSortRule('Map', 1);
$result = $request->execute();
$records = $result->getRecords();

$maps = array();
foreach($records as $record) {
    $maps[] = array(
        'recID' => $record->getField('recID'),
        'map' => $record->getField('Map'),
        'checkOut' => $record->getField('checkOut'),
        'suburb' => $record->getField('MapSuburb::suburb'),
        'badgeColour' => $record->getField('Suburb::badgeColour'),
        'coverage' => $record->getField('coverage'),
        'firstName' => $record->getField('User::First'), 
    );
}

    

# prepare variables for template
echo $template->render(array(
    'maps' => $maps,
    'label' => $label,
    )
);


?>
