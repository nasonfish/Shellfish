<div class="white">
    <h4 class="categories-h">Click on a category on the left to see all tutorials tagged with that category!</h4>
</div>
<div class="span1">&nbsp;</div>
<div class="span3 categories categories-left">
    <h4>Categories</h4>
    <input type="text" placeholder="Filter categories..." id="category-filter"/>
    <ul class="tags red">
        <?php $categories = $tutorials->getCategories(); foreach($categories as $category): ?>
            <div class="categories-item" data-for="<?=strtolower($category)?>"><li><a><?=$category?> <span><?=sizeof($tutorials->categorized($category));?></span></a></li><br/><br/></div>
        <?php endforeach; ?>
    </ul>
</div>
<div class="span7 categories categories-right">
    <?php
    foreach($categories as $category){
        print '<div class="category-sample category-sample-'.$category.'" data-category="'.$category.'">';
        print '<h3><a href="/category/'.$category.'/">See all tutorials with that category!</a></h3>';
        foreach($tutorials->categorySearch($tutorials->getAllPages(), $category, 6) as $tutorial){
            print "<hr/>";
            $tutorials->html_printSample($tutorials->page($tutorial));
        }
        print '</div>';
    }
    ?>
</div>
<div class="span1">&nbsp;</div>
<br class="pad-bottom"/>
