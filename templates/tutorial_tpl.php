<?php
try{
    $page = $tutorials->page($pass[1]);
//    if($page->getTitleSlug() != $pass[0]){
        echo("Tutorial not found."); // TODO change this somehow
//    } else {
?>
<div class="span9 pull-left">
    <?php $tutorials->html_printTutorial($tutorials->page($pass[1]), true); ?>
</div>
<div class="span3 pull-right">
    <?=($tutorials->html_downloadLink($tutorials->page($pass[1]))); ?>
    <?=($tutorials->html_printTags($tutorials->page($pass[1]))); ?>
</div>
<?php
//    }
} catch(PredisPageDoesNotExistException $e){
    echo("Tutorial not found.");
}