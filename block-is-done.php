<?php
include ("dbaccess.php");
ini_set('display_errors', 1);


if (isset($_POST['recID'])) {
	$request = $fm->newEditCommand('updateMapBlock', $_POST['recID']);
	$request->setField('isDone', 'yes');
	$request->execute();

    $record = $fm->getRecordByID('updateMapBlock', $_POST['recID']);
	echo 'Block ' . $record->getField('Block') . ' is done.';
}

?>


<form action="block-is-done.php" method="post">
	<input type="hidden" name="recID" value="11">
    <input type ="checkbox" name="isDone" value="yes" onchange="this.form.submit()"
    >Block 3</input>
    <noscript><input type="submit" name="submit" value="submit" /></noscript>
</form>

