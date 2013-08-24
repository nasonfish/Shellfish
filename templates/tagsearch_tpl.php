<?php

foreach($tutorials->tagSearch($tutorials->getAllPages(), $pass) as $result){
    $tutorials->html_printTutorialLink($tutorials->page($result));
}