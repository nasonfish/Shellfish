<?php

include('CustomConfig.php');

function get($key){
    global $_CONFIG;
    if(isset($_CONFIG[$key])){
        return $_CONFIG[$key];
    }
    return "";
}