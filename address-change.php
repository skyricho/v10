<?php
include ("dbaccess.php"); 
require 'vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader);
$template = $twig->load('address-change.html.twig');

echo $template->render(array(
        'foo' => 'foo',
    )
);

?>