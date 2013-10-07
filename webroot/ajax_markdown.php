<?php
require '../Markdown/Michelf/MarkdownExtra.php';
$md = new \Michelf\MarkdownExtra();

function syntax($text){
    $text = str_replace('<', '&lt;', $text);
    $text = str_replace('>', '&gt;', $text);
    $langs = array('c', 'shell', 'java', 'd', 'coffeescript', 'generic', 'scheme', 'javascript', 'r', 'haskell', 'python', 'html', 'smalltalk', 'csharp', 'go', 'php', 'ruby', 'lua', 'css', 'terminal');
    foreach($langs as $lang){
        $text = str_replace('{'.$lang.'}', '<pre data-language="'.$lang.'">', $text);
        $text = str_replace('{/'.$lang.'}', '</pre>', $text); // bad :/
    }
    foreach(array('info', 'error', 'success', 'danger') as $div){
        $text = str_replace('{'.$div.'}', '<div class="alert alert-'.$div.'">', $text);
        $text = str_replace('{/'.$div.'}', '</div>', $text);
    }
    $text = str_replace('{alert}', '<div class="alert">', $text);
    $text = str_replace('{/alert}', '</div>', $text);

    $text = str_replace('{r}', '<span class="red">', $text);
    $text = str_replace('{/r}', '</span>', $text);
    return $text;
}
print $md->defaultTransform(syntax($_POST['text']));
