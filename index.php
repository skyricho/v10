<?php
include ("dbaccess.php"); 
require 'vendor/autoload.php';
//ini_set('display_errors', 1);

$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader);
$template = $twig->load('index.html.twig');


//get the last-modified-date of this very file
$lastModified=filemtime(__FILE__);
//get a unique hash of this file (etag)
$etagFile = md5_file(__FILE__);
//get the HTTP_IF_MODIFIED_SINCE header if set
$ifModifiedSince=(isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ? $_SERVER['HTTP_IF_MODIFIED_SINCE'] : false);
//get the HTTP_IF_NONE_MATCH header if set (etag: unique file hash)
$etagHeader=(isset($_SERVER['HTTP_IF_NONE_MATCH']) ? trim($_SERVER['HTTP_IF_NONE_MATCH']) : false);

//set last-modified header
header("Last-Modified: ".gmdate("D, d M Y H:i:s", $lastModified)." GMT");
//set etag-header
header("Etag: $etagFile");
//make sure caching is turned on
header('Cache-Control: public');

//check if page has changed. If not, send 304 and exit
if (@strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE'])==$lastModified || $etagHeader == $etagFile)
{
       header("HTTP/1.1 304 Not Modified");
       exit;
}

//your normal code
//echo "This page was last modified: ".date("d.m.Y H:i:s",time()) . "<br>";





if (isset($_GET['Street'])) {
    # Query available addresses
    $request = $fm->newFindCommand('AddressList');
    $request->addFindCriterion('Map', $_GET['Map']); 
    $request->addFindCriterion('Block', $_GET['Block']);
    $request->addFindCriterion('Street', str_replace('-', ' ', $_GET['Street']));
    # Filter
    if ($_GET['Filter'] == 'Contacted') {
        $fmfilter = '==';
    }
    $request->addFindCriterion('isHome', $fmfilter);
    $request->addSortRule('cNumber', 1);
    $result = $request->execute();

    # Trap for errors
    if (FileMaker::isError($result)) {
        $errorMessage = $result->getMessage();
    } else {
        $records = $result->getRecords();

        $addresses = array();
        foreach($records as $record) {
            $addresses[] = array(
                'recID' => $record->getField('recID'),
                'cStatus' => $record->getField('cStatus'),
                'modDate' => $record->getField('modDate'),
                'streetNumber' => $record->getField('Number'),
                'streetName' => $record->getField('Street'),
                'streetNameWithDash' => str_replace(' ', '-', $record->getfield('Street')),
                'description' => $record->getField('Address Description'),
                'cUnitsCount' => $record->getField('cUnitsCount'),
                'unitsNH' => $record->getField('unitsNH'),
                'cUnitBlockContacted' => $record->getField('cUnitBlockContacted'),
            );
        }
    }

    # Query available streets
    $request = $fm->newFindCommand('BlockStreet');
    $request->addFindCriterion('MapBlock::Map', $_GET['Map']);
    $request->addFindCriterion('MapBlock::Block', $_GET['Block']); 
    $result = $request->execute();
    $records = $result->getRecords();

    $streets = array();
    foreach($records as $record) {
        $streets[] = array(
            'street' => $record->getfield('Street'),
            'streetWithDash' => str_replace(' ', '-', $record->getfield('Street')),
        );   
    }
    
    # Query available blocks
    $request = $fm->newFindCommand('MapBlock');
    $request->addFindCriterion('Map', $_GET['Map']); 
    $result = $request->execute();
    $records = $result->getRecords();

    $mapBlocks = array();
    foreach($records as $record) {
        $mapBlocks[] = array(
            'Block' => $record->getField('Block'),
            'blockToContact' => $record->getField('blockToContact'),
            'isDone' => $record->getField('isDone')
        );
    }
    
    # prepare variables for template
    echo $template->render(array(
            'navbarFilter' => $_GET['Filter'],
            'addresses' => $addresses,
            'street' => str_replace('-', ' ', $_GET['Street']),
            'streetWithDash' => $_GET['Street'],
            'streets' => $streets,       
            'blockNumber' => $_GET['Block'],
            'mapBlocks' => $mapBlocks,
            'mapNumber' => $_GET['Map'],
            'errorMessage' => $errorMessage
        )
    );

} elseif (isset($_GET['Block'])) {
    # Query available streets
    $request = $fm->newFindCommand('BlockStreet');
    $request->addFindCriterion('MapBlock::Map', $_GET['Map']);
    $request->addFindCriterion('MapBlock::Block', $_GET['Block']); 
    $result = $request->execute();
    $records = $result->getRecords();

    $streets = array();
    foreach($records as $record) {
        $streets[] = array(
            'street' => $record->getfield('Street'),
            'streetWithDash' => str_replace(' ', '-', $record->getfield('Street')),
        );   
    }
    
    # Query available blocks
    $request = $fm->newFindCommand('MapBlock');
    $request->addFindCriterion('Map', $_GET['Map']); 
    $result = $request->execute();
    $records = $result->getRecords();

    $mapBlocks = array();
    foreach($records as $record) {
        $mapBlocks[] = array(
            'Block' => $record->getField('Block'),
            'blockToContact' => $record->getField('blockToContact'),
            'isDone' => $record->getField('isDone')
        );
    }

    echo $template->render(array(
            'streets' => $streets,       
            'blockNumber' => $_GET['Block'],
            'mapBlocks' => $mapBlocks,
            'mapNumber' => $_GET['Map'],
            'errorMessage' => $_GET['msg']
        )
    );

} elseif (isset($_GET['Map'])) {
    # Query available blocks
    $request = $fm->newFindCommand('MapBlock');
    $request->addFindCriterion('Map', $_GET['Map']); 
    $result = $request->execute();
    $records = $result->getRecords();

    $mapBlocks = array();
    foreach($records as $record) {
        $mapBlocks[] = array(
            'Block' => $record->getField('Block'),
            //'blockToContact' => $record->getField('blockToContact'),
            'isDone' => $record->getField('isDone')
        );
    }

    echo $template->render(array(
            'mapBlocks' => $mapBlocks,
            'mapNumber' => $_GET['Map'],
            'errorMessage' => $_GET['msg']
        )
    );

} else {
    
    $foo = 'foo';

    echo $template->render(array(
        'foo' => $foo,
        'errorMessage' => $_GET['msg']
        )
    );

}

?>
