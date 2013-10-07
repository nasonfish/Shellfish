<script>
    window.onload = function(){
        simpleAJAX('/admin_data.php', 'POST', {id:simpleDOM('#page-id').html()}, function(data){
            simpleDOM('.data').html(data);
            simpleDOM('.detach').bind('click', function(){ // So this actually is bound.
                var elem = simpleDOM(this);
                simpleAJAX('/admin_detach.php', 'POST', {id: elem.attr('data-id'), subid: elem.attr('data-subid')}, function(data){
                    this.parentNode.hide();
                });
            });
        });
    };
</script>