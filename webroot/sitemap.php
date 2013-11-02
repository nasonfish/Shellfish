<?php
// Generate a sitemap.xml file for Google and other search engines to use for indexing these files.
header('Content-Type: text/xml');
include('../libs/Config.php');
include('../libs/Tutorials.class.php');
include('../libs/Predis_Page.class.php');
$tutorials = new Tutorials;
echo '<?xml version="1.0" encoding="UTF-8"?>';
// TODO lastmod
?>

<urlset xmlns="http://www.sitemaps.org/shemas/sitemap/0.9">
<?php foreach($tutorials->getAllPages() as $page): $page = $tutorials->page($page); ?>
    <url>
        <loc>https://shellfish.io/tutorial/<?=$page->getId();?>/<?=$page->getTitleSlug()?>/</loc>
        <changefreq>monthly</changefreq>
    </url>
<?php endforeach; ?>
</urlset>