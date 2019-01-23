<?php
include ("../dbaccess.php"); 
require '../vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('../views');
$twig = new Twig_Environment($loader);
$template = $twig->load('admin/address-change-log.html.twig');


if ($_GET['Filter'] == 'reviewed') {
    $request = $fm->newFindCommand('AddressChange');
    $request->addFindCriterion('approveDate', '*'); 
    $result = $request->execute();

    // Trap for errors
    if (FileMaker::isError($result)) {
        echo "<p>Error: " . $result->getMessage() . "</p>"; exit;
    }
 
} elseif ($_GET['Filter'] == 'pending') {
    $request = $fm->newFindCommand('AddressChange');
    $request->addFindCriterion('approveDate', '=='); 
    $result = $request->execute();

    // Trap for errors
    if (FileMaker::isError($result)) {
        echo "<p>Error: " . $result->getMessage() . "</p>"; exit;
    }

} else {
    $request = $fm->newFindAllCommand('AddressChange');
    $result = $request->execute();

}

$records = $result->getRecords();
$changeRequests = array();
foreach($records as $record) {
    $changeRequests[] = array(
        'id' => $record->getField('id'),
        'streetNumber' => $record->getField('streetNumber'),
        'streetName' => $record->getField('streetName'),
        'status' => $record->getField('cStatus'),
        'date' => $record->getField('date'),
        'firstName' => $record->getField('userName'),
        'action' => $record->getField('action'),
        'map' => $record->getField('map'),
        'block' => $record->getField('block'),
        'note' => $record->getField('note'),
        'approveDate' => $record->getField('approveDate'),
    );
}

# Render vars for template
echo $template->render(array(
    'filter' => $Filter,
    'changeRequests' => $changeRequests,
    )
);

?>
