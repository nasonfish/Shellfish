<?php
require '../Markdown/Michelf/MarkdownExtra.php';
$md = new \Michelf\MarkdownExtra();
print $md->defaultTransform($_POST['text']);