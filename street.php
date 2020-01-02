<?php
include ("dbaccess.php"); 
require 'vendor/autoload.php';
//ini_set('display_errors', 1);

$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader);
$template = $twig->load('street.html.twig');

if (isset($_GET['street'])) {
    # Query available addresses
    $request = $fm->newFindCommand('AddressList');
    $request->addFindCriterion('Map', $_GET['map']); 
    $request->addFindCriterion('Block', $_GET['block']);
    $request->addFindCriterion('Street', str_replace('-', ' ', $_GET['street']));
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

    
    # prepare variables for template
    echo $template->render(array(
            'navbarFilter' => $_GET['Filter'],
            'addresses' => $addresses,
            'street' => str_replace('-', ' ', $_GET['street']),
            'streetWithDash' => $_GET['street'],
            'streets' => $streets,       
            'blockNumber' => $_GET['block'],
            'mapBlocks' => $mapBlocks,
            'mapNumber' => $_GET['map'],
            'blockNumber' => $_GET['block'],
            'errorMessage' => $errorMessage
        )
    );

}

?>
