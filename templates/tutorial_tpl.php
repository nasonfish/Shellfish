<?php
try{
    $pass[0] = isset($pass[0]) ? $pass[0] : -1;
    $page = $tutorials->page($pass[0]);
//    if($page->getTitleSlug() != $pass[0]){
//        echo("Tutorial not found."); // TODO change this somehow
//    } else {
?>
<div class="margined">
<div class="span9 pull-left">
    <?php $tutorials->html_printTutorial($page, true); ?>
</div>
<div class="span3 pull-right">
    <?=($tutorials->html_attachments($page)); ?>
    <?=($tutorials->html_printTags($page)); ?>
</div>
</div>
<?php
//    }
} catch(PredisPageDoesNotExistException $e){
    echo "<div class='margined'><h3>Tutorial not found.</h3>";
    echo "<p>I couldn't find the tutorial you were looking for.</p></div>";
}
