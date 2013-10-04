<div class="white">
    <h4 class="categories-h">Click on a category on the left to see tutorials tagged with that category!</h4>
</div>
<div class="span1">&nbsp;</div>
<div class="span3 categories categories-left">
    <h4>Categories</h4>
    <input type="text" placeholder="Filter categories..." id="category-filter"/>
        <?php $categories = $tutorials->getCategories(); foreach($categories as $category): ?>
            <div class="categories-item button button-blue" style="display: block; margin-top: 4px; margin-right: 50%; margin-left: 0;" data-for="<?=strtolower($category)?>"><?=$category?> <span>(<?=sizeof($tutorials->categorized($category));?>)</span></div>
        <?php endforeach; ?>
</div>
<div class="span7 categories categories-right">
    <?php
    foreach($categories as $category){
        print '<div class="category-sample category-sample-'.$category.'" data-category="'.$category.'">';
        print '<h4><a href="/category/'.$category.'/">See all tutorials under the category <code>'.$category.'</code>!</a></h4>';
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
