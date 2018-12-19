$('textarea').each(function () {
    this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;overflow-y:hidden;');
}).on('input', function () {
    this.style.height = 'auto';
    this.style.height = (this.scrollHeight) + 'px';
    this.style.resize = 'none';
});
$('textarea').trigger('input');

pasoActual = $('.field-pasos-texto');
divNuevo = '';
var pasoRef = pasoActual.clone();
var contador = $('.pasos').length - 1;
if (contador >= 1) {
    $('.btn-borrar-paso').show();
}
divNuevo = $('.entorno-paso-' + (contador+1));

$('.col-md-5').on('click', '.fileinput-remove', function () {
    var divPadre = $(this).parents('.col-md-5');
    idInput = divPadre.find('input[type=file]').attr('id');
    var inputHidden = $("<input>", {
        'name': idInput,
        'type': 'hidden'
    });
    divPadre.append(inputHidden);
});

$('.field-recetas-foto').on('click', '.fileinput-remove', function () {
    var divPadre = $(this).parents('.field-recetas-foto');
    idInput = divPadre.find('input[type=file]').attr('id');
    var inputHidden = $("<input>", {
        'name': idInput,
        'type': 'hidden'
    });
    divPadre.append(inputHidden);
});

$('.btn-anadir-paso').on('click', function() {
    // if(pasoActual.find('textarea').val() == '') {
    //     krajeeDialog.alert('El paso no puede estar vacio.');
    //     return;
    // }
    contador += 1;
    var pasoNuevo = pasoRef.clone();
    var textArea = pasoNuevo.find('textarea');
    // Div nuevo
    divNuevo = $("<div>", {
        'class': 'entorno-paso-' + (contador+1)
    });
    divNuevo.hide();
    $('.entorno-paso-' + contador).after(divNuevo);

    // Paso nuevo
    textArea.val('');
    textArea.attr('name', 'Pasos[' + contador + ']');
    textArea.attr('id', 'pasos-texto-' + contador);
    textArea.parent().removeClass('field-pasos-texto');
    textArea.parent().addClass('field-pasos-texto-' + contador);
    pasoNuevo.find('.label'). text(contador+1);
    divNuevo.append(pasoNuevo);

    var div2 = $("<div>", {
        'class': 'row paso-foto-' + (contador+1)
    });
    divNuevo.append(div2);

    var div3 = $("<div>", {
        'class': 'col-md-5'
    });
    div2.append(div3);

    var div4 = $("<div>", {
        'class': 'form-group field-pasos-foto-' + (contador+1)
    });
    div3.append(div4);

    // Foto nueva
    var fotoNueva = '<input type="file" id="pasos-foto-' + contador + '" name="Pasos[foto' + contador + ']" accept="image/jpeg" />';
    div4.append(fotoNueva);

    $('#pasos-foto-' + contador).fileinput('enable');
    $('#pasos-foto-' + contador).fileinput('refresh', {
        browseOnZoneClick: true,
        dropZoneTitle: 'Sube la foto del paso',
        dropZoneClickTitle: '',
        showPreview: true,
        showCaption: false,
        showRemove: false,
        showUpload: false,
        showBrowse: false,
    });

    divNuevo.slideDown(400, function() {
        $('.btn-borrar-paso').show();
        textArea.focus();
    });
    pasoActual = pasoNuevo;

    $("#form").yiiActiveForm("add",{
        "id": "pasos-texto-" + contador,
        "name": "Pasos[" + contador + "]",
        "container": ".field-pasos-texto-" + contador,
        "input": "#pasos-texto-" + contador,
        "error": ".help-block",
        "validate": function(attribute, value, messages, deferred, $form) {
            yii.validation.required(value, messages, {
                "message": "Paso no puede estar vacío."
            });
            yii.validation.string(value, messages, {
                "message": "Paso debe ser una cadena de caracteres.",
                "max": 10000,
                "tooLong": "Paso debería contener como máximo 10,000 letras.",
                "skipOnEmpty": 1
            });
        }
    });
});

$('.btn-borrar-paso').on('click', function() {
    krajeeDialog.confirm("¿Está seguro que quiere borrar el paso?", function (result) {
        if (result) {
            $("#form").yiiActiveForm("remove",{
                "id": "pasos-texto-" + contador
            });
            contador -= 1;
            if (contador == 0) {
                $('.btn-borrar-paso').hide();
            }
            divNuevo.slideUp(400, function() {
                divNuevo.remove();
                divNuevo = $('.entorno-paso-' + (contador+1));
                pasoActual = contador != 0 ? $('.field-pasos-texto-' + (contador)): $('.field-pasos-texto');
            });
        }
    });
});
