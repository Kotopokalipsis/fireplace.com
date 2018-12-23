$('.btn-sub').click(function() {
    var nickname = window.location.pathname.replace('/profile/', '');
    var data = {
        'nickname' : nickname,
    };
    console.log(data);
    $.ajax({
        url: '/user/profile/subscribe',
        type: 'POST',
        data: data,
        success: function(res) {
            $('.btn-sub').hide();
            $('.btn-unsub').show();
        }
    });
    return false;
});

$('.btn-unsub').click(function() {
    var nickname = window.location.pathname.replace('/profile/', '');
    var data = {
        'nickname' : nickname,
    };
    console.log(data);
    $.ajax({
        url: '/user/profile/unsubscribe',
        type: 'POST',
        data: data,
        success: function(res) {
            $('.btn-sub').show();
            $('.btn-unsub').hide();
        }
    });
    return false;
});