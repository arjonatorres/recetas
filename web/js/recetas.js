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
    textArea.attr('style', 'height:' + (textArea.scrollHeight) + 'px;overflow-y:hidden;');
    textArea.on('input', function () {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
        this.style.resize = 'none';
    });
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
    div4.append('<div class="help-block"></div>');

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

    $("#form").yiiActiveForm("add",{
        "id": "pasos-foto-" + contador,
        "name": "Pasos[foto" + contador + "]",
        "container": ".field-pasos-foto-" + (contador+1),
        "input": "#pasos-foto-" + contador,
        "error": ".help-block",
        "validate": function(attribute, value, messages, deferred, $form) {
            yii.validation.file(attribute, messages, {
                "message":"Falló la subida del archivo.",
                "skipOnEmpty":true,
                "mimeTypes":[],
                "wrongMimeType":"Sólo se aceptan archivos con los siguientes tipos MIME: .",
                "extensions":["jpg"],
                "wrongExtension":"Sólo se aceptan archivos con las siguientes extensiones: jpg",
                "maxFiles":1,
                "tooMany":"Puedes subir como máximo 1 archivo."
            });
            yii.validation.file(attribute, messages, {
                "message":"La foto tiene que ser menor de 1MB",
                "skipOnEmpty":true,
                "mimeTypes":[],
                "wrongMimeType":"Sólo se aceptan archivos con los siguientes tipos MIME: ."
                ,"extensions":[],
                "wrongExtension":"Sólo se aceptan archivos con las siguientes extensiones: ",
                "maxSize":8388608,
                "tooBig":"El archivo \"{file}\" es demasiado grande. Su tamaño no puede exceder 1 MiB.",
                "maxFiles":1,
                "tooMany":"Puedes subir como máximo 1 archivo."
            });
        }
    });
});

$('.btn-borrar-paso').on('click', function() {
    krajeeDialog.confirm("¿Está seguro que quiere borrar el paso?", function (result) {
        if (result) {
            $("#form").yiiActiveForm("remove", "pasos-texto-" + contador);
            $("#form").yiiActiveForm("remove", "pasos-foto-" + contador);
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

$('#boton-receta').on('click', function(e) {
    $('.loading').css({display: 'block'});
    e.preventDefault();
    if ($('.field-recetas-foto').find('img').length > 0){
        $('.field-recetas-foto').removeClass('has-error');
        $('.field-recetas-foto').addClass('has-success');
        borrarFotos();
        if ($('#recetas-source_url').val() != "") {
            if ($('.pasos').length == 1) {
                if ($('#pasos-texto').val() == "") {
                    $('#form').yiiActiveForm('remove', 'pasos-texto');
                    $('#form').yiiActiveForm('remove', 'pasos-texto-0');
                }
            }
        } else {
            if ($('#form').yiiActiveForm('find', 'pasos-texto') == undefined) {
                $("#form").yiiActiveForm("add",{
                    "id": "pasos-texto",
                    "name": "Pasos[0]",
                    "container": ".field-pasos-texto",
                    "input": "#pasos-texto",
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
            }
        }
        $('#form').submit();
    } else {
        $('.field-recetas-foto').removeClass('has-success');
        $('.field-recetas-foto').addClass('has-error');
        $('.field-recetas-foto').find('.help-block').text('Foto principal no puede estar vacío.');
        $('html, body').animate({scrollTop:0}, 'slow');
    }
});

$('.recetas-form').on('click', '.kv-file-remove', function() {
    var padre = $(this).parents('.file-preview');
    boton = padre.find('button.fileinput-remove');
    boton.trigger('click');
});

$('.recetas-form').on('DOMSubtreeModified', '.help-block', function() {
    if ($(this).text().length > 0) {
        $('.loading').css({display: 'none'});
    }
});

function borrarFotos() {
    $('.file-input').each(function() {
        if ($(this).find('img').length == 0) {
            var divPadre = $(this).parents('.form-group');
            idInput = divPadre.find('input[type=file]').attr('id');
            var inputHidden = $("<input>", {
                'name': idInput,
                'type': 'hidden'
            });
            divPadre.append(inputHidden);
        }
    });
}
