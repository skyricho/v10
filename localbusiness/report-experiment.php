<?php
include ("../dbaccess.php"); 
ini_set('display_errors', 1);

echo 'hello<br>';

date_default_timezone_set('Australia/NSW');
//date_default_timezone_set('Asia/Kolkata');
 
//$request = $fm->newFindAllCommand('Assignees');
$request = $fm->newFindCommand('Assignees');
$request->addFindCriterion('overseer', 'Nick'); 
$result1 = $request->execute();

//$result1 = $request->execute();

$records = $result1->getRecords();
    foreach($records as $record) {
        echo $record->getField('name') . '<br>';
}

// Find a single record
$record1 = $records[0];
//print_r($record1);
echo '<hr>' . $record1->getField('name') . ': ' . $record1->getField('gReport') . '<br><hr><hr>';
echo 'Campaign Report for ' .  date("l jS \of F") . "<br>";
echo $record1->getField('totalTasksCompleted') . ' of ' . $record1->getField('totalTasks') . ' businesses contacted.<br>';
$records = $result1->getRecords();
    foreach($records as $record) {
        echo $record->getField('name') . ' ' . $record->getField('tasksCompleted') . '/' . $record->getField('tasks') . '<br>';
}

?>