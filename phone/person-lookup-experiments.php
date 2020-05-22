<?php
// Include the library
include('simple_html_dom.php');
 
// Retrieve the DOM from a given URL
$html = file_get_html('https://personlookup.com.au/search?utf8=✓&search=true&page=1&country_id=1&q=lawn+ave+lane+cove+west&state_id=5');

$tel = $html->find('table', 0)->children(1)->children(2)->plaintext;
echo '<h3>Make phone number clickable (row 1)</h3>';
echo '<a href="tel:' . str_replace(" ","",$tel) . '">' . $tel . '</a><br><hr>';

echo '<h3>Response</h3>';
$response = $html->find('h4', 1)->plaintext;
echo $response .  '<br><hr>';

// Find all <td> in <table> which class=hello 
//$es = $html->find('table.table td');
echo '<h3>Raw table</h3>';
$rows = count($html->find('table', 0)->children());
//echo 'Rows: ' . $rows . '<br>';

$x = 1; 

while($x < $rows) {
  $t = $html->find('table', 0)->children($x)->last_child();
  //echo  $t . '<br>';
  echo '<a href="tel:' . str_replace(" ","",$t) . '">' . $t . '</a><br>';
  $x++;
}

echo '<br><br><a href="https://personlookup.com.au/search?utf8=✓&search=true&page=1&country_id=1&q=lawn+ave+lane+cove+west&state_id=5">Source</a>';


//$t = $html->find('table', 0)->children(1)->last_child();
//echo $t;
//foreach($html->find('table', 0)->children() as $element) {
//    echo $element;
//}

echo '<br><hr>';

echo '<h3>Row 1</h3>';
echo 'Name: ' . $html->find('table', 0)->children(1)->first_child() . '<br>';
echo 'Telephone: ' . $html->find('table', 0)->children(1)->children(2) . '<br><hr>';


// Get phone number
foreach($html->find('table td') as $element) {
       echo $element . '<br>';
}

// Get Table
foreach($html->find('table') as $element) {
       echo $element . '<br>';
}

// This results in an array
//$t = $html->find('table');
//echo $t;

//print_r($es);

//echo $html;

?>
