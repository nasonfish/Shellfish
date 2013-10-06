<?php
include('../libs/Config.php');

require('../libs/Tutorials.class.php');
$tutorials = new Tutorials;
$pages = $tutorials->getAllPages();
$res = array();
foreach($pages as $page){
    $res[$tutorials->page($page)->getTitle()] = $page; // $name => $id
}
print json_encode($res);
