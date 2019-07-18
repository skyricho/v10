<?php
ini_set('display_errors', 1);
include ("../dbaccess.php");

if (isset($_POST['Map'])) {
	$layout = 'AddressList';
	$script = 'Reset At Homes';
	$parameter = $_POST['Map'];
	$request = $fm->newPerformScriptCommand($layout, $script, $parameter); 

    $result = $request->execute();
    // Trap for errors and supply an updated message based on the results returned from FileMaker Server. If no records are found it will throw an error. Therefore, you can update the message to let the user know that their email address does not exist. Otherwise, you can let them know to check their email for their password.
	if (FileMaker::isError($result)) {
	    //$message .= 'The email address you entered does not exist' . '<p>';
	    echo $result;

	} else {
	   //$message .= 'Your password will be sent to your email address shortly.' . '<p>'; }
		echo '<div class="alert alert-success alert-dismissible fade show mt-2" role="alert" id="alert-foo">
		        Map ' . $_POST['Map'] . ' has been reset.
		        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
	            </button>
		      </div>';

	}
}

?>