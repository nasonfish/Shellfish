/*
 print '
 <div class="tutorial">
 <h3 class="tutorial-header"><a class="tutorial-link" href="/tutorial.php?id='.$tutorial->id.'">'.$tutorial->title.'</a></h3>
 <span class="tutorial-description"><i>'.$tutorial->description.'</i></span>
 <div class="tutorial-text">
 <span class="truncatedtext">
 '.substr($tutorial, 0, 100).'
 </span>
 <a class="showall" for="tutorial-id-'.$tutorial->id.'">
 <span class="fulltext" id="tutorial-id-'.$tutorial->id.'">
 '.substr($tutorial, 100).'
 </span>
 </div>
 </div>
 ';
*/

$('.showall').click(function(){
    $('#' + $(this).attr('for')).show();
    $('#' + $(this).attr('for') + '-dot').hide();
    $(this).hide();
});