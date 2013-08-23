<!DOCTYPE html>
<html>
<head>
    <title>Tutorials, by pufferfi.sh</title>
    <link href="/bootstrap.css" rel="stylesheet" media="all">
    <link href="/app.css" rel="stylesheet" media="all">
    <link href="/Rainbow/solarized-dark.css" rel="stylesheet" media="all">
    <?php $this->css(); ?>
</head>
<body>
<div class="content">
    <div class="head">
        <div class="title-bar">
            <h2 class="title pull-left">Tutorials</h2>
            <div class="pull-right right-things">
                <form action="/tagsearch/" method="get"><input name="tags" id="title-tag-search" placeholder="Search for tutorials!"/></form>
            </div>
        </div>
        <div class="sub-bar">
            <ul class="sub-links">
                <li class="sub-link active span2"><a href="/">Home</a></li>
                <li class="sub-link span2"><a href="/categories/">Categories</a></li>
                <li class="sub-link span2"><a href="/about-us/">About Us</a></li>
                <li class="sub-link-filler span6">&nbsp;</li>
            </ul>
        </div>
        <?php $this->head(); ?>
    </div>
    <div class="body row-fluid">
        <?php $this->page(); ?>
    </div>
    <div class="foot">
        <?php $this->foot(); ?>
        <div id="bottom">
            <ul class="bottom-bar row">
                <li class="bottom-link"><a href="http://creativecommons.org/licenses/by-nc-sa/3.0/">Tutorials licensed under Creative Commons BY-NC-SA license.</a></li>
                <li class="bottom-link"><a href="http://github.com/nasonfish/Tutorials/">Source code is available on GitHub</a></li>
            </ul>
        </div>
    </div>
</div>
<footer>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script src="/app.js"></script>
    <script src="/Rainbow/rainbow-custom.min.js"></script>
    <?php $this->js(); ?>
</footer>
</body>
</html>