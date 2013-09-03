<?php
$categories = $tutorials->getCategories();
?>

<h4 class="categories-h">Click on a category on the left to see all tutorials tagged with that category!</h4>
<div class="span1">&nbsp;</div>
<div class="span3 categories categories-left">
    <h4>Categories</h4>
    <input type="text" placeholder="Filter categories..." id="category-filter"/>
    <ul class="tags red">
        <?php foreach($categories as $category): ?>
            <li class="categories-item" data-for="<?=strtolower($category)?>"><a><?=$category?> <span><?=sizeof($tutorials->categorized($category));?></span></a></li>
            <br/><br/>
        <?php endforeach; ?>
    </ul>
</div>
<div class="span7 categories categories-right">
    <h6>We can load in a list of tutorials here. :-)</h6>
</div>
<div class="span1">&nbsp;</div>
<br class="pad-bottom"/>