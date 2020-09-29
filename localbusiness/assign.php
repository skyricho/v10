<?php
include ("../dbaccess.php");
ini_set('display_errors', 1);

$edit = $fm->newEditCommand('LocalBusiness', $_POST['id']);
$edit->setField('assignedTo', $_POST['assignedTo']);
$edit->execute();

$assignedToSafe = str_replace(' ', '%20', $_POST['assignedTo']);


?>



  <form class="form-inline" ic-post-to="assign.php" ic-target="#assign-<?php echo $_POST['id'] ?>">
	<div class="input-group mb-3">
	  <input type="hidden" name="id" value="<?php echo $_POST['id'] ?>">
	  <input type="hidden" name="businessName" value="<?php echo $_POST['businessName']?>">
	  <input type="text" class="form-control" name="assignedTo" value="<?php echo $_POST['assignedTo'] ?>" placeholder="Enter name" aria-label="Enter name" aria-describedby="basic-addon2"> 
	  <div class="input-group-append">
	    <button class="btn btn-outline-secondary">Save</button>
	    <button class="btn btn-outline-secondary btnn" data-clipboard-text="https://qc.r2labs.com/ah/v10/localbusiness/?u=<?php echo $assignedToSafe ?>"><i class="fa fa-copy" aria-hidden="true"></i></button>
	  </div>   
	</div>
  </form>
  <small>Saved</small>