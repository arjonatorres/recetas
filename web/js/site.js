pulsado = 0;
avanzada = false;

$('.busqueda-avanzada').on('click', function() {
    $(this).toggleClass('busqueda-avanzada-activada');
    $(this).toggleClass('busqueda-avanzada');
    $('.adv-search').toggle('slow');
    if (pulsado == 0 && !avanzada) {
        setTimeout(function(){
            $("#recetassearch-etiqueta").trigger('change');
        }, 1000);
    }
    pulsado = 1;
});

$( document ).ready(function() {
   if ($('.adv-search').css('display') != 'none') {
       $('.busqueda-avanzada').toggleClass('busqueda-avanzada-activada');
       $('.busqueda-avanzada').toggleClass('busqueda-avanzada');
       avanzada = true;
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