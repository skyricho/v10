
<?php 
include ("dbaccess.php"); 
?>
         
<?php 
# Check the POST name to see if the user clicked the Not Home button.
if (isset($_POST['id'])) {
  # and $_POST['save'] == 'Not Home') {
  # Tell FileMaker to edit the record.
  # Before the data is sent back to the database you can validate it here. No examples of validation are shown in the example.
  # Please see the demo for InsertRecordValidation.php
  # This is just a straight forward insert demo.
  $edit = $fm->newEditCommand('AddressList', $_POST['id']);
  # Set the fields with the values from the $_POST superglobal
  $edit->setField('isHome', $_POST['isHome']);
  #$edit->setField('Date', $_POST['Date']);
  #$edit->setField('Date', $_POST(Date("d/m/Y"));
  //Date and TimeStamp are disabled in the POST, no need to update the values
  //$edit->setField('Date', $_POST['Date']);
  //$edit->setField('TimeStamp', $_POST['TimeStamp']);
  # Execute the newEditCommand
  $edit->execute();

}

# Get updated record to update the list item
$record = $fm->getRecordByID("AddressList", $_POST["id"]);
# Format result according to record status
  #echo $_POST['Filter'];
  if ($record->getField('isHome') == 'ah') {
    if ($_POST['Filter'] == 'Contacted') {
      echo '';
    } else {
      $date = strtotime( $record->getField('modDate') );
      $newformat = date('D d M',$date);
      # Update the message variable to tell the user the record has been saved.
      echo '<a data-toggle="collapse" href="#revert-' . $record->getField('recID') . '" role="button" aria-expanded="false" aria-controls="revert-' . $record->getField('recID') . '">
          ' . $record->getField('cNumberStreetLabel') . '
          </a>
    <div class="float-right"><!--<small><i>At home ' . $newformat . '</i></small>-->
      <div class="collapse" id="revert-' . $record->getField('recID') .'">
        <button onclick="updateAtHome(' . $record->getField('recID') . ',)" id="' . $record->getField('recID') . '" class="btn btn-outline-primary btn-sm">Clear at home date</button>
      </div>
    </div>';
     }
  } else {
      echo $record->getField('cNumberStreetLabel') . '
      <div id="at-home-' . $record->getField('recID') .'" class="float-right">
        <button onclick="updateAtHome(' . $record->getField('recID') . ', \'\', true)" id="' . $record->getField('recID') . '" class="btn btn-outline-primary btn-sm">At Home</button>  
      </div>';
  }
?>