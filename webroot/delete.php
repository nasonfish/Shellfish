<?php
include('../libs/Config.php');
auth();

if(empty($_POST)){
    exit;
}
require('../libs/Tutorials.class.php');
$tutorials = new Tutorials;
$id = $tutorials->getPeregrine()->post->getInt('id');
$tutorials->delete($id);
header('Location: /');
