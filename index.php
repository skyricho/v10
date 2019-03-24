<?php
include ("dbaccess.php"); 
require 'vendor/autoload.php';
//ini_set('display_errors', 1);


$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader);
$template = $twig->load('index.html.twig');

if (isset($_GET['Block'])) {
    # Query avaible addresses
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
            'blockToContact' => $record->getField('blockToContact')
        );
    }    

    # prepare variables for template
    echo $template->render(array(
        'mapNumber' => $_GET['Map'],
        'blockNumber' => $_GET['Block'],
        'street' => str_replace('-', ' ', $_GET['Street']),
        'streetWithDash' => $_GET['Street'],
        #'availableMaps' => $availableMaps,
        'mapBlocks' => $mapBlocks,
        'addresses' => $addresses,
        'streets' => $streets,
        #'mapStreet' => 'quux',
        'navbarFilter' => $_GET['Filter'],
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
         'mapNumber' => $_GET['Map'],
         'mapBlocks' => $mapBlocks,
        )
    );
} else {
    $request = $fm->newFindCommand('Map');
    $request->addFindCriterion('mapAssignmentId', '*');
    $request->addFindCriterion('MapAssignment::coverageType', 'Campaign');
    //$request->addFindCriterion('isPhoneMap', 0);
    $result = $request->execute();
    $records = $result->getRecords();

    $availableMaps = array();
    foreach($records as $record) {
        $availableMaps[] = array(
            'Map' => $record->getField('Map'),
            'Suburb' => $record->getField('MapSuburb::suburb'),
            'Colour' => $record->getField('Suburb::badgeColour'),
            'Name' => $record->getField('MapAssignment::cFirstName'),
            //'toContact' => $record->getField('nhTotal'),
        );
    }
    
    echo $template->render(array(
        'availableMaps' => $availableMaps,
        )
    );

}


?>
