//jQuery
try {
    window.$ = window.jQuery = require('jquery');
} catch (error) {
    console.log(error);
}

//Tooltipster
import tooltipster from 'tooltipster';
window.tooltipster = tooltipster;

// Bootstrap - carousel
import carousel from 'bootstrap/js/dist/carousel';
window.carousel = carousel;

//Axios
import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

//slick - carousel
import slick from 'slick-carousel';
window.slick = slick;

$(document).ready(function(){
  
  //icone de localização mobile/desktop
  if ($(window).width() < 768) {
    var imgLoc = '/images/mobile/loc.png';
    var ttTrigger = 'click'
  } else {
    var imgLoc = '/images/loc.png';
    var ttTrigger = 'hover';
  }
  
  //carousel bootstrap
  $('.carousel').carousel({
    interval: 5000
  });

  //carousel slick
    $(".carouselAgenda").slick({
      centerMode: true,
      centerPadding: "100px",
      slidesToShow: 3,
      responsive: [
        {
          breakpoint: 768,
          settings: "unslick"
        }
      ]
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

  //removeClass mobile
  if ($(window).width() < 768) {
    $(".col-fix-9").removeClass('col-fix-9');
    $(".col-fix-3").removeClass("col-fix-3");
    console.log("etc")
  }


});
