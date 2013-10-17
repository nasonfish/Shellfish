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
$id = $tutorials->create($peregrine->post->getRaw('title'),
    $peregrine->post->getRaw('description'),
    $peregrine->post->getRaw('text'),
    $peregrine->post->isEmpty('tags') ? array() : explode(',', strtolower($peregrine->post->getRaw('tags'))),
    strtolower($peregrine->post->getRaw('category')),
    $_SESSION['user'],
    $peregrine->server->getIP('REMOTE_ADDR')
);
header('Location: /tutorial/'.$id.'/'.$tutorials->page($id)->getTitleSlug().'/');
