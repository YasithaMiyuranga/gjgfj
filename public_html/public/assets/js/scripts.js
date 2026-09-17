(function ($) {
  "use strict";


  // =======Preloader========>>>>>
  let preloaderTimeout = 4500;
  setTimeout(function () {
    $('body').addClass('loaded');
  }, preloaderTimeout);
  // =======Preloader========>>>>>



  // =======Sticky-header========>>>>>
  $(window).on('scroll', function () {
    var scroll = $(window).scrollTop();
    if (scroll < 50) {
        $(".sticky-navbar").removeClass("sticky");
        $('.back-to-top').hide();
    } else {
        $(".sticky-navbar").addClass("sticky");
        $('.back-to-top').show();
    }
  });
  // =======Sticky-header========>>>>>



    // =======Social share========>>>>>
    if($('.share-link').length > 0){
      $('.share-link').on('click', function(event){
        event.preventDefault();
        let iconList = $('.social-icons-list');
        iconList.toggleClass('social-icons-toggle');
      });
    }
    // =======Social share========>>>>>


    // =======CounterUp JS-Odometer========>>>>>
    if($('.odometer').length > 0){
      $(window).on('scroll', function () {
        function winScrollPosition() {
            var scrollPos = $(window).scrollTop(),
                winHeight = $(window).height();
            var scrollPosition = Math.round(scrollPos + (winHeight / .07));
            return scrollPosition;
        }
        var elemOffset = $('.odometer').offset().top;
        if (elemOffset < winScrollPosition()) {

          setTimeout(function () {
            $('.odometer').each(function () {
              $(this).html($(this).data('count-to'));
            });
          }, preloaderTimeout + 200);

        }
    });
  }

  // =======CounterUp JS-Odometer========>>>>>


  // Gallery Popup
  jQuery(document).ready(function($) {
    $('[data-fancybox="gallery"]').fancybox({
        afterLoad: function(instance, current) {
            // Add the class 'gallery-popup' to the fancybox container
            $('.fancybox-container').addClass('gallery-popup');
        },
        afterClose: function(instance, current) {
            // Remove the class 'gallery-popup' from the fancybox container
            $('.fancybox-container').removeClass('gallery-popup');
        }
    });
  });

  // JavaScript to submit form when "Place Order" button is clicked
  const customPackageCompleteWrap = document.querySelector('.custom-package-complete');
  if(customPackageCompleteWrap){
    document.getElementById('place-order-btn').addEventListener('click', function() {
      document.getElementById('order-form').submit();
    });
  }

  // =======Circle========>>>>>
  const text = document.querySelector ('.rotate-text p');
  if(text){
  text.innerHTML = text.innerText.split("").map(
      (char, i)=>
      `<span style="transform:rotate(${i*9.6}deg)">${char}</span>`
  ).join("");
  }

  const text2 = document.querySelector ('.rotate-text2 p');
  if(text2){
  text2.innerHTML = text2.innerText.split("").map(
      (char, i)=>
      `<span style="transform:rotate(${i*9.6}deg)">${char}</span>`
  ).join("");
  }

  const text3 = document.querySelector ('.rotate-text3 p');
  if(text3){
    text3.innerHTML = text3.innerText.split("").map(
        (char, i)=>
        `<span style="transform:rotate(${i*9.6}deg)">${char}</span>`
    ).join("");
  }

  // =======Circle========>>>>>




    // =======Swiper .ticket-swiper========>>>>>
    if($('.ticket-swiper').length > 0){
      new Swiper(".ticket-swiper", {
        loop: true,
        grabCursor: true,
        slidesPerView: 1,
        pagination: {
          el: ".ticket-swiper-pagination",
          clickable: true,
        },
      });
    }
    // =======Swiper .ticket-swiper========>>>>>


  // =======Swiper .lineup-swiper========>>>>>
  if($('.lineup-swiper').length > 0){
    new Swiper(".lineup-swiper", {
      loop: true,
      grabCursor: true,
      breakpoints: {
        380: {
          slidesPerView: 1,
          slidesPerGroup: 1,
          spaceBetween: 30
        },
        430: {
          slidesPerView: 2,
          slidesPerGroup: 2,
          spaceBetween: 20
        },
        900: {
          slidesPerView: 3,
          spaceBetween: 20
        }
      },

      pagination: {
        el: ".lineup-swiper-pagination",
        type: "progressbar",
      },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },

    });
  }
  // =======Swiper .lineup-swiper========>>>>>



    // =======Swiper .lineup-swiper-2========>>>>>
    if($('.lineup-swiper-2').length > 0){
      new Swiper(".lineup-swiper-2", {
        grabCursor: true,
        breakpoints: {
          380: {
            slidesPerView: 1,
            slidesPerGroup: 1,
            spaceBetween: 30
          },
          430: {
            slidesPerView: 2,
            slidesPerGroup: 2,
            spaceBetween: 20
          },
          900: {
            slidesPerView: 3,
            spaceBetween: 20
          }
        },

        pagination: {
          el: ".lineup-swiper-pagination",
          type: "progressbar",
        },
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev",
        },

      });
    }
    // =======Swiper .lineup-swiper-2========>>>>>


    // =======Swiper .highlight-swiper========>>>>>
      new Swiper(".highlight-swiper", {
        loop: true,
        grabCursor: true,
        spaceBetween: 20,
        breakpoints: {
          430: {
            slidesPerView: 1,
            slidesPerGroup: 1,
            spaceBetween: 20
          },
          768: {
            slidesPerView: 2,
            slidesPerGroup: 1,
            spaceBetween: 20
          },
          1100: {
            slidesPerView: 3,
            slidesPerGroup: 1,
            spaceBetween: 20
          }
        },
        autoplay: {
          delay: 5000,
          disableOnInteraction: false,
        },
        navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev',
        },
        pagination: {
          el: ".swiper-pagination",
          type: "progressbar",
        },
      });


        //highlight-swiper-overflow========>>>>>
        new Swiper(".highlight-swiper-overflow", {
          grabCursor: true,
          spaceBetween: 20,
          breakpoints: {
            430: {
              slidesPerView: 1,
              slidesPerGroup: 1,
              spaceBetween: 20
            },
            768: {
              slidesPerView: 2,
              slidesPerGroup: 1,
              spaceBetween: 20
            },
            1100: {
              slidesPerView: 3,
              slidesPerGroup: 1,
              spaceBetween: 20
            }
          },
          pagination: {
            el: ".swiper-pagination",
            type: "progressbar",
          },
        });
        //highlight-swiper-overflow========>>>>>


    // =======Swiper .highlight-swiper========>>>>>


    // =======Swiper .highlight-2-swiper========>>>>>
    new Swiper(".highlight-2-swiper", {
      loop: true,
      grabCursor: true,
      spaceBetween: 20,
      breakpoints: {
        430: {
          slidesPerView: 1,
          slidesPerGroup: 1,
          spaceBetween: 20
        },
        993: {
          slidesPerView: 2,
          slidesPerGroup: 1,
          spaceBetween: 20
        },
        1400: {
          slidesPerView: 3,
          slidesPerGroup: 1,
          spaceBetween: 20
        }
      },
      pagination: {
        el: ".swiper-pagination",
        type: "progressbar",
      },
    });
    // =======Swiper .highlight-2-swiper========>>>>>


  // =======Swiper .brand-swiper========>>>>>
  new Swiper(".brand-swiper", {
    loop: true,
    grabCursor: true,
    breakpoints: {
      380: {
        slidesPerView: 2,
        slidesPerGroup: 2,
        spaceBetween: 20
      },
      420: {
        slidesPerView: 3,
        slidesPerGroup: 2,
        spaceBetween: 20
      },
      900: {
        slidesPerView: 4,
        slidesPerGroup: 2,
        spaceBetween: 30
      },

      1200: {
        slidesPerView: 6,
        slidesPerGroup: 2,
        spaceBetween: 40
      }
    },

    pagination: {
      el: ".swiper-pagination",
      type: "progressbar",
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },

  });
  // =======Swiper .brand-swiper========>>>>>


  // =======Swiper .brand-2-swiper========>>>>>
  const sponsorWrap = document.querySelector('.sponser-section-slide');
  if(sponsorWrap){
    var sponSwiper = new Swiper(".brand-2-swiper", {
      loop: true,
      grabCursor: true,
      centeredSlides: true,
      breakpoints: {
        420: {
          slidesPerView: 1,
          slidesPerGroup: 2,
          spaceBetween: 10,
          centeredSlides: true,
        },
        720: {
          slidesPerView: 3,
          slidesPerGroup: 2,
          spaceBetween: 40
        },
        900: {
          slidesPerView: 4,
          slidesPerGroup: 2,
          spaceBetween: 60
        },
        1200: {
          slidesPerView: 5,
          slidesPerGroup: 1,
          spaceBetween: 90
        }
      },
      autoplay: {
        delay: 3000,
        disableOnInteraction: false,
      },
      pagination: {
        el: ".swiper-pagination",
        type: "progressbar",
      },
    });

    // Pause autoplay on mouse enter
    sponSwiper.el.addEventListener('mouseenter', function () {
      sponSwiper.autoplay.stop();
    });

    // Resume autoplay on mouse leave
    sponSwiper.el.addEventListener('mouseleave', function () {
      sponSwiper.autoplay.start();
    });
  }

  // =======Swiper .brand-2-swiper========>>>>>


    // =======Swiper .blog-swiper========>>>>>
    new Swiper(".blog-swiper", {
      loop: false,
      // grabCursor: true,
      spaceBetween: 20,

      breakpoints: {
        420: {
          slidesPerView: 1,
          slidesPerGroup: 1,
          spaceBetween: 20
        },
        768: {
          slidesPerView: 2,
          slidesPerGroup: 1,
          spaceBetween: 30
        },
      },

      pagination: {
        el: ".swiper-pagination",
        type: "progressbar",
      },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },

    });
    // =======Swiper .blog-swiper========>>>>>


    // =======Swiper .blog-swiper-2========>>>>>
    new Swiper(".blog-swiper-2 ", {
      loop: true,
      grabCursor: true,
      spaceBetween: 20,
      breakpoints: {

        430: {
          slidesPerView: 1,
          slidesPerGroup: 1,
          spaceBetween: 20
        },
        700: {
          slidesPerView: 2,
          slidesPerGroup: 1,
          spaceBetween: 20
        },
        1100: {
          slidesPerView: 3,
          slidesPerGroup: 1,
          spaceBetween: 20
        }
      },

      pagination: {
        el: ".swiper-pagination",
        type: "progressbar",
      },
    });
    // =======Swiper .blog-swiper-2========>>>>>


    // =======Swiper .blog-swiper-3========>>>>>
    new Swiper(".blog-swiper-3 ", {
      loop: true,
      grabCursor: true,
      spaceBetween: 30,
      breakpoints: {

        430: {
          slidesPerView: 1,
          slidesPerGroup: 1,
          spaceBetween: 30
        },
        700: {
          slidesPerView: 2,
          slidesPerGroup: 1,
          spaceBetween: 30
        },
      },

      pagination: {
        el: ".swiper-pagination",
        type: "progressbar",
      },
    });
    // =======Swiper .blog-swiper-3========>>>>>


    // =======Swiper .merchandise-swiper========>>>>>
    new Swiper(".merchandise-swiper", {
      loop: true,
      grabCursor: true,
      spaceBetween: 30,
      breakpoints: {
        420: {
          slidesPerView: 1,
          slidesPerGroup: 1,
          spaceBetween: 30
        },
        768: {
          slidesPerView: 2,
          slidesPerGroup: 1,
          spaceBetween: 30
        },
        1200: {
          slidesPerView: 3,
          slidesPerGroup: 1,
          spaceBetween: 20
        },
        1500: {
          slidesPerView: 4,
          slidesPerGroup: 1,
          spaceBetween: 20
        },
      },

      pagination: {
        el: ".swiper-pagination",
        type: "progressbar",
      },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },

    });
    // =======Swiper .merchandise-swiper========>>>>>


    // =======Swiper .blog-2-swiper========>>>>>
    new Swiper(".blog-2-swiper", {
      loop: true,
      // grabCursor: true,
      spaceBetween: 30,
      breakpoints: {
        769: {
          slidesPerView: 1,
          slidesPerGroup: 1,
          spaceBetween: 30
        },
        770: {
          slidesPerView: 2,
          slidesPerGroup: 1,
          spaceBetween: 30
        },
        1100: {
          slidesPerView: 3,
          slidesPerGroup: 1,
          spaceBetween: 30
        }
      },
      pagination: {
        el: ".swiper-pagination",
        type: "progressbar",
      },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
    });
    // =======Swiper .blog-2-swiper========>>>>>


    // =======Swiper .pricing-swiper========>>>>>
    new Swiper(".pricing-swiper", {
      loop: true,
      grabCursor: true,
      spaceBetween: 30,
      breakpoints: {
        500: {
          slidesPerView: 1,
          slidesPerGroup: 1,
        },
        769: {
          slidesPerView: 2,
          slidesPerGroup: 1,
          spaceBetween: 30
        },

        1200: {
          slidesPerView: 3,
          slidesPerGroup: 1,
          spaceBetween: 30
        }
      },

      pagination: {
        el: ".swiper-pagination",
        type: "progressbar",
      },

    });
    // =======Swiper .pricing-swiper========>>>>>


  // =========Button(Increse-Decrese)=========>>>>>
  var buttonPlus  = $(".plus-icon");
  var buttonMinus = $(".dash-icon");

  var incrementPlus = buttonPlus.click(function() {
    var $n = $(this)
    .parent(".ticket-amounts")
    .find(".input-number");
    $n.val(Number($n.val())+1 );
  });

  var incrementMinus = buttonMinus.click(function() {
    var $n = $(this)
    .parent(".ticket-amounts")
    .find(".input-number");
    var amount = Number($n.val());
    if (amount > 1) {
      $n.val(amount-1);
    }
  });
  // =========Button(Increse-Decrese)=========>>>>>

  // =========Package Filter Select2=========>>>>>
    $('#category-select').select2({
      minimumResultsForSearch: -1
    });

    $('#category-select').on('change', function() {
      var selectedCategory = $(this).val();
      $('.package-item').hide();
      if(selectedCategory === 'all') {
          $('.package-item').show();
      } else {
          $('.package-item[data-category="' + selectedCategory + '"]').show();
      }
    });
  // =========Package Filter Select2=========>>>>>

  // =========Ticket-Section Radio-Input=========>>>>>
      $('input:radio:checked').parent().addClass("radio-checked-bg border-transparent");
      $('input:radio').click(function () {
        $('input:not(:checked)').parent().removeClass("radio-checked-bg border-transparent");
        $('input:checked').parent().addClass("radio-checked-bg border-transparent");
      });
  // =========Ticket-Section Radio-Input=========>>>>>



  // =======Magnific-PopUp========>>>>>
  $('.image-link').magnificPopup({
    type: 'image',
    gallery:{
      enabled:true
    },
    zoom: {
      enabled: true,
      duration: 300, // don't foget to change the duration also in CSS
      opener: function(element) {
          return element.find('img');
      }
    }
  });


  // Video popup
	$('.video-popup-link').magnificPopup({
    disableOn: 200,
    type: 'iframe',
    mainClass: 'mfp-fade',
    removalDelay: 160,
    preloader: false,
    fixedContentPos: false
  });
  // =======Magnific-PopUp========>>>>>


new WOW().init();


})(jQuery);

/* ------------ Cart ------------ */

document.addEventListener('DOMContentLoaded', () => {
  /* Start Update Cart */
  const cartWrap = document.querySelector('.cart');
  if(cartWrap){
    // Function to calculate subtotal for Desktop view
    function calculateSubTotal(){
      const quantityFields = document.querySelectorAll('.qty-dsk');
      const priceFields = document.querySelectorAll('.price-dsk');
      let subTotal = 0;
      quantityFields.forEach((quantityField, index) => {
        const quantity = parseInt(quantityField.value);
        const price = parseFloat(priceFields[index].value.split(' ')[1]);
        const total = quantity * price;
        subTotal += total;
      });
      return subTotal;
    }
    // Function to calculate subtotal for Mobile view
    function calculateSubTotalMobile() {
      const quantityFields = document.querySelectorAll('.qty-mb');
      const priceFields = document.querySelectorAll('.price-mb');
      let subTotal = 0;
      quantityFields.forEach((quantityField, index) => {
          const quantity = parseInt(quantityField.value);
          const price = parseFloat(priceFields[index].value.split(' ')[1]);
          const total = quantity * price;
          subTotal += total;
      });
      return subTotal;
    }
    // All Form Submit Desktop
    function formsSubmitDesktop(){
      const forms = document.querySelectorAll('.qty-update-form-dsk');
        forms.forEach(form => {
          const submitButtons = form.querySelectorAll('.btn-sub');
          submitButtons.forEach(button => {
            button.click();
        });
      });
    }
    // All Form Submit Mobile
    function formsSubmitMobile(){
        const forms = document.querySelectorAll('.qty-update-form-mb');
        forms.forEach(form => {
          const submitButtons = form.querySelectorAll('.btn-sub');
          submitButtons.forEach(button => {
            button.click();
          });
        });
    }
    // Show subtotal on page load
    const subPrice = document.querySelector('.sub-price');
    subPrice.textContent = `LKR ${calculateSubTotal().toFixed(2)}`;
    // Update subtotal when the update button is clicked
    const updateCartBtn = document.querySelector('.update-cart');
    updateCartBtn.addEventListener('click', () => {
      const productIds = [];
      const quantities = [];
      const quantityFields = document.querySelectorAll('.qty-dsk');
      quantityFields.forEach(quantityField => {
        const productId = quantityField.getAttribute('data-product-id');
        const quantity = parseInt(quantityField.value);
        productIds.push(productId);
        quantities.push(quantity);
      });
     // Log to the console to verify
     console.log('Product IDs:', productIds);
     console.log('Quantities:', quantities);
      if (window.innerWidth >= 992) {
        subPrice.textContent = `LKR ${calculateSubTotal().toFixed(2)}`;
        formsSubmitDesktop();
      } else {
        subPrice.textContent = `LKR ${calculateSubTotalMobile().toFixed(2)}`;
        formsSubmitMobile()
      }
    });

    // Update subtotal when the window is resized (for responsiveness)
    window.addEventListener('resize', () => {
      if (window.innerWidth >= 992) {
        subPrice.textContent = `LKR ${calculateSubTotal().toFixed(2)}`;
      } else {
        subPrice.textContent = `LKR ${calculateSubTotalMobile().toFixed(2)}`;
      }
    });
  }
  /* End Update Cart */
  /* Start Increase and Decrease Buttons */
  // Desktop
  const formWrap = document.querySelectorAll('.qty-update-form-dsk');
  formWrap.forEach(form => {
    const qtyDskFields = form.querySelectorAll('.qty-dsk');
    qtyDskFields.forEach(qtyDskField => {
      const decreaseButton = qtyDskField.parentElement.querySelector('.quantity-decrease');
      const increaseButton = qtyDskField.parentElement.querySelector('.quantity-increase');
      decreaseButton.addEventListener('click', () => {
        let currentValue = parseInt(qtyDskField.value);
        if(currentValue > 1){
          qtyDskField.value = currentValue - 1;
        }
      });
      increaseButton.addEventListener('click', () => {
        let currentValue = parseInt(qtyDskField.value);
        qtyDskField.value = currentValue + 1;
      });
    });
  });
  // Mobile
  const formWrapmb = document.querySelectorAll('.qty-update-form-mb');
  formWrapmb.forEach(form => {
    const qtyMbFields = form.querySelectorAll('.qty-mb');
    qtyMbFields.forEach(qtyMbField => {
      const decreaseButton = qtyMbField.parentElement.querySelector('.quantity-decrease');
      const increaseButton = qtyMbField.parentElement.querySelector('.quantity-increase');
      decreaseButton.addEventListener('click', () => {
        let currentValue = parseInt(qtyMbField.value);
        if(currentValue > 1){
          qtyMbField.value = currentValue - 1;
        }
      });
      increaseButton.addEventListener('click', () => {
        let currentValue = parseInt(qtyMbField.value);
        qtyMbField.value = currentValue + 1;
      });
    });
  });
  /* End Increase and Decrease Buttons */
  /* Start Cart Popup Form */
  const decreaseBtns = document.querySelectorAll('.quantity-decrease-popup');
  const increaseBtns = document.querySelectorAll('.quantity-increase-popup');
  const quantityFields = document.querySelectorAll('.quantity-field-popup');
  decreaseBtns.forEach(function(btn, index) {
    btn.addEventListener('click', function() {
      let currentValue = parseInt(quantityFields[index].value);
      if (currentValue > 1) {
        quantityFields[index].value = currentValue - 1;
      }
    });
  });

  increaseBtns.forEach(function(btn, index) {
    btn.addEventListener('click', function() {
      let currentValue = parseInt(quantityFields[index].value);
      quantityFields[index].value = currentValue + 1;
    });
  });
  /* End Cart Popup Form */
  /* Start Update Cart Alert */
  const salert = document.getElementById('success-alert');
  if(salert){
    setTimeout(function() {
      document.getElementById('success-alert').style.display = 'none';
    }, 5000);
  }
  /* End Update Cart Alert */
  /* Start Subscription Form Submit Message */
  var subscriptionform = document.getElementById('subscriptionform');
  if(subscriptionform){
      subscriptionform.addEventListener('submit', function(event) {
          event.preventDefault();
          var modal = new bootstrap.Modal(document.getElementById('form-success'));
          modal.show();
      });
  }
  var modalCloseBtn = document.getElementById('modal-close-btn');
  if(modalCloseBtn){
      modalCloseBtn.addEventListener('click', function(event) {
          var form = document.getElementById('subscriptionform');
          form.submit();
      });
  }
  var footerModalCloseBtn = document.getElementById('footer-modal-close-btn');
  if(footerModalCloseBtn){
    footerModalCloseBtn.addEventListener('click', function(event) {
          var form = document.getElementById('subscriptionform');
          form.submit();
      });
  }
  /* End Subscription Form Submit Message */

  // Initialize particles.js
  particlesJS('particles-js', {
    // Configuration options
    "particles": {
        "number": {
            "value": 80,
            "density": {
                "enable": true,
                "value_area": 1200
            }
        },
        "color": {
            "value": "#f68634" // Set your theme color
        },
        "shape": {
            "type": "circle", // Set shape to circle (dots)
            "stroke": {
                "width": 0,
                "color": "#000000"
            },
        },
        "opacity": {
            "value": 0.5,
            "random": false,
            "anim": {
                "enable": false,
                "speed": 1,
                "opacity_min": 0.1,
                "sync": false
            }
        },
        "size": {
            "value": 3, // Set smaller size for particles
            "random": true,
            "anim": {
                "enable": false,
                "speed": 40,
                "size_min": 0.1,
                "sync": false
            }
        },
        "line_linked": {
            "enable": false, // Disable linking between particles
        },
        "move": {
            "enable": true,
            "speed": 4,
            "direction": "none",
            "random": false,
            "straight": false,
            "out_mode": "out",
            "bounce": false,
            "attract": {
                "enable": false,
                "rotateX": 600,
                "rotateY": 1200
            }
        }
    },
    "interactivity": {
        "detect_on": "canvas",
        "events": {
            "onhover": {
                "enable": true,
                "mode": "repulse"
            },
            "onclick": {
                "enable": true,
                "mode": "push"
            },
            "resize": true
        },
        "modes": {
            "grab": {
                "distance": 400,
                "line_linked": {
                    "opacity": 1
                }
            },
            "bubble": {
                "distance": 400,
                "size": 40,
                "duration": 2,
                "opacity": 8,
                "speed": 3
            },
            "repulse": {
                "distance": 200
            },
            "push": {
                "particles_nb": 4
            },
            "remove": {
                "particles_nb": 2
            }
        }
    },
    "retina_detect": true
  });
  // Initialize Masonry layout
  var $grid = $('#gallery-row').masonry({
      itemSelector: '.item-wrap',
      percentPosition: true
  });
  // Layout Masonry after a short delay
  setTimeout(function() {
      $grid.masonry('layout');
  }, 100);
});


