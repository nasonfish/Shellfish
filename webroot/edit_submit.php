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

$tutorials = new Tutorials;
$peregrine = $tutorials->getPeregrine();
$tutorials->edit($peregrine->post->getInt('id'), $peregrine->post->getRaw('title'), $peregrine->post->getRaw('description'),
    $peregrine->post->getRaw('text'), $peregrine->post->isEmpty('download') ? false : $peregrine->post->getRaw('download'),
    explode(',', strtolower($peregrine->post->getRaw('tags'))), strtolower($peregrine->post->getRaw('category')),
    $peregrine->post->getUsername('username'), $peregrine->server->getIP('REMOTE_ADDR'));
//     public function create($title, $description, $text, $download, $tags, $username, $ip){
header('Location: /t/'.$tutorials->page($peregrine->post->getInt('id'))->getTitleSlug().'/'.$peregrine->post->getInt('id').'/');
