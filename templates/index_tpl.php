<div class="welcome">
    <h2 class="main-header"><?=get('index:main-header');?></h2>
    <h4 class="sub-header"><?=get('index:sub-header');?></h4>
    <br/>
    <form method="GET" action="/search/"><input name="q" class="main-tag-search" type="text" placeholder="Search the site for information!"/></form>
    <div class="mid-boxes">
        <div class="span6 mid-box">
            <button class="mid-button link" data-href="/all/"><?=get('index:all-button');?></button>
            <br/><br/>
            <div class="mid-sample-box">
                <?php $pages = $tutorials->getAllPages(5, 1, true); $first = true; ?>
                <?php foreach($pages as $page): ?>
                    <?php if(!$first){print "<hr/>";} else {$first = !$first;} ?>
                    <?php $tutorials->html_printSample($tutorials->page($page));?>
                <?php endforeach; ?>
                <?php if($first): ?>
                    <h4>No tutorial previews found.</h4>
                <?php endif; ?>
            </div>
        </div>
        <div class="span6 mid-box">
            <button class="mid-button link" data-href="/categories/"><?=get('index:category-button');?></button>
            <br/><br/>
            <div class="mid-sample-box small">
                <ul class="tags red">
                    <?php $categories = $tutorials->getCategories() ?>
                    <?php foreach($categories as $category): ?>
                        <li class="index-tag"><a href="/category/<?=$category?>/"><?=$category?> <span><?=sizeof($tutorials->categorized($category));?></span></a></li>
                    <?php endforeach; ?>
                    <?php if(sizeof($categories) < 1): ?>
                        <h4>No categories found.</h4>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
