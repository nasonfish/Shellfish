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
$tutorials->edit($peregrine->post->getInt('id'),
    $peregrine->post->getRaw('title'),
    $peregrine->post->getRaw('description'),
    $peregrine->post->getRaw('text'),
    $peregrine->post->isEmpty('tags') ? array() : explode(',', strtolower($peregrine->post->getRaw('tags'))),
    strtolower($peregrine->post->getRaw('category')),
    $peregrine->post->getUsername('username'),
    $peregrine->server->getIP('REMOTE_ADDR')
);
//     public function create($title, $description, $text, $download, $tags, $username, $ip){
header('Location: /tutorial/'.$peregrine->post->getInt('id').'/'.$tutorials->page($peregrine->post->getInt('id'))->getTitleSlug().'/');
