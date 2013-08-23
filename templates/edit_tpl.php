<?php
try {
    $page = $tutorials->page($pass[0]);
?>
<form method="post" action="/edit_submit.php">
    <label for="id">ID</label>
    <input id="id" name="id" type="number" value="<?=$page->getId()?>" readonly>
    <label for="username">Your username</label>
    <input id="username" name="username" type="text" value="<?=$page->getUsername()?>"/>
    <label for="title">Title</label>
    <input id="title" name="title" type="text" value="<?=$page->getTitle()?>"/>
    <label for="description">Description/Subtitle</label>
    <input id="description" name="description" type="text" value="<?=$page->getDescription()?>"/>
    <div class="row-fluid">
        <div class="span7">
            <label for="text">Tutorial</label>
            <textarea id="text" name="text" rows="25" class="tutorial-editor"><?=$page->getText()?></textarea>
            <button class="markdown-test" type="button">Preview your Markdown!</button>
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
                    We also have syntax highlighting (using <a href="http://craig.is/making/rainbows">Rainbows</a>). Simply use <code>&lt;pre data-language="yourlanguage"&gt;Your code goes here!&lt;/pre&gt;</code> to use syntax highlighting for your code blocks! <span class="show-toggle" for="languages"><a>Languages supported...</a></span><ul id="languages" style="display: none"><li>c</li><li>shell</li><li>java</li><li>d</li><li>coffeescript</li><li>generic</li><li>scheme</li><li>javascript</li><li>r</li><li>haskell</li><li>python</li><li>html</li><li>smalltalk</li><li>csharp</li><li>go</li><li>php</li><li>ruby</li><li>lua</li><li>css</li></ul>
                </li>
            </ul>
        </div>
    </div>
    <label for="download">Downloadable Script</label>
    <textarea id="download" name="download" rows="25"><?=$page->getDownload();?></textarea>
    <label for="tags">Tags (Separate with ', ')</label>
    <input id="tags" name="tags" type="text" value="<?=implode(', ', $page->getTags())?>"/>
    <!--<input id="ip" name="ip" value="<?//=$_SERVER['REMOTE_ADDR']?>">--> <!-- hidden, this will be the last edited person. -->
    <br/>
    <button type="submit">Re-Submit!</button>
</form>
<?php
} catch(PredisPageDoesNotExistException $e){
    echo "Tutorial not found.";
}