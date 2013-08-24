<?php
if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header("WWW-Authenticate: Basic realm=\"Tutorials.pufferfi.sh - Create Tutorial\"");
    header("HTTP/1.0 401 Unauthorized");
    echo '401 Unauthorized - No username/password supplied. Sorry.';
    exit;
} else {
    if($_SERVER['PHP_AUTH_PW'] != file_get_contents('../pass.txt')){
        header("WWW-Authenticate: Basic realm=\"Tutorials.pufferfi.sh - Create tutorial.\"");
        header("HTTP/1.0 401 Unauthorized");
        echo "401 Unauthorized - Incorrect username/password. Sorry.";
        exit;
    }
}

if(empty($_POST)){
    exit;
}
require('../libs/Tutorials.class.php');
require('../libs/Predis_Page.class.php');
require('../Peregrine/Peregrine.php');
$peregrine = new Peregrine;
$peregrine->init();

$tutorials = new Tutorials;
$id = $tutorials->create($peregrine->post->getRaw('title'), $peregrine->post->getRaw('description'),
    $peregrine->post->getRaw('text'), $peregrine->post->isEmpty('download') ? false : $peregrine->post->getRaw('download'),
    explode(', ', $peregrine->post->getRaw('tags')), $peregrine->post->getRaw('distro'), $peregrine->post->getRaw('compatible'),
    $peregrine->server->getUsername('PHP_AUTH_USER'), $peregrine->server->getIP('REMOTE_ADDR'));
//     public function create($title, $description, $text, $download, $tags, $username, $ip){
header('Location: /t/'.$tutorials->page($id)->getTitleSlug().'/'.$id.'/');