<?php
$page = $tutorials->getPeregrine()->get->getInt('page');
$page = $page ? $page : 1;
foreach($tutorials->getAllPages(10, $page) as $tutorial){
    $tutorials->html_printTutorialLink($tutorials->page($tutorial));
}
