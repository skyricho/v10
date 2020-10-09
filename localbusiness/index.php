<?php
include ("../dbaccess.php"); 
require '../vendor/autoload.php';
ini_set('display_errors', 1);

$loader = new Twig_Loader_Filesystem('../views');
$twig = new Twig_Environment($loader);
$template = $twig->load('localbusiness/index.html.twig');

if (isset($_GET['Map'])) {
    # Query available blocks
    $request = $fm->newFindCommand('MapBlock');
    $request->addFindCriterion('Map', $_GET['Map']); 
    $result = $request->execute();
    $records = $result->getRecords();

    $mapBlocks = array();
    foreach($records as $record) {
        $mapBlocks[] = array(
            'Block' => $record->getField('Block'),
            //'blockToContact' => $record->getField('blockToContact'),
            'isDone' => $record->getField('isDone')
        );
    }

    echo $template->render(array(
            'mapBlocks' => $mapBlocks,
            'mapNumber' => $_GET['Map'],
            'errorMessage' => $_GET['msg']
        )
    );

} else {
    //$request = $fm->newFindCommand('Map');
    //$request->addFindCriterion('Map', '*');
    $request = $fm->newFindAllCommand('MapList');
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
                'cBusinessSum' => $record->getField('cBusinessSum'),
                'campaignAssignee' => $record->getField('campaignAssignee'),
                'sBusinessTotal' => $record->getField('sBusinessTotal')


                //'toContact' => $record->getField('nhTotal'),
            );
        }
    }
    
    echo $template->render(array(
        'availableMaps' => $availableMaps,
        'errorMessage' => $errorMessage
        )
    );

}

?>