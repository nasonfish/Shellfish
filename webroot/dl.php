<?php
include ('../libs/tutorials.class.php');
$tutorials = new Tutorials;
$page = $tutorials->getPage($_GET['id']);

header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename=' . $page->download);
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
$content = file_get_contents('../downloads/' . $page->download);
header('Content-Length: ' . strlen($content));

print $content;