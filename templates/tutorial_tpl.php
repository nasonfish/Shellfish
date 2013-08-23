<div class="span9 pull-left">
    <?php $tutorials->html_printTutorial($tutorials->page($pass[1]), true); ?>
</div>
<div class="span3 pull-right">
    <?=($tutorials->html_downloadLink($tutorials->page($pass[1]))); ?>
    <?=($tutorials->html_printTags($tutorials->page($pass[1]))); ?>
</div>