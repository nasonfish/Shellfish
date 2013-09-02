<?php
$pagination = 10;
$page = $tutorials->getPeregrine()->get->getInt('page');
$page = $page ? $page : 1;
if($page != 1){
    echo '<form><button type="submit" name="page" value="'.($page - 1).'" class="prev pagination">Previous Page</button></form>';
}
if(sizeof($tutorials->getAllPages()) > ($page * $pagination)){
    echo '<form><button type="submit" name="page" value="'.($page + 1).'" class="next pagination">Next Page</button></form>';
}
?>
</div> <!-- from all_tpl.php -->