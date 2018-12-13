<?php
include ("dbaccess.php"); 

$request = $fm->newFindCommand('Map');
$request->addFindCriterion('Map', $_GET['Map'] ); 
$result = $request->execute();
$records = $result->getRecords();

# get first record ID to populate nav pull downs
foreach($records as $record) {
    $Coverage = $record->getField('coverage');
    $Contacted = $record->getField('cAH');
    $Addresses = $record->getField('cAH') + $record->getField('cNH');
    $assignedTo = $record->getField('MapAssignment::cFirstName') . ' ' . $record->getField('User::Last');
    $mobile = str_replace(" ","",$record->getField('User::Mobile'));
    $MapAssignmentId = $record->getField('mapAssignmentId');
  break; // break loop after first iteration
}

echo '<p>Coverage <span class="badge badge-primary">' . $Coverage . '%</span> (' . $Contacted . ' of ' . $Addresses . ' addresses)<br>Map assigned to ' . '<a href="sms:' . $mobile . '">' . $assignedTo . '</p></a>';
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