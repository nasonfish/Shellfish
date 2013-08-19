<?php $page = $tutorials->page($_GET['id']); ?>
<form method="post" action="/edit_submit.php">
    <label for="id">ID</label>
    <input id="id" name="id" type="number" value="<?=$page->getId()?>" readonly>
    <label for="username">Your username</label>
    <input id="username" name="username" type="text" value="<?=$page->getUsername()?>"/>
    <label for="title">Title</label>
    <input id="title" name="title" type="text" value="<?=$page->getTitle()?>"/>
    <label for="description">Description/Subtitle</label>
    <input id="description" name="description" type="text" value="<?=$page->getDescription()?>"/>
    <label for="text">Tutorial</label>
    <textarea id="text" name="text"><?=$page->getText()?></textarea>
    <label for="download">Downloadable Script</label>
    <textarea id="download" name="download"><?=$page->getDescription();?></textarea>
    <label for="tags">Tags (Separate with ', ')</label>
    <input id="tags" name="tags" type="text" value="<?=implode(', ', $page->getTags())?>"/>
    <!--<input id="ip" name="ip" value="<?//=$_SERVER['REMOTE_ADDR']?>">--> <!-- hidden, this will be the last edited person. -->
    <br/>
    <button type="submit">Re-Submit!</button>
</form>