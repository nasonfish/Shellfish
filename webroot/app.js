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
        $.post('/ajax_markdown.php', {text: $('#text').val()})
            .done(function(data){
                elem.after('<div id="md-preview" style="display: none;">' + data + '</div>');
                $('#md-preview').slideDown("slow");
                old.remove();
                Rainbow.color();
            });
    };
    if(old.length != 0){ // Check if there are any md-preview elements on the page.
        old.slideUp("slow", displayNew);
    } else {
        displayNew();
    }
});

$('.categories-item').click(function(){
    var category = $(this).attr('data-for');
    $('.categories-right').slideUp("slow", function(){
        $(this).empty();
        $.post('/ajax_category.php', {category: category})
        .done(function(data){
            var right = $('.categories-right');
            right.html(data);
            right.slideDown();
        });
    });
});

$('#tags').keydown(function(event){
    if(event.keyCode == 188){
        event.preventDefault();
        var tag = $(this).val();
        var data = $('#tags-data');
        var oldtags = data.html();
        for(var i = 0; i < oldtags.split(',').length; i++){
            if(oldtags.split(',')[i] == tag){
                // do something
                return;
            }
        }
        $('#tutorial-tags').append('<li class="add-tag" data-tag="'+tag+'"><a>'+tag+' <span>X</span></a></li>');
        $(this).val('');
        var tags = oldtags.split(',');
        tags.push(tag);
        data.html(tags.join(','));
    }
});

$('#tutorial-tags').on('click', '.add-tag', function(){
    var remove = $(this).attr('data-tag');
    $(this).remove();
    var data = $('#tags-data');
    var oldtags = data.html();
    var tags = oldtags.split(',');
    for(var i = 0; i < tags.length; i++){
        if(tags[i] == remove){
            tags.splice(i, i == 0 ? 1 : i);
        }
    }
    data.html(tags.join(','));
});

$('#submit-tutorial').click(function(){
    $('#tags').val($('#tags-data').html());
});

$('.show-toggle').click(function(){
    $('#' + $(this).attr('for')).slideToggle();
});

$('.link').click(function(){
    window.location.href = $(this).attr('data-href');
});