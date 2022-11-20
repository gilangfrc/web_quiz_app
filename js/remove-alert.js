$(function () {
    var i = 3;
    var timer = setInterval(function() {
        if (i == 0) {
            $('#alert').animate({
                'opacity' : '0'
            }, 500)
            $('#alert-area').html('');
            clearInterval(timer);
        }
        i--;
    }, 1000);
});