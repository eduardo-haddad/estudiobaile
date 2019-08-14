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
  
  if ($(window).width() < 768) {
    var imgLoc = '/images/mobile/loc.png';
    var ttTrigger = 'click'
  } else {
    var imgLoc = '/images/loc.png';
    var ttTrigger = 'hover';
  }
  
  console.log(ttTrigger);

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
    contentCloning: true,
    trigger: ttTrigger,
  });

  // Tooltip hover image

  $(document).on({
    mouseenter: function(){
        $('.loc').css({'background-image': 'url("/images/loc_hov.png")'});
    },
    mouseleave: function(){
        $(".loc").css({
          "background-image": `url('${imgLoc}')`
        });
    }
  }, '.loc, .tooltipster-base');
  // Force show original image
  $('html').not('.loc, .tooltipster-base').mouseenter(function(){
      $(".loc").css({ "background-image": `url('${imgLoc}')` });
  });

  // Menu Mobile
  var menu_aberto = false;

  $(".toggleMenu").click(function(){

    if(menu_aberto == false){
      $('#menuMobile').removeClass('d-none');
      menu_aberto = true;
    } else {
      $('#menuMobile').addClass('d-none');
      menu_aberto = false;
    }

  });

});
