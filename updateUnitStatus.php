
<?php
include ("dbaccess.php"); 
 
if (isset($_POST['id'])) {
  $edit = $fm->newEditCommand('updateHousingUnit', $_POST['id']);
  if (isset($_POST['isHome'])) {
    $edit->setField('isHome', 'ah');
    # Is home form
    echo '<form id="' . $_POST['id'] . '-form">
            <input type="hidden" name="id" value="' . $_POST['id']. '">
            <input type="hidden" name="notHome" value="">
            <input type="hidden" name="streetNumber" value="' . $_POST['streetNumber'] . '">
            <input type="hidden" name="housingUnitNumber" value="' . $_POST['housingUnitNumber'] . '">

            <div class="d-flex justify-content-between text-muted">
              <div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="' . $_POST['id'] . '-checkbox" ic-post-to="updateUnitStatus.php" ic-target="#' . $_POST['streetNumber'] . '-unit-' . $_POST['id'] . '" ic-confirm="Are you sure?" checked>
                  <label class="form-check-label" for="defaultCheck1">' .
                    'Unit ' . $_POST['housingUnitNumber'] . '
                  </label>
                </div>
              </div>
              <div>
                <i class="fas fa-mail-bulk"></i> Letter sent
              </div>
            </div>     
          </form>';

          
  } else {
    $edit->setField('isHome', '');
    # Not home form
    echo '<form id="' . $_POST['id'] . '-form">
            <input type="hidden" name="id" value="' . $_POST['id'] . '">
            <input type="hidden" name="isHome" value="">
            <input type="hidden" name="streetNumber" value="' . $_POST['streetNumber'] . '">
            <input type="hidden" name="housingUnitNumber" value="' . $_POST['housingUnitNumber'] . '">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="' . $_POST['id'] . '-checkbox" ic-post-to="updateUnitStatus.php" ic-target="#' . $_POST['streetNumber'] . '-unit-' . $_POST['id'] . '">
              <label class="form-check-label" for="defaultCheck1">' . 
                'Unit ' . $_POST['housingUnitNumber'] . '
              </label>
            </div>
          </form>';
  }
  $edit->execute();
}

?>