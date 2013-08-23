<?php
$pagination = 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
if($page != 1){
    echo '<a href="?page='.($page - 1).'" class="prev pagination">Previous Page</a>';
}
if(sizeof($tutorials->getAllPages()) > ($page * $pagination)){
    echo '<a href="?page='.($page + 1).'" class="next pagination">Next Page</a>';
}