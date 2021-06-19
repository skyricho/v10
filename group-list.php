<?php
include ("dbaccess.php"); 
require 'vendor/autoload.php';
ini_set('display_errors', 1);

$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader);
$template = $twig->load('group-list.html.twig');


# Query assignee list
$request = $fm->newFindCommand('group-publishers');
$request->addFindCriterion('overseer', $_GET['overseer']); 
$request->addSortRule('name', 1);
$result = $request->execute();

//$assignees = 'baz';
# Trap for errors
if (FileMaker::isError($result)) {
    $errorMessage = $result->getMessage();
} else {
    $records = $result->getRecords();

    $assignees = array();
    foreach($records as $record) {
        $assignees[] = array(
            'name' => $record->getField('name'),
        );
    }
    /*foreach ($records as $record) {
        echo $record->getField('name') . '<br>';
    }*/
}

# prepare variables for template
echo $template->render(array(
        'assignees' => $assignees,
        'errorMessage' => $errorMessage
    )
);
//print_r($assignees);
//echo 'foo';
?>