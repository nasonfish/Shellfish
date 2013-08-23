<?php

foreach($tutorials->tagSearch($pass) as $result){
    $tutorials->html_printTutorial($tutorials->page($result));
}