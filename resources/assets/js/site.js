//jQuery
try {
    window.$ = window.jQuery = require('jquery');
} catch (error) {
    console.log(error);
}

//Tooltipster
import tooltipster from 'tooltipster'
window.tooltipster = tooltipster;

// Bootstrap - carousel
import carousel from 'bootstrap/js/dist/carousel';
window.carousel = carousel;

$(document).ready(function(){

    $('.carousel').carousel({
        interval: 5000
    });

    // Tooltipster
    let tt = $('#tooltip_content');

    $(".tooltipster").tooltipster({
      theme: "tooltipster-noir",
      content: tt,
      interactive: true,
      delay: [100, 5],
      distance: 0,
    });

    // Tooltip hover image
    $(document).on({
        mouseenter: function(){
            $('.loc').css({'background-image': 'url("/images/loc_hov.png")'});
        },
        mouseleave: function(){
            $('.loc').css({'background-image': 'url("/images/loc.png")'});
        }
    }, '.loc, .tooltipster-base');
    // Force show original image
    $('html').not('.loc, .tooltipster-base').mouseenter(function(){
        $('.loc').css({'background-image': 'url("/images/loc.png")'});
    });

    // Menu Mobile
});