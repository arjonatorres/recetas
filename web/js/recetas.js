$('textarea').each(function () {
    this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;overflow-y:hidden;');
}).on('input', function () {
    this.style.height = 'auto';
    this.style.height = (this.scrollHeight) + 'px';
    this.style.resize = 'none';
});
$('textarea').trigger('input');

pasoActual = $('.field-pasos-texto');
var pasoRef = pasoActual.clone();
var contador = 0;

$('.btn-anadir-paso').on('click', function() {
    if(pasoActual.find('textarea').val() == '') {
        return;
    }
    contador += 1;
    var pasoNuevo = pasoRef.clone();
    var textArea = pasoNuevo.find('textarea');
    textArea.attr('name', 'Pasos[' + contador + ']');
    textArea.attr('id', 'pasos-texto-' + contador);
    textArea.parent().removeClass('field-pasos-texto');
    textArea.parent().addClass('field-pasos-texto-' + contador);
    pasoNuevo.css('margin-top', '-30px');
    pasoNuevo.hide();
    pasoNuevo.find('.label'). text(contador+1);
    pasoActual.after(pasoNuevo);
    pasoNuevo.slideDown(400, function() {
        $('.btn-borrar-paso').show();
        textArea.focus();
    });
    pasoActual = pasoNuevo;

    $("#w0").yiiActiveForm("add",{
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
    console.log('borrar');
    $("#w0").yiiActiveForm("remove",{
        "id": "pasos-texto-" + contador
    });
    contador -= 1;
    if (contador == 0) {
        $('.btn-borrar-paso').hide();
    }
    pasoActual.slideUp(400, function() {
        pasoActual.remove();
        pasoActual = contador != 0 ? $('.field-pasos-texto-' + (contador)): $('.field-pasos-texto');
    });
});
