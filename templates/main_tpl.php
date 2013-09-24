<!DOCTYPE html>
<html>
<head>
    <title><?=$this->title()?> - <?=get('main:title');?></title>
    <link href='//fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Cabin' rel='stylesheet' type='text/css'>
    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.no-icons.min.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
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
            <h2 class="title pull-left">
                <span class="icon-stack" style="font-size: 22px;">
                    <i class="icon-cloud icon-stack-base"></i>
                    <i class="icon-linux icon-dark"></i>
                </span> <?=get('main:bar-title');?></h2>
            <div class="pull-right right-search">
                <form action="/search/" method="get">
                    <i class="icon-search" style="color: white;"></i>
                    <input name="q" id="title-tag-search" placeholder="<?=get('main:bar-search');?>"/>
                </form>
            </div>
        </div>
        <div class="sub-bar row-fluid">
            <ul class="sub-links">
                <li class="sub-link span2 <?= $this->active('index'); ?>"><a class="link" href="/"><i class="icon-home"></i> Home</a></li>
                <li class="sub-link span2 <?= $this->active('categories'); ?>"><a class="link" href="/categories/"><i class="icon-compass"></i> Categories</a></li>
                <!--<li class="link sub-link span2 <?= $this->active('about-us'); ?>" data-href="/about-us/"><i class="icon-book"></i> About Us</li>-->
                <li class="sub-link span2 <?= $this->active('create'); ?>"><a class="link" href="/create/"><i class="icon-edit"></i> Create a page</a></li>
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
            <li class="bottom-link"><a href="/api/">Check out our API!</a></li>
            <li class="bottom-link"><a href="http://creativecommons.org/licenses/by-nc-sa/3.0/">Tutorials licensed under Creative Commons BY-NC-SA license.</a></li>
            <li class="bottom-link"><a href="https://github.com/pufferfi-sh/Shellfish/">Source code is available on GitHub</a></li>
        </ul>
    </div>
</div>
<footer>
    <script src="/simpledom.js"></script>
    <script src="/Rainbow/rainbow-custom.min.js"></script>
    <script src="/app.js"></script>
    <?php $this->js(); ?>
</footer>
</body>
</html>
