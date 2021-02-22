<?php
include ("dbaccess.php"); 
require 'vendor/autoload.php';
ini_set('display_errors', 1);

$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader);
$template = $twig->load('my-list.html.twig');

$errorMessage ='';
$foo = 'foo';

//$value = "Test me more";
//echo strtok($value, " "); // Test

if (isset($_GET['name'])) {
    //echo $_GET['name'];

    # Get assigned addressws
    $request = $fm->newFindCommand('AddressList');
    $request->addFindCriterion('assignee', $_GET['name']);
    //$request->addFindCriterion('block', $_GET['Block']);
    $request->addSortRule('cStatus', 1);
    
    $result = $request->execute();
    if (FileMaker::isError($result)) {
        $errorMessage = $result->getMessage();
        $foo = 'foo';
        //echo "<p>Error: " . $result->getMessage() . "</p>"; exit;

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
}



echo $template->render(array(
        'addresses' => $addresses,
        'errorMessage' => $errorMessage,
        'foo' => $foo,
        'assignee' => $_GET['name']
    )
);


?>
