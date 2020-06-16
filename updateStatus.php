
<?php
include ("dbaccess.php"); 
 
if (isset($_POST['id'])) {
  $edit = $fm->newEditCommand('AddressList', $_POST['id']);
  if (isset($_POST['isHome'])) {
    $edit->setField('isHome', 'ah');
    # Is home form
    echo '<form id="' . $_POST['id'] . '-form">
            <input type="hidden" name="id" value="' . $_POST['id'] . '">
            <input type="hidden" name="notHome" value="">
            <input type="hidden" name="streetNumber" value="' . $_POST['streetNumber'] . '">
            <input type="hidden" name="streetName" value="' . $_POST['streetName'] . '">
            <input type="hidden" name="addressDescription" value="' . $_POST['addressDescription'] . '">
            <div class="d-flex justify-content-between text-muted">
              <div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="{{ address.recID }}-checkbox" ic-post-to="updateStatus.php" ic-target="#' . $_POST['id'] . '" ic-confirm="Are you sure?" checked>
                  <label class="form-check-label text-muted" for="defaultCheck1">' . 
                    $_POST['streetNumber'] . ' ' . $_POST['streetName'] . '
                  </label>
                </div>
              </div>
              <div>
                <i class="fas fa-mail-bulk"></i> Letter sent
              </div>
            </div>';
                # Hide visited date
                //<span id="' . $_POST['id'] . '-visitDate" class="ml-3 badge-pill badge-light"><small><i>' . date("D j M") . '</i></small></span>
    if (empty($_POST['addressDescription'])) {
      echo '';
    } else {
      echo '<div><small class="text-muted">' . $_POST['addressDescription'] . '</small></div>';
    }
    echo '</form>';
    } else {
    $edit->setField('isHome', '');
    # Not home form
    echo '<form id="' . $_POST['id'] . '-form">
            <input type="hidden" name="id" value="' . $_POST['id'] . '">
            <input type="hidden" name="isHome" value="">
            <input type="hidden" name="streetNumber" value="' . $_POST['streetNumber'] . '">
            <input type="hidden" name="streetName" value="' . $_POST['streetName'] . '">
            <input type="hidden" name="addressDescription" value="' . $_POST['addressDescription'] . '">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="{{ address.recID }}-checkbox" ic-post-to="updateStatus.php" ic-target="#' . $_POST['id'] . '">
              <label class="form-check-label" for="defaultCheck1">
                ' . $_POST['streetNumber'] . ' ' . $_POST['streetName'];
    if (empty($_POST['addressDescription'])) {
      echo '';
    } else {
      echo '</br><small class="text-muted">' . $_POST['addressDescription'] . '</small>';
    }
    echo     '</label>
            </div>
          </form>';
  }
  $edit->execute();
}

?>