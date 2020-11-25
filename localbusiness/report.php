<?php
include ("../dbaccess.php");
require '../vendor/autoload.php';
ini_set('display_errors', 1);

$loader = new Twig_Loader_Filesystem('../views');
$twig = new Twig_Environment($loader);
$template = $twig->load('localbusiness/report.html.twig');


date_default_timezone_set('Australia/NSW');


if (isset($_GET['overseer'])) {
	$request = $fm->newFindCommand('Assignees');
	$request->addFindCriterion('overseer', $_GET['overseer']); 
	$result = $request->execute();

	if (FileMaker::isError($result)) {
        $errorMessage = $result->getMessage();
        $foo = 'foo';
        //echo "<p>Error: " . $result->getMessage() . "</p>"; exit;

    } else {


	    $records = $result->getRecords();
	    $assignees = array();
	    foreach($records as $record) {
	        $assignees[] = array(
	            'name' => $record->getField('name'),
	            'tasksCompleted' => $record->getField('tasksCompleted'),
	            'tasks' => $record->getField('tasks')
	        );
	    }

	    // Find a single record
		$record1 = $records[0];
		$totalTasksCompleted = $record1->getField('totalTasksCompleted');
		$totalTasks = $record1->getField('totalTasks');
	
	}   

}
 







echo $template->render(array(
            'errorMessage' => $errorMessage,
            'assignees' => $assignees,
            'totalTasksCompleted' => $totalTasksCompleted,
            'totalTasks' => $totalTasks,
            'overseer' => $_GET['overseer']
        )
    );
?>