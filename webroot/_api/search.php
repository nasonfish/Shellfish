<?php
include '../../libs/Tutorials.class.php';
include '../../libs/Predis_Page.class.php';
include '../../libs/PredisPageDoesNotExistException.php';
$tutorials = new Tutorials;
$pages = $tutorials->search($tutorials->getPeregrine()->get->getRaw('q'));
if(sizeof($pages) < 1){
    print json_encode(array('success' => 0, 'message' => "No tutorials were found matching your terms."));
    exit;
}
$page = $pages[0];
try {
    $tutorial = $tutorials->page($page);
} catch (PredisPageDoesNotExistException $e){
    print json_encode(array('success' => 0, 'message' => "Internal error, a database error has occurred. Tutorial " . $page . " should exist but it doesn't."));
    exit;
}
print $tutorial->__toString();
