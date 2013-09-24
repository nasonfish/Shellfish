<?php
$pass[0] = isset($pass[0]) ? $pass[0] : -1;
try {
    $page = $tutorials->page($pass[0]);
    if($pass[1] != ($slug = $page->getTitleSlug())){
        echo '<link rel="canonical" href="/tutorial/'.$page->getId().'/'.$slug.'/" />';
    }
    $page->view();
} catch (PredisPageDoesNotExistException $e){

}