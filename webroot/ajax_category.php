<?php
include('../libs/Tutorials.class.php');
$tutorials = new Tutorials();
$category = $tutorials->getPeregrine()->post->getRaw('category');
?>
<h3><a href="/category/<?=$category?>/">View all pages with that category</a></h3>
<?php
foreach($tutorials->categorySearch($tutorials->getAllPages(), $category) as $tutorial){
    $tutorials->html_printTutorialLink($tutorials->page($tutorial));
}