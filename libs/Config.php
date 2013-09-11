<?php

include('CustomConfig.php');

function get($key){
    global $_CONFIG;
    if(isset($_CONFIG[$key])){
        return $_CONFIG[$key];
    }
    return "";
}

function has($key){
    global $_CONFIG;
    return isset($_CONFIG[$key]);
}
