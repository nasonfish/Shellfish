<?php
try{
    $pass[1] = isset($pass[1]) ? $pass[1] : -1;
    $page = $tutorials->page($pass[1]);
//    if($page->getTitleSlug() != $pass[0]){
//        echo("Tutorial not found."); // TODO change this somehow
//    } else {
?>
<div class="margined">
<div class="span9 pull-left">
    <?php $tutorials->html_printTutorial($tutorials->page($pass[1]), true); ?>
</div>
<div class="span3 pull-right">
    <?=($tutorials->html_downloadLink($tutorials->page($pass[1]))); ?>
    <div id="download-preview"></div>
    <?=($tutorials->html_printTags($tutorials->page($pass[1]))); ?>
</div>
</div>
<?php
//    }
} catch(PredisPageDoesNotExistException $e){
    echo "<div class='margined'><h3>Tutorial not found.</h3>";
    echo "<p>I couldn't find the tutorial you were looking for.</p></div>";
}
