<?php
//include ("dbaccess.php"); 
require '../vendor/autoload.php';
ini_set('display_errors', 1);

$loader = new Twig_Loader_Filesystem('../views');
$twig = new Twig_Environment($loader);
$template = $twig->load('addressing-guide/index.html.twig');

# Render vars for template
echo $template->render(array(
    'foo' => 'foo',
    )
);

?>