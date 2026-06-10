new Swiper('.card-wrapper', {
  // Optional parameters
  loop: true,
  spaceBetween : 20,
  centeredSlides: false ,
  watchOverflow: true,
  observer: true,
  observeParents: true,

  on: {
    init: function () {
      this.update();
    }
  },
  freeMode: {
  enabled: true,
  sticky: true
  },

  // If we need pagination
  pagination: {
    el: '.swiper-pagination',
    clickable: true,
    dynamicBullets: true
  },

  // Navigation arrows
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },
  breakpoints:{
    0 : {slidesPerView:1},
    550 : {slidesPerView:2},
    950 : {slidesPerView:3},
    1150 : {slidesPerView:4},
    1550:{slidesPerView:5}
  },

   autoplay: {
   delay: 3000,
  }, 

});