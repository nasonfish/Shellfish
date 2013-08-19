<?php
print($tutorials->html_downloadLink($tutorials->page($_GET['id'])));

print($tutorials->html_printTags($tutorials->page($_GET['id'])));