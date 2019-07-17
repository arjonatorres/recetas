pulsado = 0;
avanzada = false;

$('.busqueda-avanzada').on('click', function() {
    $(this).toggleClass('busqueda-avanzada-activada');
    $(this).toggleClass('busqueda-avanzada');
    $('.adv-search').slideToggle('slow');
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

$(function () {
    var lastScrollTop = 0;
    var $navbar = $('.navbar');

    $(window).scroll(function(event){
        var st = $(this).scrollTop();

        $navbar.stop();
        if (st > lastScrollTop && (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100)) {
            $navbar.fadeOut();
        } else {
            $navbar.fadeIn();
        }
        lastScrollTop = st;
    });
});

window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
        $('.scrollTop').css({display: 'block'});
    } else {
        $('.scrollTop').css({display: 'none'});
    }
}

function topFunction() {
    $('html, body').animate({scrollTop: 0});
}

$('.scrollTop').on('click', topFunction);