<?php
include ("../dbaccess.php"); 

$request = $fm->newFindCommand('Map');
$request->addFindCriterion('Map', $_GET['Map'] ); 
$result = $request->execute();
$records = $result->getRecords();

# get first record ID to populate nav pull downs
foreach($records as $record) {
    $cAH = $record->getField('cAH');
    $phoneContacted = $record->getField('cPhoneContacted');
    $leftVoiceMail = $record->getField('cPhoneLeftVoicemail');
    $contacted = $cAH + $phoneContacted + $leftVoiceMail;
    $noAnswer = $record->getField('cPhoneNoAnswer');
    $disconnected = $record->getField('cPhoneDisconnected');
    $noFurtherAction = $record->getField('cPhoneNoFurtherAction');
    $phoneAddresses = $record->getField('cPhone');
    $toCall = $phoneAddresses - ( $disconnected + $noFurtherAction );
    $assignedTo = $record->getField('MapAssignment::cFirstName') . ' ' . $record->getField('User::Last');
    $mobile = str_replace(" ","",$record->getField('User::Mobile'));
    $MapAssignmentId = $record->getField('mapAssignmentId');
    break; // break loop after first iteration
}

echo '<p>Map assigned to ' . '<a href="sms:' . $mobile . '">' . $assignedTo . '</a><br>
         Contacted: ' . $phoneContacted . '<br>
         Left Voicemail: ' . $leftVoiceMail . '<br>
         No Answer: ' . $noAnswer . '<br>
         Disconnected: ' . $disconnected . '<br>
         No Further Action: ' . $noFurtherAction . 
      '</p>';
?>

  <div id="alert-phone"></div>  

  
    <!--<form ic-post-to="/ah/v10/admin/map.php" ic-confirm="Are you sure?" ic-target="#alert-phone" ic-src="/ah/v10/phone/map-info.php" ic-verb="POST" ic-trigger-on="default" ic-deps="ignore">-->
    <!--<form ic-post-to="/ah/v10/admin/map.php" ic-confirm="Are you sure?" ic-target="#alert-phone">-->  
    <form action="../admin/map.php" method="POST">

    <input type="hidden" name="id" value="<?php echo $MapAssignmentId; ?>">
    <input type="hidden" name="cAH" value="<?php echo $contacted; ?>">
    <input type="hidden" name="Map" value="<?php echo $_GET['Map']; ?>">
    <input class="btn btn-outline-primary btn-block" type="submit" name="unassign-phone-map" value="Hand Map In">
  </form>

  <!--<button ic-post-to="/target_url" ic-confirm="Are you sure?">Click Me!</button>
  <button ic-post-to="/target_url" ic-confirm="Are you sure?" ic-src="/target_url" ic-verb="POST" ic-trigger-on="default" ic-deps="ignore" ic-id="2">Click Me!</button>

    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
  <script src="https://intercoolerreleases-leaddynocom.netdna-ssl.com/intercooler-1.2.1.min.js"></script>-->
   