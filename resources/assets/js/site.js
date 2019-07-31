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

    $('.tooltipster').tooltipster({
        theme: ['tooltipster-noir', 'tooltipster-noir-customized'],
        contentAsHTML: true,
        content: tt,
        // animationDuration: 100000,
    });

});