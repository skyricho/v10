<?php
include ("../dbaccess.php");
require '../vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('../views');
$twig = new Twig_Environment($loader);
$template = $twig->load('admin/users.html.twig');

$request = $fm->newFindAllCommand('User');
$result = $request->execute();

$records = $result->getRecords();
$users = array();
foreach($records as $record) {
    $users[] = array(
        'id' => $record->getField('userID'),
        'first' => $record->getField('First'),
        'last' => $record->getField('Last'),
    );
}

echo $template->render(array(
    'users' => $users,
    'foo' => 'foo',
        )
    );
?>
