<?php
$tutorials = new Tutorials;
$tutorials->html_printTut($tutorials->page($_GET['id']), true);