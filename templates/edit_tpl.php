<?php
if(isset($pass[0])):
try {
    $page = $tutorials->page($pass[0]);
?>
<div class="margined">
<h3>Edit a page</h3>
<span>Currently, a password is needed to edit pages on this site, however, you may be able to ask one of the owners of the site for the password in a form (coming soon!) if you would like to contribute.</span>
<form method="post" action="/edit_submit.php">
    <label for="id">ID</label>
    <input id="id" name="id" type="number" value="<?=htmlspecialchars($page->getId())?>" readonly>
    <label for="username">Your username</label>
    <input id="username" name="username" type="text" value="<?=htmlspecialchars($page->getUsername())?>"/>
    <label for="title">Title</label>
    <input id="title" name="title" type="text" value="<?=htmlspecialchars($page->getTitle())?>"/>
    <label for="description">Description/Subtitle</label>
    <input id="description" name="description" type="text" value="<?=htmlspecialchars($page->getDescription())?>"/>
    <div class="row-fluid">
        <div class="span7">
            <label for="text">Tutorial</label>
            <textarea id="text" name="text" rows="25" class="tutorial-editor"><?=htmlspecialchars($page->getText())?></textarea>
            <button class="markdown-test btn btn-small" type="button">Preview your Markdown!</button>
            <br/><br/>
        </div>
        <div class="span4" style="padding-left: 17px; padding-top: 15px;">
            <h4>Markdown</h4>
            <p>Markdown can be used in this tutorial to create neat formatting and make your tutorial look nice.</p>
            <p>You can check out <a href="http://daringfireball.net/projects/markdown/basics">this page</a> to see what Markdown offers.</p>
            <p>Here's a few tips that may be useful:</p>
            <ul>
                <li>Use <code>_single underscores_</code> for <em>italics</em> and <code>__double underscores__</code> for <b>emphasis</b></li>
                <li>Remember to press the <code>return</code> key twice for a new paragraph, not just once.</li>
                <li>Use `backticks` for <code>small one-line code blocks</code></li>
                <li>You can just type normally, and Markdown shouldn't affect anything too much if you don't want it to.</li>
                <li>You can make unordered lists by using <code> - item in list</code>. Remember a space in front of the "-"!</li>
                <li>Ordered lists are similar, you can use <code> 1. item in list</code>, incrementing the number for each line.</li>
                <li>Use headers (&lt;h1&gt;, &lt;h2&gt;, etc.) using <code># header1</code>, <code>## header2</code>, etc. Remember, h1 is bigger than h2, which is bigger than h3, not the other way around!</li>
                <li>
                    We also have syntax highlighting (using <a href="http://craig.is/making/rainbows">Rainbows</a>). Simply use <code>{language}Your code goes here!{/language}</code> to use syntax highlighting for your code blocks! (For example, <code>{python}print "Hello!"{/python}</code>). <span class="show-toggle" data-for="languages"><a>Languages supported...</a></span><ul id="languages" style="display: none"><li>c</li><li>shell</li><li>java</li><li>d</li><li>coffeescript</li><li>generic</li><li>scheme</li><li>javascript</li><li>r</li><li>haskell</li><li>python</li><li>html</li><li>smalltalk</li><li>csharp</li><li>go</li><li>php</li><li>ruby</li><li>lua</li><li>css</li><li>terminal</li></ul>
                </li>
                <li>You can create boxes for different colored notices with <code>{boxname}Hey! Stuff goes here!{/boxname}</code>. <a><span class="show-toggle" data-for="color-boxes">Box types...</span></a><ul id="color-boxes"><li><span class="alert alert-info">info</span></li><li><span class="alert alert-error">error</span></li><li><span class="alert alert-success">success</span></li><li><span class="alert">alert</span></li></ul></li>
                <li>Use <code>{red}red text{/red}</code> to use <span class="red">red text</span>. We'll expand upon this at some point.</li>
            </ul>
        </div>
    </div>
    <label for="category">What would you categorize this under? (Choose a broad term and tag more specific terms)</label>
    <input id="category" name="category" type="text" value="<?=htmlspecialchars($page->getCategory())?>"/>
    <label for="tags">Tags (Separate with ', ')</label>
    <input id="tags" name="tags" type="text"/>
    <ul id="tutorial-tags" class="tags blue">
        <?php foreach($page->getTags() as $tag): ?>
        <li class="add-tag" data-tag="<?=htmlspecialchars($tag)?>"><a><?=htmlspecialchars($tag)?> <span>X</span></a></li>
        <?php endforeach; ?>
    </ul>
    <span id="tags-data" style="display: none;"><?=sizeof($page->getTags()) < 1 ? '' : implode(',', $page->getTags());?></span>
    <!--<input id="ip" name="ip" value="<?//=$_SERVER['REMOTE_ADDR']?>">--> <!-- hidden, this will be the last edited person. -->
    <br/>
    <button id="submit-tutorial" type="submit">Re-Submit!</button>
</form>
</div>
<?php
} catch(PredisPageDoesNotExistException $e){
    echo "Tutorial not found.";
}
else: ?>
    <div class="margined">
        <h3>No tutorial found to edit</h3>
        <p>I don't know which tutorial you're trying to edit, there's no ID in the title or this site is not set up correctly.</p>
    </div>
<?php endif; ?>