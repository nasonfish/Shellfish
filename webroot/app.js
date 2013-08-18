$('.showall').click(function(){
    $('#' + $(this).attr('for') + '-dot').hide();
    $('#' + $(this).attr('for')).slideDown();
    $(this).hide();
});