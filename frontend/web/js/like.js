$('.btn-like').click(function(){
    var button = $(this).attr('data-id');
    var params = {
        'id' : $(this).attr('data-id'),
    };
    $.ajax({
        url: '/post/default/like',
        data: params,
        type: 'POST',
        success: function(res){
            $('.btn-like[data-id='+button+']').hide();
            $('.btn-unlike[data-id='+button+']').show().html('<i class="fas fa-heart">&nbsp;</i>'+res['countLikes']);
        },
        error: function(res){
        }
    });
});
$('.btn-unlike').click(function(){
    var button = $(this).attr('data-id');
    var params = {
        'id' : $(this).attr('data-id'),
    };
    $.ajax({
        url: '/post/default/unlike',
        data: params,
        type: 'POST',
        success: function(res){
            $('.btn-like[data-id='+button+']').show().html('<i class="fas fa-heart">&nbsp;</i>'+res['countLikes']);
            $('.btn-unlike[data-id='+button+']').hide();
        },
        error: function(res){
        }
    });
});
