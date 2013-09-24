<?php if(isset($pass[0])): ?>

<?php else: ?>
<div class="margined">
    <h3>Manage Files</h3>
    <form method="post" action="/file-add.php">
        <label for="text">Paste your file that you'd like to attach!</label>
        <textarea id="text" name="text" rows="20" placeholder="Paste your file in here!"></textarea>
        <label for="id">What is the id of the tutorial you're attaching this to?</label>
        <input type="number" id="id" name="id" value="<?=$tutorials->getPeregrine()->get->getInt('id')?>"/>
        <label for="name">What is the name of this file?</label>
        <input type="text" id="name" name="name" placeholder="hello-world.txt"/>
        <button type="submit">Submit!</button>
    </form>
</div>
<?php endif; ?>
