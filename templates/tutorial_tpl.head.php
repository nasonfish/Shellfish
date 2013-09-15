<?php
$pass[1] = isset($pass[1]) ? $pass[1] : -1;
try {
    $page = $tutorials->page($pass[1]);
    if($pass[0] != ($slug = $page->getTitleSlug())){
        echo '<link rel="canonical" href="/tutorial/'.$slug.'/'.$page->getId().'/" />';
    }
    $page->view();
} catch (PredisPageDoesNotExistException $e){

}