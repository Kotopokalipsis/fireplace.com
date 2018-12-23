$('.add-comment').on('beforeSubmit', function(){
    var data = $(this).serializeArray();
    var buttonID = $(this).attr('data-id');
    data.push({name: "CommentForm[post_id]", value: $(this).attr('data-id')});
    $.ajax({
        url: '/post/comment/add-comment',
        type: 'POST',
        data: data,
        success: function(res){
            $('.row-comments[data-id='+ buttonID +']').append("<a href='" + res['comment']['nickname'] + "'><h4>" + res["comment"]["nickname"] + "</h4></a>")
                .append("<p>" + res["comment"]["content"] + "</p>")
                .append("<small>" + res["comment"]["creation_time"] + "&nbsp;</small>")
                .append("<button class='btn btn-xs btn-warning delete-comment' data-id='"+ res["comment"]["id"] +"'>Delete comment</button>")
                .append("<hr>");
            $('.form-control[data-id='+ buttonID +']').val('');
        },
    });
    return false;
});

$('.delete-comment').click(function() {
    var params = {
        'id' : $(this).attr('data-id'),
    };
    $.ajax({
        url:'/post/comment/delete-comment',
        type: 'POST',
        data: params,
        success: function(res) {
            $('.comment[data-id='+params['id']+']').hide();
        },
    });
    return false;
});