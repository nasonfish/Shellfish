<h3>Search Results</h3>
<?php
$search = $tutorials->getPeregrine()->get->getRaw('q');
foreach($tutorials->search($search) as $id => $result){ // TODO limit, pagination
    $tutorials->html_printTutorialLink($tutorials->page($result));
}