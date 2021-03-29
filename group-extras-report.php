<?php
include ("dbaccess.php"); 
ini_set('display_errors', 1);



//$foo = 'foo';
//echo $foo;

//$value = "Test me more";
//echo strtok($value, " "); // Test
echo "<h3>Group Extras Report</h3>";
# Get houses contacted 
$request = $fm->newFindCommand('Memorial-2021');
$request->addFindCriterion('assignee', 1);
$request->addFindCriterion('isHome', '==');
$request->addFindCriterion('isSingleDwelling', '1');


$result = $request->execute();
if (FileMaker::isError($result)) {
    $errorMessage = $result->getMessage();
    //$foo = 'foo';
    echo "<p>Error: " . $result->getMessage() . "</p>"; exit;

} else {
    $records = $result->getRecords();
    $houses= count($records);  
}
//echo $houses . "<br>";

# Get units contacted 
$request = $fm->newFindCommand('HousingUnits');
$request->addFindCriterion('StreetNumber::assignee', '1');
$request->addFindCriterion('isHome', '==');


$result = $request->execute();
if (FileMaker::isError($result)) {
    $errorMessage = $result->getMessage();
    //$foo = 'foo';
    echo "<p>Error: " . $result->getMessage() . "</p>"; exit;

} else {
    $records = $result->getRecords();
    $units = count($records);  
}
//echo $units . "<br>";
$g1 = $houses + $units;
echo "Group 1: " . $g1 . "<br>";


# Get houses contacted 
$request = $fm->newFindCommand('Memorial-2021');
$request->addFindCriterion('assignee', 2);
$request->addFindCriterion('isHome', '==');
$request->addFindCriterion('isSingleDwelling', '1');


$result = $request->execute();
if (FileMaker::isError($result)) {
    $errorMessage = $result->getMessage();
    //$foo = 'foo';
    echo "<p>Error: " . $result->getMessage() . "</p>"; exit;

} else {
    $records = $result->getRecords();
    $houses2= count($records);  
}
//echo $houses . "<br>";

# Get units contacted 
$request = $fm->newFindCommand('HousingUnits');
$request->addFindCriterion('StreetNumber::assignee', '2');
$request->addFindCriterion('isHome', '==');


$result = $request->execute();
if (FileMaker::isError($result)) {
    $errorMessage = $result->getMessage();
    //$foo = 'foo';
    echo "<p>Error: " . $result->getMessage() . "</p>"; exit;

} else {
    $records = $result->getRecords();
    $units2 = count($records);  
}
//echo $units . "<br>";
$g2 = $houses2 + $units2;
echo "Group 2: " . $g2 . "<br>";

# Get houses contacted 
$request = $fm->newFindCommand('Memorial-2021');
$request->addFindCriterion('assignee', 3);
$request->addFindCriterion('isHome', '==');
$request->addFindCriterion('isSingleDwelling', '1');


$result = $request->execute();
if (FileMaker::isError($result)) {
    $errorMessage = $result->getMessage();
    //$foo = 'foo';
    echo "<p>Error: " . $result->getMessage() . "</p>"; exit;

} else {
    $records = $result->getRecords();
    $houses3= count($records);  
}
//echo $houses . "<br>";

# Get units contacted 
$request = $fm->newFindCommand('HousingUnits');
$request->addFindCriterion('StreetNumber::assignee', '3');
$request->addFindCriterion('isHome', '==');


$result = $request->execute();
if (FileMaker::isError($result)) {
    $errorMessage = $result->getMessage();
    //$foo = 'foo';
    echo "<p>Error: " . $result->getMessage() . "</p>"; exit;

} else {
    $records = $result->getRecords();
    $units3 = count($records);  
}
//echo $units . "<br>";
$g3 = $houses3 + $units3;
echo "Group 3: " . $g3 . "<br>";

# Get houses contacted 
$request = $fm->newFindCommand('Memorial-2021');
$request->addFindCriterion('assignee', '4');
$request->addFindCriterion('isHome', '==');
$request->addFindCriterion('isSingleDwelling', '1');


$result = $request->execute();
if (FileMaker::isError($result)) {
    $errorMessage = $result->getMessage();
    //$foo = 'foo';
    echo "<p>Error: " . $result->getMessage() . "</p>";

} else {
    $records = $result->getRecords();
    $houses4= count($records);  
}
//echo $houses . "<br>";

# Get units contacted 
$request = $fm->newFindCommand('HousingUnits');
$request->addFindCriterion('StreetNumber::assignee', '4');
$request->addFindCriterion('isHome', '==');


$result = $request->execute();
if (FileMaker::isError($result)) {
    $errorMessage = $result->getMessage();
    //$foo = 'foo';
    echo "<p>Error: " . $result->getMessage() . "</p>"; exit;

} else {
    $records = $result->getRecords();
    $units4 = count($records);  
}
//echo $units . "<br>";
$g4 = $houses4 + $units4;
echo "Group 4: " . $g4 . "<br>";
echo "<br><br>";
echo "NOTE: The number refers to how many addresses are still to be contacted.<br>"
?>
