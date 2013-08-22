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
                <form action="/tagsearch.php" method="get"><input name="tags" id="title-tag-search" placeholder="Search for tutorials!"/></form>
            </div>
        </div>
        <div class="sub-bar">
            <ul class="sub-links">
                <li class="sub-link"><a href="/">Home</a></li>
            </ul>
        </div>
        <?php $this->head(); ?>
    </div>
    <div class="body row-fluid">
        <?php $this->page(); ?>
    </div>
    <div class="foot">
        <?php $this->foot(); ?>
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