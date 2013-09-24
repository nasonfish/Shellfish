<?php
try{
    $pass[0] = isset($pass[0]) ? $pass[0] : -1;
    print "Tutorial - " . $tutorials->page($pass[0])->getTitle();
} catch (PredisPageDoesNotExistException $e){
    print "Tutorial Not Found";
}
