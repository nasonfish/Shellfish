$('.showall').click(function(){
    $('#' + $(this).attr('for') + '-dot').hide();
    $('#' + $(this).attr('for') + '-truncated').hide();
    $('#' + $(this).attr('for')).show();
    $(this).hide();
});

$('.markdown-test').click(function(){
    var elem = $(this);
    var old = $('#md-preview');
    var displayNew = function(){
        $.post('ajax_markdown.php', {text: $('#text').val()})
            .done(function(data){
                elem.after('<div id="md-preview" style="display: none;">' + data + '</div>');
                $('#md-preview').slideDown("slow");
                old.remove();
            });
    };
    if(old.length != 0){ // Check if there are any md-preview elements on the page.
        old.slideUp("slow", displayNew);
    } else {
        displayNew();
    }
    Rainbow.color();
});

$('.show-toggle').click(function(){
    $('#' + $(this).attr('for')).slideToggle();
});