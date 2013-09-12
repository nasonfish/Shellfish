<div class="margined">
<?php
foreach($found = $tutorials->tagSearch($tutorials->getAllPages(), $pass) as $result){
   $tutorials->html_printTutorialLink($tutorials->page($result));
}
if(empty($found)){
    echo "<h3>No tutorials found</h3>";
    echo "<p>It doesn't look like we have any tutorials tagged with that tag.</p>";
}
?>
</div>
