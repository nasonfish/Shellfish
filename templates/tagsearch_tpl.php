<?php

foreach($tutorials->tagSearch($pass) as $result){
    $tutorials->html_printTutorialLink($tutorials->page($result));
}