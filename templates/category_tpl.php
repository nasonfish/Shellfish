<div class="margined">
    <div class="span9">
<?php
if(isset($pass[0])){
    foreach($tutorials->categorySearch($tutorials->getAllPages(), strtolower($pass[0])) as $result){
        $tutorials->html_printTutorialLink($tutorials->page($result));
    }
} else {
    print "<h3>Category not found</h3>";
    print "<p>It doesn't look like a category was specified.</p>";
}
?>
    </div>
    <div class="span3 group-sample">
        <h4>You're browsing tutorials categorized under <code><?=$pass[0]?></code>!</h4>
        <p>Hello World!</p>
        <!--Ads here? something cool can go here.-->
    </div>
</div>
