<?php
include ("../dbaccess.php"); 
require '../vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('../views');
$twig = new Twig_Environment($loader);
$template = $twig->load('letter/index.html.twig');

#Make sure there is a record that corresponds to the RecordID. If not, stop the script.
if (isset($_GET['id'])) {
  
    $record = $fm->getRecordByID('AddressList', $_GET['id']);
    $related_records = $record->getRelatedSet('HousingUnit');

    $housing_units = array();
    foreach($related_records as $related_record) {
        $housing_units[] = array(
            'unitID' => $related_record->getField('HousingUnit::unitID'),
            'Number' => $related_record->getField('HousingUnit::Number'),
            'cStatus' => $related_record->getField('HousingUnit::cStatus'),
            'Date' => $related_record->getField('HousingUnit::modDate'),
        );
    }


    # prepare variables for template
    echo $template->render(array(
            'mapNumber' => $_GET['Map'],
            'street' => str_replace('-', ' ', $_GET['Street']),
            'streetWithDash' => $_GET['Street'],
            'streetNumber' => $_GET['streetNumber'],
             'housing_units' => $housing_units,
        )
    );

} elseif (isset($_GET['Street'])) {
    # Query available addresses
    $request = $fm->newFindCommand('AddressList');
    $request->addFindCriterion('Map', $_GET['Map']); 
    $request->addFindCriterion('Street', str_replace('-', ' ', $_GET['Street']));
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
                'unitsNH' => $record->getField('unitsNH'),
                'cUnitBlockContacted' => $record->getField('cUnitBlockContacted'),
            );
        }
    }
    

    # prepare variables for template
    echo $template->render(array(
            'addresses' => $addresses,
            'street' => str_replace('-', ' ', $_GET['Street']),
            'streetWithDash' => $_GET['Street'],
            'streets' => $streets,       
            'mapNumber' => $_GET['Map'],
            'errorMessage' => $errorMessage
        )
    );

} elseif(isset($_GET['Map'])) {
    # Query available streets
    $request = $fm->newFindCommand('MapStreet');
    $request->addFindCriterion('Map', $_GET['Map']); 
    $result = $request->execute();

    $records = $result->getRecords();
    $mapStreets = array();
    $mapToContact = 0;
    foreach($records as $record) {
        $mapToContact = $mapToContact + $record->getField('toContact');
        $mapStreets[] = array(
            'Street' => $record->getField('street'),
            'streetWithDash' => str_replace(' ', '-', $record->getfield('street')),
            'toContact' => $record->getField('toContact'),
        );
    }

    # Get locality
    $json = file_get_contents('../map-localities.json',0,null,null);
    $array = json_decode($json,true);
    //var_dump($array);
    //echo $array['1'];
    $suburb = $array[$_GET['Map']];

    # Get Address Total
    $json = file_get_contents('../map-address-totals.json',0,null,null);
    $array = json_decode($json,true);
    $addressTotal = $array[$_GET['Map']];

    # Calculate progress percentage
    $progressPercentage = floor(($addressTotal - $mapToContact) * ( 100 / $addressTotal ));

    echo $template->render(array(
         'mapNumber' => $_GET['Map'],
         'mapStreets' => $mapStreets,
         'suburb' => $suburb,
         'progressPercentage' => $progressPercentage,
        )
    );
}