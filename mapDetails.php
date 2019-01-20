<?php
include ("dbaccess.php"); 
ini_set('display_errors', 1);

$request = $fm->newFindCommand('Map');
$request->addFindCriterion('Map', $_GET['Map'] ); 
$result = $request->execute();
$records = $result->getRecords();

# get first record ID to populate nav pull downs
foreach($records as $record) {
    $Coverage = $record->getField('coverage');
    $SingleDwelling = $record->getField('cSingleDwellingCount');
    $SingleDwellingAH = $record->getField('cSingleDwellingAH');
    $MultiDwelling = $record->getField('cMultiDwellingCount');
    $MultiDwellingAH = $record->getField('cMultiDwellingCountAH');
    $DNC = $record->getField('cDNCcount');
    $Contacted = $record->getField('contactedTotal') - $record->getField('MapAssignment::startContacted');//deprecate
    $Addresses = $record->getField('nhTotal');//deprecate
    $assignedTo = $record->getField('MapAssignment::cFirstName') . ' ' . $record->getField('User::Last');
    $mobile = str_replace(" ","",$record->getField('User::Mobile'));
    $MapAssignmentId = $record->getField('mapAssignmentId');
  break; // break loop after first iteration
}



echo '<div class="card my-3">
        <div class="card-body">
        <h5>Coverage <span class="badge badge-primary">' . $Coverage . '%</span></h6>
          <ul class="list-unstyled">
            <li>Houses: ' . $SingleDwellingAH . ' of ' . $SingleDwelling . '</li>
            <li>Units: ' . $MultiDwellingAH . ' of ' . $MultiDwelling . '</li>';

if ( $DNC > 0) {
  echo '<li>DNCs: ' . $DNC . '</li>';
}
echo     '</ul>
          <p>Map assigned to <a href="sms:' . $mobile . '">' . $assignedTo . '</a></p>
        </div>
      </div>'; 
?>

<?php
# Query available blocks
$request = $fm->newFindCommand('updateMapBlock');
$request->addFindCriterion('Map', $_GET['Map']); 
$result = $request->execute();
$records = $result->getRecords();

echo '<div class="card my-3">
        <div class="card-body">
          <div id="response"></div>';
foreach($records as $record) {  
    echo '<div class="form-check">';
    if ($record->getField('isDone') === 'yes') {
      //echo $record->getField('isDone');
      //echo '<input id="checkbox-' . $record->getField('recID') . '" type="checkbox" name="isDone" value="no" checked>';
      echo '<input type="checkbox" class="form-check-input" ic-post-to="block-is-done.php?recID=' . $record->getField('recID') . '" ic-target="#response"  name="isDone" value="no" checked>';
    } else {
      //echo 'qux';
      echo '<input type="checkbox" class="form-check-input" ic-post-to="block-is-done.php?recID=' . $record->getField('recID') . '" ic-target="#response"  name="isDone" value="yes">';
    }
      echo '<label class="form-check-label">Block ' . $record->getField('Block') . '</label>
        </div>';
           //<input class="btn btn-outline-primary btn-block" type="submit" name="foo" value="bar">
          //echo '</form>';
}   
echo '</div>
    </div> 
    <div ic-get-from="map-history.php?Map=' . $_GET['Map'] . '" ic-trigger-on="load">
      <i class="fa fa-spinner fa-spin fa-2x"></i> Loading map history...
    </div>';
?>

<div id="alert"></div> 

<form ic-post-to="admin/map.php" ic-confirm="Are you sure?" ic-target="#alert">
    <!--<form action="admin/map.php" method="POST">-->

   <input type="hidden" name="id" value="<?php echo $MapAssignmentId; ?>">
    <input type="hidden" name="cAH" value="<?php echo $Contacted; ?>">
    <input type="hidden" name="Map" value="<?php echo $_GET['Map']; ?>">
    <input class="btn btn-outline-primary btn-block" type="submit" name="unassign" value="Hand Map In">
  </form>

<!-- Modal -->
<!--<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Hand map in</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary">Confirm</button>
      </div>
    </div>
  </div>
</div>

<div id="confirm-me" class="btn btn-primary" ic-post-to="/click" ic-trigger-on="confirmed-by-user">
            Click Me
            <i class="ic-indicator fa fa-spinner fa-spin" style="display: none;"></i>
          </div>-->

          <script>
            $(function () {
              $('#confirm-me').click(function () {
                BootstrapDialog.show(
                  {
                    message: 'Are you sure you want to proceed?',
                    buttons: [
                      {
                        label: 'Confirm',
                        cssClass: 'btn-primary',
                        action: function (dialogItself) {
                          dialogItself.close();
                          $('#confirm-me').trigger('confirmed-by-user'); // this lines up with the ic-trigger name on the element
                        }
                      },
                      {
                        icon: 'glyphicon glyphicon-ban-circle',
                        label: 'Cancel',
                        cssClass: 'btn-warning',
                        action: function (dialogItself) {
                          dialogItself.close();
                        }
                      }]
                  });
              })
            });

            $.mockjax({
              url: "/click",
              responseTime: 1500,
              response: function (settings) {
                this.responseText = "Confirmed Click!";
              }
            });
          </script>

          <script src="/js/bootstrap-dialog.js"></script>