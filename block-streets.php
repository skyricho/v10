<?php
include ("dbaccess.php"); 

# Query available streets
$request = $fm->newFindCommand('BlockStreet');
$request->addFindCriterion('MapBlock::Map', $_GET['Map']);
$request->addFindCriterion('MapBlock::Block', $_GET['Block']); 
$result = $request->execute();
$records = $result->getRecords();

echo '<div class="list-group">';
foreach($records as $record) {
    echo '<a href="index.php?Map=' . $_GET['Map'] . '&Block=' . $_GET['Block'] . '&Street=' . str_replace(' ', '-', $record->getfield('Street')) . '" class="list-group-item list-group-item-action">' . $record->getfield('Street') . '</a>';
}
echo '</div>';
?>