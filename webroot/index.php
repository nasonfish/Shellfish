<!DOCTYPE html>
<html>
<head>
    <title>Tutorials, by pufferfi.sh</title>
    <link href="app.css" rel="stylesheet" media="all">
    <link href="bootstrap.css" rel="stylesheet" media="all">
</head>
<body>
    <div class="content">
        <div class="head">

        </div>
        <div class="body">
            <?php
            include('../libs/Tutorials.class.php');
            include('../libs/Predis_Page.class.php');
            $tutorials = new Tutorials;
            foreach($tutorials->getPredisInterface()->getAllPages(10) as $tutorial){
                $tutorials->printTut(new Page($tutorial, $tutorials->getPredisInterface()));
            }
            ?>
        </div>
        <div class="foot">

        </div>
    </div>
    <footer>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
        <script src="app.js"></script>
    </footer>
</body>
</html>