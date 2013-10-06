<?php
include('../libs/Config.php');
if(get('admin:auth')){
    if (!isset($_SERVER['PHP_AUTH_USER'])) {
        header("WWW-Authenticate: Basic realm=\"Tutorials.pufferfi.sh - Create Tutorial\"");
        header("HTTP/1.0 401 Unauthorized");
        echo '401 Unauthorized - No username/password supplied. Sorry.';
        exit;
    } else {
        if($_SERVER['PHP_AUTH_PW'] != trim(file_get_contents('../pass.txt'))){
            header("WWW-Authenticate: Basic realm=\"Tutorials.pufferfi.sh - Create tutorial.\"");
            header("HTTP/1.0 401 Unauthorized");
            echo "401 Unauthorized - Incorrect username/password. Sorry.";
            exit;
        }
    }
}

if(empty($_POST)){
    exit;
}
require('../libs/Tutorials.class.php');
$tutorials = new Tutorials;
$id = $tutorials->getPeregrine()->post->getInt('id');
$tutorials->delete($id);
header('Location: /');
