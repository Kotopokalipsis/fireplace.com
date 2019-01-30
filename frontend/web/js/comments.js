$('.add-comment').on('beforeSubmit', function(){
    var data = $(this).serializeArray();
    var post_id = $(this).attr('post-id');
    data.push({name: "CommentForm[post_id]", value: $(this).attr('post-id')});
    $.ajax({
        url: '/post/comment/add-comment',
        type: 'POST',
        data: data,
        success: function(res){
            _.templateSettings.variable = "rc";
            var template = _.template(
                $( 'script.template[post-id='+post_id+']' ).html()
            );
            var element = $( ".row-comment[post-id="+post_id+"]" );
            if (element.length > '0'){
                element.last().after(template(res));
            }
            else {
                $('.row-content[post-id='+post_id+']').after(template(res));
            };
        },
    });
    return false;
});
$('.main').on('click', '.delete-comment', function(){
    var comment_id = {
        'id' : $(this).attr('comment-id'),
    };
    $.ajax({
        url:'/post/comment/delete-comment',
        type: 'POST',
        data: comment_id,
        success: function(res) {
            $('.row-comment[comment-id='+comment_id['id']+']').hide();
        },
    });
    return false;
});