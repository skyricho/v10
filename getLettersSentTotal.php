<?php
include ("dbaccess.php"); 
ini_set('display_errors', 1);



//$foo = 'foo';
//echo $foo;

//$value = "Test me more";
//echo strtok($value, " "); // Test

# Get houses contacted 
$request = $fm->newFindCommand('AddressList');
$request->addFindCriterion('modDate', '>=2/27/2021');
$request->addFindCriterion('isHome', 'ah');


$result = $request->execute();
if (FileMaker::isError($result)) {
    $errorMessage = $result->getMessage();
    //$foo = 'foo';
    echo "<p>Error: " . $result->getMessage() . "</p>"; exit;

} else {
    $records = $result->getRecords();
    $houses = count($records);  
}


# Get units contacted 
$request = $fm->newFindCommand('HousingUnits');
$request->addFindCriterion('modDate', '>=2/27/2021');
$request->addFindCriterion('isHome', 'ah');


$result = $request->execute();
if (FileMaker::isError($result)) {
    $errorMessage = $result->getMessage();
    //$foo = 'foo';
    echo "<p>Error: " . $result->getMessage() . "</p>"; exit;

} else {
    $records = $result->getRecords();
    $units = count($records);  
}



$lettersSent =  $houses + $units;
$myfile = fopen("lettersSent.txt", "w") or die("Unable to open file!");
fwrite($myfile, $lettersSent);
fclose($myfile);

//echo "<h3>Memorial Invitation Campaign 2021</h3>";
echo $lettersSent . " letters sent";

?>
