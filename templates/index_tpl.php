<?php
$tutorials = new Tutorials;
foreach($tutorials->getAllPages(10) as $tutorial){
    $tutorials->html_printTut($tutorials->page($tutorial));
}
?>