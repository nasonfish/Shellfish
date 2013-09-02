<div class="welcome">
    <h2 class="main-header">The world of linux is beneath your fingertips</h2>
    <h4 class="sub-header">Tutorials is an easy-to-use system for publishing tutorials and other helpful articles</h4>
    <br/>
    <form method="GET" action="/search/"><input name="q" class="main-tag-search" type="text" placeholder="Search the site for information!"/></form>
    <div class="mid-boxes">
        <div class="span6 mid-box">
            <button class="mid-button link" data-href="/all/">List all Tutorials</button>
            <br/><br/>
            <div class="mid-sample-box">
                <?php $pages = $tutorials->getAllPages(5, 1, true); $first = true; ?>
                <?php foreach($pages as $page): ?>
                    <?php if(!$first){print "<hr/>";} else {$first = !$first;} ?>
                    <?php $tutorials->html_printSample($tutorials->page($page));?>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="span6 mid-box">
            <button class="mid-button link" data-href="/categories/">View by Category</button>
            <br/><br/>
            <div class="mid-sample-box">
                Sample categories!
            </div>
        </div>
    </div>
</div>
