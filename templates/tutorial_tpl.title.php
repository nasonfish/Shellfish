<?php
try{
    print "Tutorial - " . $tutorials->page($pass[1])->getTitle();
} catch (PredisPageDoesNotExistException $e){
    print "Tutorial Not Found";
}
