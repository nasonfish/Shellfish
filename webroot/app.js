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
    while($(this).val().indexOf(',') != -1){
        $(this).val($(this).val().replace(',',''));
    }
    if(event.keyCode == 188){
        event.preventDefault();
        if($(this).val() == ""){
            return;
        }
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

$('#submit-tutorial').click(function(event){
    $('#form-errors').remove();
    $('#tags').val($('#tags-data').html());
    // Places: title, description, text, category
    var errors = [];
    if($('#title').val() == ""){
        errors.push('Title field is blank.');
    }
    if($('#description').val() == ""){
        errors.push('Description field is blank.');
    }
    if($('#text').val() == ""){
        errors.push('Tutorial is blank. There\'s got to be something the user has to do!');
    }
    if($('#category').val() == ""){
        errors.push('Category field is blank.');
    }
    if(errors.length != 0){
        event.preventDefault();
        var error = "";
        for(var i = 0; i < errors.length; i++){
            error += "<li>" + errors[i] + "</li>";
        }
        $(this).after('<div class="alert alert-error" id="form-errors"><ul>'+error+'</ul></alert>');
    }
});

$('.show-toggle').click(function(){
    $('#' + $(this).attr('for')).slideToggle();
});

$('.link').click(function(){
    window.location.href = $(this).attr('data-href');
});