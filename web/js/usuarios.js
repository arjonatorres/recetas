$('button[type="submit"]').on('click', function(e) {
    $('.loading').css({display: 'block'});
});

$('form').on('click', '.kv-file-remove', function() {
    var padre = $(this).parents('.file-preview');
    boton = padre.find('button.fileinput-remove');
    boton.trigger('click');
});

$('form').on('DOMSubtreeModified', '.help-block', function() {
    if ($(this).text().length > 0) {
        $('.loading').css({display: 'none'});
    }
});

$('.field-usuarios-foto').on('click', '.fileinput-remove', function () {
    var divPadre = $(this).parents('.field-usuarios-foto');
    idInput = divPadre.find('input[type=file]').attr('id');
    var inputHidden = $("<input>", {
        'name': idInput,
        'type': 'hidden'
    });
    divPadre.append(inputHidden);
});