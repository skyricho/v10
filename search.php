<?php
include ("dbaccess.php"); 


if (isset($_GET['search'])) {
    $request = $fm->newFindCommand('User');
    $request->addFindCriterion('firstLast', $_GET['search']);
    $result = $request->execute();
    $records = $result->getRecords();

    foreach($records as $record) {
        echo '<form class="form-group" id="form-' . $_GET['recID'] . '" ic-post-to="assign-map.php" ic-target="#assign-map-' . $_GET['recID'] . '">
                <input type="hidden" name="recID" value="' . $_GET['recID'] . '">
                <input type="hidden" name="userID" value="' . $record->getField('userID') . '">
                <p class="mt-2">' . $record->getField('firstLast') . '<span>
                <button type="submit" class="btn btn-primary btn-sm">Assign Map</button></span></p>
              </form>';
    }

}

# Non AJAX form
/*echo '<form action="assign-map.php" method="post" id="form-' . $record->getField('userID') . '">
                <input type="hidden" name="recID" value="' . $_GET['recID'] . '">
                <input type="hidden" name="userID" value="' . $record->getField('userID') . '">'
                . $record->getField('firstLast') . 
                '<input type="submit" value="Assign Map">
              </form>';
    }*/
?>