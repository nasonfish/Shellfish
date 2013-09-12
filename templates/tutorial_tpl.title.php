<?php
try{
    $pass[1] = isset($pass[1]) ? $pass[1] : -1;
    print "Tutorial - " . $tutorials->page($pass[1])->getTitle();
} catch (PredisPageDoesNotExistException $e){
    print "Tutorial Not Found";
}
