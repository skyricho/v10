<?php
include ("../dbaccess.php"); 
require '../vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('../views');
$twig = new Twig_Environment($loader);
$template = $twig->load('phone/index.html.twig');

if (isset($_GET['Block'])) {
    # Query avaible addresses for phone witnessing
    $request = $fm->newFindCommand('Phone');
    $request->addFindCriterion('Map', $_GET['Map']); 
    $request->addFindCriterion('Block', $_GET['Block']);
    $request->addFindCriterion('Street', str_replace('-', ' ', $_GET['Street']));
    
    $request->addFindCriterion('cPhone', 'phone');
    $request->addSortRule('cNumber', 1);
    $result = $request->execute();
    
    $records = $result->getRecords();
    $addresses = array();
    foreach($records as $record) {
        $addresses[] = array(
            'recID' => $record->getField('recID'),
            //'cStatus' => $record->getField('cStatus'),
            //'modDate' => $record->getField('modDate'),
            'streetNumber' => $record->getField('Number'),
            'streetName' => $record->getField('Street'),
            'streetNameWithDash' => str_replace(' ', '-', $record->getfield('Street')),
            //'description' => $record->getField('Address Description'),
            'badgeColour' => $record->getField('PhoneActionState::badgeColour'),
            'status' => $record->getField('PhoneActionState::action'),
        );
    }
    
    # Query phone actions
    $request = $fm->newFindAllCommand('PhoneActionState'); 
    $result = $request->execute();
    
    $records = $result->getRecords();
    $phoneActions = array();
    foreach($records as $record) {
        $phoneActions[] = array(
            'actionID' => $record->getfield('recID'),
            'action' => $record->getfield('action'),
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
            'blockToContact' => $record->getField('blockToContact'),
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
        'phoneActions' => $phoneActions,
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
            'blockToContact' => $record->getField('blockToContact'),
        );
    }

    echo $template->render(array(
         'mapNumber' => $_GET['Map'],
         'mapBlocks' => $mapBlocks,
        )
    );
} else {
    $request = $fm->newFindCommand('Map');
    $request->addFindCriterion('phoneCheckOut', '*');
    $result = $request->execute();
    $records = $result->getRecords();

    $availableMaps = array();
    foreach($records as $record) {
        $availableMaps[] = array(
            'Map' => $record->getField('Map'),
            'Suburb' => $record->getField('MapSuburb::suburb'),
            'Colour' => $record->getField('Suburb::badgeColour'),
        );
    }
    
    echo $template->render(array(
        'availableMaps' => $availableMaps,
        )
    );

}


?>
