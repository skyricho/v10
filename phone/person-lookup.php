<?php
// Include the library
include('simple_html_dom.php');
 
if (isset($_GET['q'])) {
    $url = 'https://personlookup.com.au/search?utf8=✓&search=true&page=1&country_id=1&q=' . str_replace(" ","+",$_GET['q']) . '&state_id=5';
	//echo $_GET['q'] . ' ' . $url;
	// Retrieve the DOM from a given URL
	$html = file_get_html($url);

	//echo $html;
	$response = $html->find('h4', 1)->plaintext;
	//echo $response;
	if ($response == 'No results ') {
		echo $response . '<br>';
	} else {
		$rows = count($html->find('table', 0)->children());
		$x = 1; 

		while($x < $rows) {
		  $t = $html->find('table', 0)->children($x)->last_child()->plaintext;
		  //echo  $t . '<br>';
		  echo '<a href="tel:' . $t . '">' . $t . '</a><br>';
		  $x++;
		}

	}

    echo '<br><a href="' . $url . '">Source</a>';

} else {
    echo 'No address provided';
}

?>