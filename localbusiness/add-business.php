<?php
include ("../dbaccess.php");
require '../vendor/autoload.php';
ini_set('display_errors', 1);

$loader = new Twig_Loader_Filesystem('../views');
$twig = new Twig_Environment($loader);
$template = $twig->load('localbusiness/add-business.twig');

if (isset($_POST['addLocalBusiness'])) {
    $request = $fm->createRecord('LocalBusiness');
    $request->setField('map', $_POST['map']);
    $request->setField('block', $_POST['block']);
    $request->setField('businessName', $_POST['businessName']);
    $request->setField('streetAddressRaw', $_POST['address']);
    $request->setField('contactName', $_POST['contactName']);
    $request->setField('contactPosition', $_POST['contactPosition']);
    $request->setField('contactEmail', $_POST['contactEmail']);
    $request->setField('FormSubmissionUser', $_POST['FormSubmissionUser']);
    $result=$request->commit();

    $errorMessage = 'Business added. Add another...';
    $user = $_POST['FormSubmissionUser'];


# prepare variables for template
echo $template->render(array(
    'errorMessage' => $errorMessage,
    'user' => $user,
    //'localbusinesses' => $localbusinesses
    )
);

} elseif (isset($_POST['update'])) {
    # prepare variables for template
echo $template->render(array(
    'errorMessage' => $errorMessage,
    'user' => $user,
    'response' => 'Saved.'
    //'localbusinesses' => $localbusinesses
    )
);
}

?>
