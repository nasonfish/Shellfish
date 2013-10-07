<?php
include('../libs/Config.php');
if(get('admin:auth')){
    if (!isset($_SERVER['PHP_AUTH_USER'])) {
        header("WWW-Authenticate: Basic realm=\"Tutorials.pufferfi.sh - Create Tutorial\"");
        header("HTTP/1.0 401 Unauthorized");
        echo '401 Unauthorized - No username/password supplied. Sorry.';
        exit;
    } else {
        if($_SERVER['PHP_AUTH_PW'] != trim(file_get_contents('../pass.txt'))){
            header("WWW-Authenticate: Basic realm=\"Tutorials.pufferfi.sh - Create tutorial.\"");
            header("HTTP/1.0 401 Unauthorized");
            echo "401 Unauthorized - Incorrect username/password. Sorry.";
            exit;
        }
    }
}

if(empty($_POST)){
    exit;
}
require('../libs/Tutorials.class.php');
$tutorials = new Tutorials;
$id = $tutorials->getPeregrine()->post->getInt('id');
$page = $tutorials->page($id);
?>
<h3>Page #<?=$id?> "<?=$page->getTitle()?>"</h3>
<p>by <?=$page->getUsername();?> (<?=$page->getIP();?>)</p>
<br/>
<a href="/_r/<?=$id?>/" ><button class="button button-blue">View this page!</button></a>
<a href="/edit/<?=$id?>/"><button class="button button-green">Edit this page!</button></a>
<form method="post" action="/delete.php">
    <input type="number" style="display: none;" name="id" value="<?=$id?>" onclick="return confirm('Are you sure you want to delete this page? This can not be undone.');"/>
    <button type="submit" class="button button-red">Delete this page?</button>
</form>
<h2>Attachments</h2>
<b><a href="/files/?id=<?=$id?>">Add new file!</a></b>
<h4>Hit the <code>X</code> to delete a file.</h4>
<ul>
    <?php foreach($page->getFiles() as $file):
        $fileName = $tutorials->attachmentName($page->getId(), $file);
        echo sprintf('<li><a href="/_file/%s/%s/%s">%s</a> <span class="detach red" data-id="%s" data-subid="%s">X</span></li>', $page->getId(), $file, $fileName, $fileName, $page->getId(), $file);
    endforeach; ?>
</ul>
<h2>Views</h2>
<p>Total: <strong><?=$page->getViews();?></strong></p>
<ul>
<?php foreach($page->getAllViews() as $view): ?>
    <li><?=$view?></li>
<?php endforeach; ?>
</ul>
