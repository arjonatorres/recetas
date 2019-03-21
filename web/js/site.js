$('.busqueda-avanzada').on('click', function() {
    $(this).toggleClass('busqueda-avanzada-activada');
    $(this).toggleClass('busqueda-avanzada');
    $('.adv-search').toggle('slow');
});

$( document ).ready(function() {
   if ($('.adv-search').has('.panel')) {
       $('.busqueda-avanzada').toggleClass('busqueda-avanzada-activada');
       $('.busqueda-avanzada').toggleClass('busqueda-avanzada');
   } else {
       // console.log('no tiene');
   }
});

// $('field-recetassearch-etiqueta select2-selection__clear').on('click', '');
$('#advanced-search .reset').on('click', function(e) {
    e.preventDefault();
    $('#advanced-search .form-control').each(function() {
        if ($(this).attr('id') != 'recetassearch-etiqueta') {
            $(this).val('');
        }
    });
    $('#recetassearch-etiqueta').val('').trigger('change');
});