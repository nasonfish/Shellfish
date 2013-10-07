<?php
header('Content-Type: text/plain');
if(isset($args[0]) && isset($args[1])){
    $id = $args[0];
    $subid = $args[1];
    include('../libs/Tutorials.class.php');
    include('../libs/Predis_Page.class.php');
    $tutorials = new Tutorials;
    try{
        $page = $tutorials->page($id);
    } catch(PredisPageDoesNotExistException $e){
        die("Error - That page id does not exist.");
    }
    print $tutorials->attachmentText($id, $subid);
} else {
    echo('Error - That file does not exist.');
}
