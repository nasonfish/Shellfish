<div class="span9 pull-left">
    <?php $tutorials->html_printTutorial($tutorials->page($_GET['id']), true); ?>
</div>
<div class="span3 pull-right">
    <?=($tutorials->html_downloadLink($tutorials->page($_GET['id']))); ?>
    <?=($tutorials->html_printTags($tutorials->page($_GET['id']))); ?>
</div>