<!DOCTYPE html>
<html>
<head>
    <title>Tutorials, by pufferfi.sh</title>
    <link href="/app.css" rel="stylesheet" media="all">
    <link href="/bootstrap.css" rel="stylesheet" media="all">
    <?php $this->css(); ?>
</head>
<body>
<div class="content">
    <div class="head">
        <?php $this->head(); ?>
    </div>
    <div class="body">
        <?php $this->page(); ?>
    </div>
    <div class="foot">
        <?php $this->foot(); ?>
    </div>
</div>
<footer>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script src="/app.js"></script>
    <?php $this->js(); ?>
</footer>
</body>
</html>