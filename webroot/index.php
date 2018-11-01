<?php
include('../libs/Config.php');
require '../libs/PageHandler.class.php';
$uri = explode('/', strpos($_SERVER['REQUEST_URI'], '?') ? strstr($_SERVER['REQUEST_URI'], '?', true) : $_SERVER['REQUEST_URI']);
foreach($uri as $id => $dir){
    if($dir == ""){
        unset($uri[$id]);
    }
}
$page = isset($uri[1]) ? $uri[1] : 'index';
array_shift($uri);
$args = $uri === NULL ? array() : $uri;
if(strpos($page, '_') === 0){
    include $page.'.php';
} else {
    new PageHandler($page, $args);
}
