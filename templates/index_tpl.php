<div class="welcome">
    <h2 class="main-header"><?=get('index:main-header');?></h2>
    <h4 class="sub-header"><?=get('index:sub-header');?></h4>
    <br/>
    <form method="GET" action="/search/"><input name="q" class="main-tag-search" type="text" placeholder="Search the site for information!" style="width: 50%;"/></form>
    <div class="mid-boxes">
        <div class="span6 mid-box">
            <button class="mid-button link button button-blue" data-href="/all/"><?=get('index:all-button');?></button>
            <br/><br/>
            <div class="mid-sample-box">
                <h3>Recent Tutorials</h3>
                <?php $pages = $tutorials->getAllPages(5, 1, true)?>
                <?php foreach($pages as $page): ?>
                    <hr/> <?php // We're allowed to use this here because we want there to be an intial one too! :D ?>
                    <?php $tutorials->html_printSample($tutorials->page($page));?>
                <?php endforeach; ?>
                <?php if(sizeof($pages) < 1): ?>
                    <hr/>
                    <h4>No tutorial previews found.</h4>
                <?php endif; ?>
            </div>
        </div>
        <div class="span6 mid-box">
            <button class="mid-button link button button-blue" data-href="/categories/"><?=get('index:category-button');?></button>
            <br/><br/>
            <div class="mid-sample-box small">
                <h3>Popular Tutorials</h3>
                <?php foreach($tutorials->quickPopular() as $page): ?>
                    <hr/> <?php // We're allowed to use this here because we want there to be an intial one too! :D ?>
                    <?php $tutorials->html_printSample($tutorials->page($page));?>
                <?php endforeach; ?>
                <?php if(sizeof($pages) < 1): ?>
                    <hr/>
                    <h4>No tutorial previews found.</h4>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
