<?php
include ("../dbaccess.php"); 

# Check the POST recID and assign action.
if (isset($_POST['id'])) {
    $edit = $fm->newEditCommand('LocalBusiness', $_POST['id']);
    $edit->setField('status', $_POST['status']);
    $edit->execute();


} else {
    echo 'Houston we have a problem'; 
}

    # Render updated record
//$record = $fm->getRecordByID('LocalBusiness', $_POST['id']);

//echo '<span class="badge badge-secondary">' . $record->getField('status') . '</span>';

//echo  $_POST['id'] . ' ' . $_POST['status'];
//$schmeg = 'foo';
?>



<form class="form-inline" ic-post-to="status.php" ic-target="#status-<?php echo $_POST['id'] ?>">
  <input type="hidden" name="id" value="<?php echo $_POST['id'] ?>">
  <div class="input-group mb-3">
    <select class="custom-select" id="inputGroupSelect02" name="status">
      <option selected><?php echo $_POST['status'] ?></option>
      <option value="Letter sent">Letter sent</option>
      <option value="Email sent">Email sent</option>
      <option value="">Reset</option>
    </select>
    <div class="input-group-append">
      <button class="btn btn-outline-secondary">Save</button>
    </div>   
  </div>
</form>
<small>Saved.</small>
