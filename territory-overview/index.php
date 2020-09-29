<?php
include ("dbaccess.php"); 
require '../vendor/autoload.php';
//ini_set('display_errors', 1);

$loader = new Twig_Loader_Filesystem('../views');
$twig = new Twig_Environment($loader);
$template = $twig->load('territory-overview/index.html.twig');


echo $template->render(array(
    //'availableMaps' => $availableMaps,
    //'errorMessage' => $errorMessage
    )
);


?>
