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

//Slick
import slick from 'slick-carousel';
window.slick = slick;

//Swipebox
import swipebox from 'swipebox';
window.swipebox = swipebox;

$(document).ready(function(){
  
  //Swipebox
  // $(document).swipebox({ selector: ".swipebox" });
  
  //icone de localização mobile/desktop
  if ($(window).width() < 768) {
    var imgLoc = '/images/mobile/loc.png';
    var ttTrigger = 'click'
  } else {
    var imgLoc = '/images/loc.png';
    var ttTrigger = 'hover';
  }

  //removeClass mobile
  if ($(window).width() < 768) {
    $(".col-fix-9").removeClass('col-fix-9');
    $(".col-fix-3").removeClass("col-fix-3");
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

  //hover galeria
  $(".hoverThumb").hover(function() {
    $(this).toggleClass("transparente");
  });

  //abrir cartela pop-up da agenda
  $(".abrir").click(function() {
    $(this)
      .parents()
      .siblings('.conteudo')
      .addClass('d-md-block')
  });

  //fechar cartela pop-up da agenda com clique
  $(".fechar").click(function() {
    $(this)
      .parent(".conteudo")
      .removeClass('d-md-block');
  });
  
  //fechar com ESC
  $(document).keyup(function(e) {
     if (e.key === "Escape") { // escape key maps to keycode `27`
      $(".conteudo")
      .removeClass('d-md-block');
    }
  });

  //toggle slide da agenda mobile
  $('.atividade').click(function(){
    $(this).toggleClass('data');
    $(this).siblings('.eventoMobile').toggleClass('d-none');
  });

  //botão fechar da slide da agenda mobile
  $(".fecharMob").click(function() {
    $(this) // 
      .parent(".eventoMobile")
      .toggleClass("d-none");
    $(this)  // 
      .parent()
      .siblings('.eventoMobile')
      .toggleClass("d-none");
    $(this) // alterna sublinhado do texto
      .parent()
      .siblings('.atividade')
      .toggleClass("data");

  });

});
