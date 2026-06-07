new Swiper('.card-wrapper', {
  // Optional parameters
  loop: true,
  spaceBetween : 30,
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
    768 : {slidesPerView:3},
    1024: {slidesPerView:4}
  },
   autoplay: {
   delay: 3000,
  }, 

});