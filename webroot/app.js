$('.showall').click(function(){
    $('#' + $(this).attr('for') + '-dot').hide();
    $('#' + $(this).attr('for')).slideDown();
    $(this).hide();
});

$('.markdown-test').click(function(){
    var elem = $(this);
    $('#md-preview').remove();
    $.post('ajax_markdown.php', {text: $('#text').val()})
    .done(function(data){
        elem.after('<div id="md-preview">' + data + '</div>');
    });
});