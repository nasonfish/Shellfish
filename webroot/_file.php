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
    $file = $tutorials->attachmentText($id, $subid);
    // Make it unix-file-ish. CRLF => LF, leading newline
    $file = trim(str_replace("\r", "", $file), "\n") . "\n";
    print($file);
} else {
    echo('Error - That file does not exist.');
}
