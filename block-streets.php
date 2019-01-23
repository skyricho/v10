<?php
include ("dbaccess.php"); 

# Query available streets
$request = $fm->newFindCommand('BlockStreet');
$request->addFindCriterion('MapBlock::Map', $_GET['Map']);
$request->addFindCriterion('MapBlock::Block', $_GET['Block']); 
$result = $request->execute();
$records = $result->getRecords();

echo '<ul class="list-group">';
foreach($records as $record) {
    echo '<li class="list-group-item"><a href="index.php?Map=' . $_GET['Map'] . '&Block=' . $_GET['Block'] . '&Street=' . str_replace(' ', '-', $record->getfield('Street')) . '">' . $record->getfield('Street') . '</a></li>';
}
echo '</ul>';
?>