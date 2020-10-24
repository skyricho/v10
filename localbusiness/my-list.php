<?php
include ("../dbaccess.php"); 
require '../vendor/autoload.php';
ini_set('display_errors', 1);

$loader = new Twig_Loader_Filesystem('../views');
$twig = new Twig_Environment($loader);
$template = $twig->load('localbusiness/my-list.html.twig');

$errorMessage ='';
$foo = 'foo';

//$value = "Test me more";
//echo strtok($value, " "); // Test

if (isset($_GET['u'])) {
    //echo $_GET['u'];

    # Query avaible businesses to contact
    $request = $fm->newFindCommand('LocalBusiness');
    $request->addFindCriterion('assignedTo', $_GET['u']);
    //$request->addFindCriterion('block', $_GET['Block']);
    $request->addSortRule('status', 1);
    
    $result = $request->execute();
    if (FileMaker::isError($result)) {
        $errorMessage = $result->getMessage();
        $foo = 'foo';
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
                'phone' => $record->getField('phone'),             
                'formSubmissionUser' => $record->getField('FormSubmissionUser'),
                'assignee' => $record->getField('assignedTo'),
                'status' => $record->getField('status'),                
                'map' => $record->getField('map'),
                'block' => $record->getField('block'),
                //'assigneeDash' => str_replace(' ', '-', $record->getField('assignedTo')),
                'badgeColor' => $record->getField('badgeColor')
                //'assigneeFirstName' => strtok($record->getField('assignedTo'), " ");
            );
        }
    }
}



echo $template->render(array(
        'localbusinesses' => $localbusinesses,       
        'blockNumber' => $_GET['Block'],
        'mapBlocks' => $mapBlocks,
        'mapNumber' => $_GET['Map'],
        'errorMessage' => $errorMessage,
        'foo' => $foo,
        'assignee' => $_GET['u']
    )
);


?>
