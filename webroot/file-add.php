<?php
include('../libs/Config.php');
auth();
if(empty($_POST)){
    exit;
}
require('../libs/Tutorials.class.php');
require('../libs/Predis_Page.class.php');

$tutorials = new Tutorials;
$peregrine = $tutorials->getPeregrine();
$tutorials->attach(
    $peregrine->post->getRaw('text'),
    $peregrine->post->getInt('id'),
    $peregrine->post->getRaw('name')
);
header('Location: /admin/'.$peregrine->post->getInt('id').'/');
