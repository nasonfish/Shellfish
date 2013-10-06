<div class="welcome">
    <h1 class="main-header"><?=get('index:main-header');?></h1>
    <h3 class="sub-header"><?=get('index:sub-header');?></h3>
    <br/>
    <img style="margin-bottom: 15px;" src="/logo.png"/>
    <div class="mid-boxes">
        <div class="span6 mid-box">
            <a class="link" href="/all/"><button class="mid-button button button-blue"><?=get('index:all-button');?></button></a>
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
            <a class="link" href="/categories/"><button class="mid-button button button-blue"><?=get('index:category-button');?></button></a>
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
