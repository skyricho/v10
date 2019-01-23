<?php
include ("../dbaccess.php");
require '../vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('../views');
$twig = new Twig_Environment($loader);
$template = $twig->load('admin/s-13.html.twig');

$request = $fm->newFindAllCommand('S-13');
$result = $request->execute();

$records = $result->getRecords();
$maps = array();
foreach($records as $record) {
/* failed attempt to get related records
    $related_records = $record->getRelatedSet('Map History 2');
    $mapAssignments = array();
    foreach($related_records as $related_record) {
        $mapAssignments[] = array(
            'foo' => 'baz',
            //'name' => $related_record->getField('Map History 2::cFirstName'),
                      //$related_record->getField('related_data::Text'),
        );
    }
*/
    $maps[] = array(
        'Map' => $record->getField('Map'),
        'MapAssignments' => str_replace('!!', "\r", $record->getField('assignmentHistory')),
        //'MapAssignments' => $mapAssignments,

    
    );
}



# Render vars for template
echo $template->render(array(
    'maps' => $maps,
    )
);


?>
