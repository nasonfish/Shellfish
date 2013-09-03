<!DOCTYPE html>
<html>
<head>
    <title><?=$this->title()?> - <?=get('main:title');?></title>
    <link href="/bootstrap.css" rel="stylesheet" media="all">
    <link href="/Rainbow/solarized-dark.css" rel="stylesheet" media="all">
    <link href="/sliding-tags/12-sliding-tags/css/style.css" rel="stylesheet" media="all">
    <link href="/app.css" rel="stylesheet" media="all">
    <link href="/colors.css" rel="stylesheet" media="all">
    <?php $this->css(); ?>
</head>
<body>
<div class="content">
    <div class="head">
        <div class="title-bar">
            <h2 class="title pull-left"><?=get('main:bar-title');?></h2>
            <div class="pull-right right-search">
                <form action="/search/" method="get"><input name="q" id="title-tag-search" placeholder="<?=get('main:bar-search');?>"/></form>
            </div>
        </div>
        <div class="sub-bar">
            <ul class="sub-links">
                <li class="sub-link span2 <?= $this->active('index'); ?>"><a href="/">Home</a></li>
                <li class="sub-link span2 <?= $this->active('categories'); ?>"><a href="/categories/">Categories</a></li>
                <li class="sub-link span2 <?= $this->active('about-us'); ?>"><a href="/about-us/">About Us</a></li>
                <li class="sub-link span2 <?= $this->active('create'); ?>"><a href="/create/">Create a page</a></li>
                <li class="sub-link-filler span4">&nbsp;</li>
            </ul>
        </div>
        <?php $this->head(); ?>
    </div>
    <div class="body row-fluid">
         <?php $this->page(); ?>
        <?php $this->foot(); ?>
    </div>
    <div class="foot" id="bottom">
        <ul class="bottom-bar row">
            <li class="bottom-link"><a href="http://creativecommons.org/licenses/by-nc-sa/3.0/">Tutorials licensed under Creative Commons BY-NC-SA license.</a></li>
            <li class="bottom-link"><a href="http://github.com/nasonfish/Tutorials/">Source code is available on GitHub</a></li>
        </ul>
    </div>
</div>
<footer>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script src="/Rainbow/rainbow-custom.min.js"></script>
    <script src="/app.js"></script>
    <?php $this->js(); ?>
</footer>
</body>
</html>
