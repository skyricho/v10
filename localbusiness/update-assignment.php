<?php
include ("../dbaccess.php");
ini_set('display_errors', 1);

//if (isset($_POST['id'])) {
    $edit = $fm->newEditCommand('LocalBusiness', $_POST['id']);
    $edit->setField('assignedTo', $_POST['assignedTo']);
    $edit->execute();

    if (empty($_POST['assignedTo'])) {
    	$color = 'LightGrey';
    } else {
    	$color = 'Yellow';
    }

$assignedToSafe = str_replace(' ', '%20', $_POST['assignedTo']);

//}

?>

<div class="d-flex w-100 justify-content-between">
  <div >
 <h5 class="mb-1" id="foo-<?php echo $_POST['id'] ?>"><span style="font-size: 1em; color: <?php echo $color ?>;"><i class="fas fa-check-circle"></i></span> <?php echo $_POST['businessName']?></h5>
  </div>
</div>

          <form class="form-inline" ic-post-to="update-assignment.php" ic-target="#foo-<?php echo $_POST['id'] ?>">
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