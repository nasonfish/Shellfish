<?php
foreach($tutorials->getAllPages(10) as $tutorial){
    $tutorials->html_printTutorial($tutorials->page($tutorial));
}
?>