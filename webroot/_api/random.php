<?php
include '../../libs/Tutorials.class.php';
include '../../libs/Predis_Page.class.php';
include '../../libs/PredisPageDoesNotExistException.php';
include '../../libs/Config.php';
$tutorials = new Tutorials;
try{
    $page = $tutorials->random();
} catch(Exception $e){
    print json_encode(array('success' => 0, 'message' => "No tutorials were found."));
    exit;
}
print $page->__toString();
