<?php
require '../Markdown/Michelf/MarkdownExtra.php';
$md = new \Michelf\MarkdownExtra();

function syntax($text){
    $text = str_replace('<', '&lt;', $text);
    $text = str_replace('>', '&gt;', $text);
    $langs = array('c', 'shell', 'java', 'd', 'coffeescript', 'generic', 'scheme', 'javascript', 'r', 'haskell', 'python', 'html', 'smalltalk', 'csharp', 'go', 'php', 'ruby', 'lua', 'css');
    foreach($langs as $lang){
        $text = str_replace('{'.$lang.'}', '<pre data-language="'.$lang.'">', $text);
        $text = str_replace('{/'.$lang.'}', '</pre>', $text); // bad :/
    }
    return $text;
}
print $md->defaultTransform(syntax($_POST['text']));