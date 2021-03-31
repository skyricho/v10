<?php
include ("dbaccess.php"); 
require 'vendor/autoload.php';
//ini_set('display_errors', 1);

$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader);
$template = $twig->load('index.html.twig');

if (isset($_GET['Street'])) {
    # Query available addresses
    $request = $fm->newFindCommand('AddressList');
    $request->addFindCriterion('Map', $_GET['Map']); 
    $request->addFindCriterion('Block', $_GET['Block']);
    $request->addFindCriterion('Street', str_replace('-', ' ', $_GET['Street']));
    # Filter
    if ($_GET['Filter'] == 'Contacted') {
        $fmfilter = '==';
    }
    $request->addFindCriterion('isHome', $fmfilter);
    $request->addSortRule('cNumber', 1);
    $result = $request->execute();

    # Trap for errors
    if (FileMaker::isError($result)) {
        $errorMessage = $result->getMessage();
    } else {
        $records = $result->getRecords();

        $addresses = array();
        foreach($records as $record) {
            $addresses[] = array(
                'recID' => $record->getField('recID'),
                'cStatus' => $record->getField('cStatus'),
                'modDate' => $record->getField('modDate'),
                'streetNumber' => $record->getField('Number'),
                'streetName' => $record->getField('Street'),
                'streetNameWithDash' => str_replace(' ', '-', $record->getfield('Street')),
                'description' => $record->getField('Address Description'),
                'cUnitsCount' => $record->getField('cUnitsCount'),
                'UnitsNH' => $record->getField('Units NH'),
            );
        }
    }

    # Query available streets
    $request = $fm->newFindCommand('BlockStreet');
    $request->addFindCriterion('MapBlock::Map', $_GET['Map']);
    $request->addFindCriterion('MapBlock::Block', $_GET['Block']); 
    $result = $request->execute();
    $records = $result->getRecords();

    $streets = array();
    foreach($records as $record) {
        $streets[] = array(
            'street' => $record->getfield('Street'),
            'streetWithDash' => str_replace(' ', '-', $record->getfield('Street')),
        );   
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
    
    # prepare variables for template
    echo $template->render(array(
            'navbarFilter' => $_GET['Filter'],
            'addresses' => $addresses,
            'street' => str_replace('-', ' ', $_GET['Street']),
            'streetWithDash' => $_GET['Street'],
            'streets' => $streets,       
            'blockNumber' => $_GET['Block'],
            'mapBlocks' => $mapBlocks,
            'mapNumber' => $_GET['Map'],
            'errorMessage' => $errorMessage
        )
    );

} elseif (isset($_GET['Block'])) {
    # Query available streets
    $request = $fm->newFindCommand('BlockStreet');
    $request->addFindCriterion('MapBlock::Map', $_GET['Map']);
    $request->addFindCriterion('MapBlock::Block', $_GET['Block']); 
    $result = $request->execute();
    $records = $result->getRecords();

    $streets = array();
    foreach($records as $record) {
        $streets[] = array(
            'street' => $record->getfield('Street'),
            'streetWithDash' => str_replace(' ', '-', $record->getfield('Street')),
        );   
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
            'streets' => $streets,       
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
    //Record the start time before the query is executed.
    $started = microtime(true);

    //Execute Filemaker query.
    //$request = $fm->newFindCommand('Map');
    $request = $fm->newFindAllCommand('Map Lite');
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
    

    //Record the end time after the query has finished running.
    $end = microtime(true);

    //Calculate the difference in microseconds.
    $difference = $end - $started;

    //Format the time so that it only shows 10 decimal places.
    $queryTime = number_format($difference, 10);


    echo $template->render(array(
        'availableMaps' => $availableMaps,
        'errorMessage' => $errorMessage,
        'queryTime' => $queryTime
        )
    );

}

?>
