<?php
$pagination = 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
if($page != 1){
    echo '<form><button type="submit" name="page" value='.($page - 1).'" class="prev pagination">Previous Page</button></form>';
}
if(sizeof($tutorials->getAllPages()) > ($page * $pagination)){
    echo '<form><button type="submit" name="page" value='.($page + 1).'" class="next pagination">Next Page</button></form>';
}