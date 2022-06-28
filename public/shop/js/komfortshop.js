// JavaScript Document
$(function() {
 "use strict";

  function responsive_dropdown () {
    /* ---- For Mobile Menu Dropdown JS Start ---- */
      $("#menu span.opener, #menu-main span.opener").on("click", function(){
          var menuopener = $(this);
          if (menuopener.hasClass("plus")) {
             menuopener.parent().find('.mobile-sub-menu').slideDown();
             menuopener.removeClass('plus');
             menuopener.addClass('minus');
          }
          else
          {
             menuopener.parent().find('.mobile-sub-menu').slideUp();
             menuopener.removeClass('minus');
             menuopener.addClass('plus');
          }
          return false;
      });

      jQuery( ".mobilemenu" ).on("click", function() {
        jQuery( ".mobilemenu-content" ).slideToggle();
        if ($(this).hasClass("openmenu")) {
            $(this).removeClass('openmenu');
            $(this).addClass('closemenu');
          }
          else
          {
            $(this).removeClass('closemenu');
            $(this).addClass('openmenu');
          }
          return false;
      });
    /* ---- For Mobile Menu Dropdown JS End ---- */

    /* ---- For Sidebar JS Start ---- */
      $('.sidebar-box span.opener').on("click", function(){
      
        if ($(this).hasClass("plus")) {
          $(this).parent().find('.sidebar-content').slideDown();
          $(this).removeClass('plus');
          $(this).addClass('minus');
        }
        else
        {
          $(this).parent().find('.sidebar-content').slideUp();
          $(this).removeClass('minus');
          $(this).addClass('plus');
        }
        return false;
      });
    /* ---- For Sidebar JS End ---- */

    /* ---- For Footer JS Start ---- */
      $('.footer-static-block span.opener').on("click", function(){
      
        if ($(this).hasClass("plus")) {
          $(this).parent().find('.footer-block-content').slideDown();
          $(this).removeClass('plus');
          $(this).addClass('minus');
        }
        else
        {
          $(this).parent().find('.footer-block-content').slideUp();
          $(this).removeClass('minus');
          $(this).addClass('plus');
        }
        return false;
      });
    /* ---- For Footer JS End ---- */

     /* ---- For Navbar JS Start ---- */
    $('.navbar-toggle').on("click", function(){
      var menu_id = $('#menu');
      var nav_icon = $('.navbar-toggle i');
      if(menu_id.hasClass('menu-open')){
        menu_id.removeClass('menu-open');
        nav_icon.removeClass('fa-close');
        nav_icon.addClass('fa-bars');
      }else{
        menu_id.addClass('menu-open');
        nav_icon.addClass('fa-close');
        nav_icon.removeClass('fa-bars');
      }
      return false;
    });
    /* ---- For Navbar JS End ---- */

     /* ---- For Category Dropdown JS Start ---- */
    $('.btn-sidebar-menu-dropdown').on("click", function() {

      $('.cat-dropdown').slideToggle();

      if($(".sidebar-block").hasClass("open1")){
        $(".sidebar-block").addClass("close1").removeClass("open1");
      }else{
        $(".sidebar-block").addClass("open1").removeClass("close1");
      }
    });
    /* ---- For Category Dropdown JS End ---- */

    /* ---- For Content Dropdown JS Start ---- */
    $('.content-link').on("click", function() {
      $('.content-dropdown').toggle();
    });
    /* ---- For Content Dropdown JS End ---- */
  }

  function popup_dropdown () {
    /*---- Category dropdown start ---- */
      $('.cate-inner span.opener').on("click", function(){
      
        if ($(this).hasClass("plus")) {
          $(this).parent().find('.mega-sub-menu').slideDown();
          $(this).removeClass('plus');
          $(this).addClass('minus');
        }
        else
        {
          $(this).parent().find('.mega-sub-menu').slideUp();
          $(this).removeClass('minus');
          $(this).addClass('plus');
        }
        return false;
      });
    /*---- Category dropdown end ---- */
  }

  function sidebar_margin() {
    $( ".homepage .sidebar-block").css("margin-top",$("#cat").height() );
  }

  function popup_links() {
    /*---- Start Popup Links---- */
    $(document).magnificPopup({
      type: 'inline',
      preloader: false,
      focus: '#name',
      delegate: '.popup-with-form',

      // When elemened is focused, some mobile browsers in some cases zoom in
      // It looks not nice, so we disable it:
      callbacks: {
        beforeOpen: function() {
          if($(window).width() < 700) {
            this.st.focus = false;
          } else {
            this.st.focus = '#name';
          }
        }
      }
    });
    /*---- End Popup Links ---- */
    return false;
  }

  function owlcarousel_slider () {
    /* ------------ OWL Slider Start  ------------- */

      /* ----- pro_cat_slider Start  ------ */
      $('.pro-cat-slider').owlCarousel({
        items: 5,
        nav: true,
        dots: false,
        loop:true,
        responsiveClass:true,
        responsive:{
            0:{
                items:2,
            },
            768:{
                items:3,
            },
            992:{
                items:3,
            },
            1200:{
                items:3,
            },
            1770:{
                items:5,
            }
        }
      });
      /* ----- pro_cat_slider End  ------ */

      /* ----- sub_menu_slider Start  ------ */
      $('.sub_menu_slider').owlCarousel({
        items: 6,
        nav: true,
        dots: false,
        loop:true,
        responsiveClass:true,
        responsive:{
            0:{
                items:1,
            }
        }
      });

      $('home').owlCarousel({
        items: 6,
        nav: true,
        dots: false,
        loop:true,
        responsiveClass:true,
        responsive:{
            0:{
                items:1,
            }
        }
      });
      /* -----sub_menu_slider End  ------ */

      /* ----- our-sell-pro_slider Start  ------ */
      $('#top-cat-pro').owlCarousel({
          items: 6,
          nav: true,
          dots: false,
          loop: true,
          responsiveClass:true,
          responsive:{
              0:{
                  items:1,
              },
              480:{
                  items:2,
              },
              768:{
                  items:3,
              },
              1200:{
                  items:4,
              },
              1770:{
                  items:6,
              }
          }
      });
      /* ----- our-sell-pro_slider End  ------ */

      /* ----- best-seller-pro Start  ------ */
      $('.best-seller-pro').owlCarousel({
        items: 5,
        nav: true,
        dots: false,
        loop:true,
        responsiveClass:true,
        responsive:{
            0:{
                items:2,
            },
            768:{
                items:3,
            },
            992:{
                items:3,
            },
            1200:{
                items:3,
            },
            1770:{
                items:5,
            }
        }
      });
      /* ----- best-seller-pro End  ------ */


      /* ----- brand-logo Start  ------ */
      $('#brand-logo').owlCarousel({
        items: 6,
        nav: true,
        dots: false,
        loop:true,
        responsiveClass:true,
        responsive:{
            0:{
                items:1,
            },
            480:{
                items:2,
            },
            768:{
                items:3,
            },
            1200:{
                items:4,
            },
            1770:{
                items:6,
            }
        }
      });
      /* ----- brand-logo End  ------ */

      /* ----- blog Start  ------ */
      $('#blog').owlCarousel({
        items: 1,
        nav: true,
        dots: false,
        loop:true,
        responsiveClass:true,
        responsive:{
            0:{
                items:1,
            },
            768:{
                items:2,
            },
            992:{
                items:1,
            },
            1200:{
                items:1,
            },
            1770:{
                items:1,
            }
        }
      });
      /* ----- blog End  ------ */

      /* ----- blog Start  ------ */
      $('.social-feed').owlCarousel({
        items: 1,
        nav: true,
        dots: false,
        loop:true,
        responsiveClass:true,
        responsive:{
            0:{
                items:1,
            },
            768:{
                items:2,
            },
            992:{
                items:1,
            },
            1200:{
                items:1,
            },
            1770:{
                items:1,
            }
        }
      });
      /* ----- blog End  ------ */

      /* -----  our-team slider Start  ------ */
      $('.our-team').owlCarousel({
        items: 6,
        nav: true,
        dots: false,
        loop:true,
        responsiveClass:true,
        responsive:{
            0:{
                items:2,
            },
            768:{
                items:2,
            },
            992:{
                items:3,
            },
            1200:{
                items:4,
            },
            1770:{
                items:6,
            }
        }
      });
      /* ----- our-team slider End  ------ */

      /* ---- main-banner Testimonial Start ---- */
      $(".main-banner, #client").owlCarousel({

        //navigation : true,  Show next and prev buttons
        items: 1,
        nav: true,
        slideSpeed : 1000,
        paginationSpeed : 1000,
        autoplayTimeout:5000,
        smartSpeed: 1000,
        loop:true,
        autoplay: true,
        dots: true,
        singleItem:true

      });
      $("#detail-reviews").owlCarousel({

          //navigation : true,  Show next and prev buttons
          items: 1,
          nav: true,
          slideSpeed : 1000,
          paginationSpeed : 1000,
          autoplayTimeout:5000,
          smartSpeed: 1000,
          loop:true,
          autoplay: true,
          dots: true,
          singleItem:true

      });
      /* ----- main-banner Testimonial End  ------ */
      return false;
    /* ------------ OWL Slider End  ------------- */
  }

  function scrolltop_arrow () {
   /* ---- Page Scrollup JS Start ---- */
   //When distance from top = 250px fade button in/out
    var scrollup = $('.scrollup');
    var headertag = $('header');
    var mainfix = $('.main');
    $(window).scroll(function(){
      if ($(this).scrollTop() > 0) {
          scrollup.fadeIn(300);
      } else {
          scrollup.fadeOut(300);
      }
      
      /* ---- Page Scrollup JS End ---- */
    });
    
    //On click scroll to top of page t = 1000ms
    scrollup.on("click", function(){
        $("html, body").animate({ scrollTop: 0 }, 1000);
        return false;
    });
  }


  /*Select Menu Js Start*/
  function option_drop() {
    $( ".option-drop" ).selectmenu();
    return false;
  }
  /*Select Menu Js Ends*/

  /* Product Detail Page Tab JS Start */
  function description_tab () {
    $("#tabs li a").on("click", function(e){
        const target = $(e.currentTarget).attr("href");
        $("#tabs li a , .tab_content li div").removeClass("selected");
        $("#items .tab_content "+target).addClass("selected");
        $("#items").attr("class","tab-"+target);
        $(e.currentTarget).addClass('selected');
      return false;
    });
  }
  /* Product Detail Page Tab JS End */


    window.passwordValidation = function(){
        const validationBox = $('#password-validator-box');
        if(!validationBox.length){
            return;
        }
        const Passwordinput = $('#'+validationBox.data('field-id'));
        const letter = validationBox.find('#letter');
        const capital = validationBox.find('#capital');
        const number = validationBox.find('#number');
        const lengthField = validationBox.find('#length');
        const special = validationBox.find('#special');
        
        Passwordinput.on('focus', function(){
            validationBox.show();
        }).on('keyup', function(){
            const lowerCaseLetters = /[a-z]/g;
            if(Passwordinput.val().match(lowerCaseLetters)) {
                letter.removeClass("invalid");
                letter.addClass("valid");
            } else {
                letter.removeClass("valid");
                letter.addClass("invalid");
            }

            const upperCaseLetters = /[A-Z]/g;
            if(Passwordinput.val().match(upperCaseLetters)) {
                capital.removeClass("invalid");
                capital.addClass("valid");
            } else {
                capital.removeClass("valid");
                capital.addClass("invalid");
            }

            const numbers = /[0-9]/g;
            if(Passwordinput.val().match(numbers)) {
                number.removeClass("invalid");
                number.addClass("valid");
            } else {
                number.removeClass("valid");
                number.addClass("invalid");
            }

            const specialChars = /[*.!@$£%^&(){}\[\]:;<>,?\/~_+\-=|\\#"'€]/g;
            if(Passwordinput.val().match(specialChars)) {
                special.removeClass("invalid");
                special.addClass("valid");
            } else {
                special.removeClass("valid");
                special.addClass("invalid");
            }
            if(Passwordinput.val().length >= 8) {
                lengthField.removeClass("invalid");
                lengthField.addClass("valid");
            } else {
                lengthField.removeClass("valid");
                lengthField.addClass("invalid");
            }
        })

    }


  $(document).on("ready", function() {
    owlcarousel_slider();
    responsive_dropdown();
    sidebar_margin();
    description_tab ();
    scrolltop_arrow ();
    popup_dropdown ();
    option_drop();
    popup_links();
    window.passwordValidation();

    $('.article-collection').each(function(){
        let collection = $(this);
        $.ajax({
            url: collection.data('url'),
            type: 'GET',
            data: {
                'template': collection.data('template')
            },
            success: function(data)
            {
                collection.replaceWith(data)
            },
            error: function(jqXHR){
                $('#ajax-modals div.modal-content').html(jqXHR.responseText) ;
                $('#ajax-modals').modal('show');
            }
        });
    });
    $('body').on('click', '.single-click', function(){
        const link = $(this);
        if(link.hasClass('download')){
            link.html('<i class="fa fa-check"></i> Download ausgelöst!')
        }
        //prevent double click
        link.on('click', function(e) {
            e.preventDefault();
        });
    });
      function delay(callback, ms) {
          let timer = 0;
          return function() {
              const context = this, args = arguments;
              clearTimeout(timer);
              timer = setTimeout(function () {
                  callback.apply(context, args);
              }, ms || 0);
          };
      }

      $('#accordion').on('shown.bs.collapse', function () {
          const card = $('.collapse.show');
          if(!card.data('href') || card.hasClass('loaded')){
              return null;
          }
          $.ajax({
              url: card.data('href'),
              type: 'GET',
              success: function(data)
              {
                  $('.collapse.show .card-body').html(data);
                  card.addClass('loaded');
              },
              error: function(jqXHR){
                  $('#collapse1 .card-body').html(jqXHR.responseText) ;
              }
          });
      });
      $('.read-more.text').readMore({
          expandTrigger: ".prompt",
          previewHeight: 220,
          fadeColor1: "rgba(255,255,255,0)",
          fadeColor2: "rgba(255,255,255,1)"
      });
      $('.read-more.affiliate').readMore({
          expandTrigger: ".prompt",
          previewHeight: 100,
          fadeColor1: "rgba(255,255,255,0)",
          fadeColor2: "rgba(255,255,255,1)"
      });
  });
});

