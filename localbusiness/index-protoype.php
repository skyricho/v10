<?php
include ("../dbaccess.php");
require '../vendor/autoload.php';
ini_set('display_errors', 1);

$loader = new Twig_Loader_Filesystem('../views');
$twig = new Twig_Environment($loader);
$template = $twig->load('localbusiness/index.html.twig');

// /localbusiness/?u=foo
if (isset($_GET['u'])) {

    # Query avaible buinsesses to contact
    $request = $fm->newFindCommand('LocalBusiness');
    $request->addFindCriterion('assignedTo', $_GET['u']); 
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
                'status' => $record->getField('status')
            );
        }
    }


} else {

    echo 'foo';

}

# prepare variables for template
echo $template->render(array(
    'errorMessage' => $errorMessage,
    'user' => $_GET['u'],
    'localbusinesses' => $localbusinesses
    )
);


?>
