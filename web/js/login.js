$('button[type="submit"]').on('click', function(e) {
    $('.loading').css({display: 'block'});
});

$('form').on('DOMSubtreeModified', '.help-block', function() {
    if ($(this).text().length > 0) {
        $('.loading').css({display: 'none'});
    }
});
