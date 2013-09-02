<div class="margined">
<?php

foreach($tutorials->categorySearch($tutorials->getAllPages(), strtolower($pass[0])) as $result){
    $tutorials->html_printTutorialLink($tutorials->page($result));
}
?>
</div>