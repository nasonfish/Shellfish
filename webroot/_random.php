<?php
include('../libs/Tutorials.class.php');
$tutorials = new Tutorials;
$page = $tutorials->random();
header(sprintf('Location: /tutorial/%s/%s/', $page->getId(), $page->getTitleSlug()));
