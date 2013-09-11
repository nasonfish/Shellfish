<?php
$id = $args[0];
include('../libs/Tutorials.class.php');
$tutorials = new Tutorials;
$page = $tutorials->page($id);
header(sprintf('Location: /tutorial/%s/%s/', $page->getTitleSlug(), $id));
