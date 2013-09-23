<div class="margined">
    <div class="span9">
<?php
foreach($pass as $tag){
    $tag = urldecode($tag);
}
foreach($found = $tutorials->tagSearch($tutorials->getAllPages(), $pass) as $result){
   $tutorials->html_printTutorialLink($tutorials->page($result));
}
if(empty($found)){
    echo "<h3>No tutorials found</h3>";
    echo "<p>It doesn't look like we have any tutorials tagged with that tag.</p>";
}
?>
    </div>
    <div class="span3 group-sample">
        <h4>You're browsing tutorials tagged with <code><?=urldecode(implode(', ', $pass))?></code>!</h4>
        <p>Hello World!</p>
        <!--Ads here? something cool can go here.-->
    </div>
</div>
