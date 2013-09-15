<?php
if(isset($args[0])){
include('../libs/Predis_Page.class.php');
include('../libs/Tutorials.class.php');
$id = $args[0];
try{
    $page = new Page($id, new Tutorials);
} catch(PredisPageDoesNotExistException $e){
    echo "Error - that page does not exist.";
}

header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename=' . preg_replace('[\\/:"*?<>|]+', '', $page->getTitle()));
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
$content = $page->getDownload();
header('Content-Length: ' . strlen($content));

print $content;
} else {
    echo "Error - that page does not exist.";
}