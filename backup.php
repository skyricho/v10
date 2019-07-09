<?php
include ("dbaccess.php"); 
ini_set('display_errors', 1);

//CREATE PERFORM SCRIPT COMMAND
$command = $fm->newPerformScriptCommand('Mapblock', 'Backup via PHP');
 
//EXECUTE THE COMMAND
$foo = $command->execute();

# Query all addresses for map 2
$request = $fm->newFindCommand('MapBlock');
$request->addFindCriterion('Map::mapAssignmentId', '*' ); 
$request->addSortRule('Map', 1);
$request->addSortRule('Block', 1);
$result = $request->execute();


# Trap for errors
if (FileMaker::isError($result)) {
    $errorMessage = $result->getMessage();
    echo $errorMessage;
} else {
    $records = $result->getRecords();
    foreach($records as $record) {
        //echo $record->getField('backupTextDump') . '<hr>';
        //echo $record->getField('Map');
        file_put_contents( 'backup/Map ' . $record->getField('Map') . ' Block ' . $record->getField('Block') . '.txt',  $record->getField('backupTextDump'));
    }
}
//file_put_contents('foo.txt', 'foo');
echo 'Script executed on Server and text files saved to disk.';
?>
