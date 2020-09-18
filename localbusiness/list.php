<?php
include ("../dbaccess.php");
require '../vendor/autoload.php';
ini_set('display_errors', 1);

$loader = new Twig_Loader_Filesystem('../views');
$twig = new Twig_Environment($loader);
$template = $twig->load('localbusiness/assign-business.twig');

// /localbusiness/?map=foo
if (isset($_GET['map'])) {

    # Query avaible buinsesses to contact
    $request = $fm->newFindCommand('LocalBusiness');
    $request->addFindCriterion('map', $_GET['map']); 
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
                'assignee' => $record->getField('assignedTo'),
                //'assigneeDash' => str_replace(' ', '-', $record->getField('assignedTo')),
                'badgeColor' => $record->getField('badgeColor')
            );
        }
    }


} else {

    $localbusinesses = "Select a map number";

}

# prepare variables for template
echo $template->render(array(
    'errorMessage' => $errorMessage,
    'map' => $_GET['map'],
    'localbusinesses' => $localbusinesses
    )
);


?>

