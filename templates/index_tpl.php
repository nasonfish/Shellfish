<?php
$page = $_GET['page'] ? $_GET['page'] : 1;
foreach($tutorials->getAllPages(10, $page) as $tutorial){
    $tutorials->html_printTutorial($tutorials->page($tutorial));
}
?>