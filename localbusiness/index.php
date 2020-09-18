<?php
include ("../dbaccess.php"); 
require '../vendor/autoload.php';
ini_set('display_errors', 1);

$loader = new Twig_Loader_Filesystem('../views');
$twig = new Twig_Environment($loader);
$template = $twig->load('localbusiness/index.html.twig');

if (isset($_GET['Block'])) {
    # Query avaible buinsesses to contact
    $request = $fm->newFindCommand('LocalBusiness');
    $request->addFindCriterion('map', $_GET['Map']);
    $request->addFindCriterion('block', $_GET['Block']);
    $request->addSortRule('status', 1);
    
    $result = $request->execute();
    if (FileMaker::isError($result)) {
        $errorMessage = $result->getMessage();
        //echo "<p>Error: " . $result->getMessage() . "</p>"; exit;
    } else {
        $records = $result->getRecords();
        $localbusinesses = array();
        foreach($records as $record) {
            $localbusinesses[] = array(
                'id' => $record->getField('id'),
                'businessName' => $record->getField('businessName'),
                'streetAddressRaw' => $record->getField('streetAddressRaw'),
                'contactName' => $record->getField('contactName'),
                'contactPosition' => $record->getField('contactPosition'),
                'contactEmail' => $record->getField('contactEmail'),                
                'formSubmissionUser' => $record->getField('FormSubmissionUser'),
                'assignee' => $record->getField('assignedTo'),
                'map' => $record->getField('map'),
                'block' => $record->getField('block'),
                //'assigneeDash' => str_replace(' ', '-', $record->getField('assignedTo')),
                'badgeColor' => $record->getField('badgeColor')
            );
        }
    }
    
    # Query available blocks
    $request = $fm->newFindCommand('MapBlock');
    $request->addFindCriterion('Map', $_GET['Map']); 
    $result = $request->execute();
    $records = $result->getRecords();

    $mapBlocks = array();
    foreach($records as $record) {
        $mapBlocks[] = array(
            'Block' => $record->getField('Block'),
            'blockToContact' => $record->getField('blockToContact'),
            'isDone' => $record->getField('isDone')
        );
    }

    echo $template->render(array(
            'localbusinesses' => $localbusinesses,       
            'blockNumber' => $_GET['Block'],
            'mapBlocks' => $mapBlocks,
            'mapNumber' => $_GET['Map'],
            'errorMessage' => $_GET['msg']
        )
    );

} elseif (isset($_GET['Map'])) {
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
