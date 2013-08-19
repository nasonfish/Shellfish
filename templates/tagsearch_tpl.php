<?php
foreach($tutorials->tagSearch(explode(',', $_GET['tags'])) as $result){
    $tutorials->html_printTutorial($tutorials->page($result));
}