<?php
include ("../dbaccess.php");
require '../vendor/autoload.php';
ini_set('display_errors', 1);

$loader = new Twig_Loader_Filesystem('../views');
$twig = new Twig_Environment($loader);
$template = $twig->load('localbusiness/assign-business.twig');


if (isset($_POST['id'])) {
    $edit = $fm->newEditCommand('LocalBusiness', $_POST['id']);
    $edit->setField('assignedTo', $_POST['assignedTo']);
    $edit->execute();

    $foo = 'huzzah' . $_POST['id'];
}

# prepare variables for template
echo $template->render(array(
    //'errorMessage' => $errorMessage,
    //'map' => $_GET['map'],
    'foo' => $foo,
    //'localbusinesses' => $localbusinesses
    )
);


?>