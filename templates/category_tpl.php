<div class="margined">
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
