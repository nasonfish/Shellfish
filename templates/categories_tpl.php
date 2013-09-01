<?php
$categories = $tutorials->getCategories();
?>
<h4 class="categories-h">Click on a category on the left to see all tutorials tagged with that category!</h4>
<div class="span1">&nbsp;</div>
<div class="span3 categories categories-left">
    <h4>Categories</h4>
    <ul>
        <?php foreach($categories as $category): ?>
            <li class="categories-item" data-for="<?=$category?>"><!--<a href="/category/<?=$category?>">--><?=$category?><!--</a>--></li>
        <?php endforeach; ?>
    </ul>
</div>
<div class="span7 categories categories-right">
    <h6>We can load in a list of tutorials here. :-)</h6>
</div>
<div class="span1">&nbsp;</div>
