<?php
session_start();
include('CustomConfig.php');

function file_get_contents_d($file){
    if(file_exists($file)){
        return file_get_contents($file);
    } else {
        return file_get_contents('../' . $file);
    }
}

/* These are pretty bad... */

function include_d($file){
    if(file_exists($file)){
        include($file);
    } else {
        include('../' . $file);
    }
}

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
