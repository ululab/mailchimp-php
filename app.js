console.log("Vue Version " +Vue.version );



jQuery(document).ready(function($){

  /*------------------------------------------------
    SLIDER
  ------------------------------------------------*/

  if ($('.slider-top .wrapper-slider')) {
    $('.slider-top .wrapper-slider').slick({
      dots: false,
      arrows: true,
      infinite: true,
      slidesToShow: 1,
      slidesToScroll: 1,
      autoplay: true,
      speedAutoplay: 1000,
      speed: 1000,
      cssEase: 'linear',
      prevArrow: '.slider-top .arrow-sth.prev',
      nextArrow: '.slider-top .arrow-sth.next'
    });
  }

if ($('#gallery-rel-1')) {

  var $sliderRelFooter = $('#gallery-rel-1');
  var $progressBar = $('.slick-progress-bar');
  var $progressBarLabel = $( '.slider__label' );

  $sliderRelFooter.on('beforeChange', function(event, slick, currentSlide, nextSlide) {
    var calc = ( (nextSlide) / (slick.slideCount-1) ) * 100;

    $progressBar
      .css('background-size', calc + '% 100%')
      .attr('aria-valuenow', calc );

    $progressBarLabel.text( calc + '% completed' );
  });


  $sliderRelFooter.slick({
    dots: false,
    arrows: true,
    infinite: true,
    focusOnSelect: true,
    speed: 200,
    slidesToShow: 5,
    slidesToScroll: 1,
    prevArrow: '#gallery-realizations-footer .arrow-sth.prev',
    nextArrow: '#gallery-realizations-footer .arrow-sth.next',
    asNavFor: '#gallery-rel-2-abs',
    mobileFirst: true,
    draggable: false,
    responsive: [
      {breakpoint: 1000, settings: {slidesToShow: 5, slidesToScroll: 1  }},
      {breakpoint: 750, settings: {slidesToShow: 4, slidesToScroll: 1  }},
      {breakpoint: 500, settings: {slidesToShow: 4, slidesToScroll: 1 }},
      {breakpoint: 200, settings: {slidesToShow: 3 }}
    ],
  });

  var slickRel = $sliderRelFooter.slick('getSlick');
  var countSlids = slickRel.slideCount - 1;

  $progressBar.click(function(e){
    let posX = e.pageX - $(this).offset().left;
    let lSegment = $(this).width() / countSlids;
    let indexSlide = Math.ceil(posX/lSegment);
    var calc = ( (indexSlide) / (countSlids-1) ) * 100;

    $progressBar
      .css('background-size', calc + '% 100%')
      .attr('aria-valuenow', calc );

    $progressBarLabel.text( calc + '% completed' );

    slickRel.slickGoTo(indexSlide);
  });

  $('#gallery-rel-2-abs').slick({
    dots: false,
    fade: true,
    arrows: true,
    infinite: true,
    speed: 200,
    slidesToShow: 1,
    slidesToScroll: 1,
    asNavFor: '#gallery-rel-1',
    focusOnSelect: true,
    mobileFirst: true,
    prevArrow: '#gallery-realizations-abs-footer .arrow-sth.prev',
    nextArrow: '#gallery-realizations-abs-footer .arrow-sth.next'
  });

  $('#gallery-realizations-footer .inner-bg-image').click(function(){
    // open gallery absolute
    $('.gallery-relizations-abs').addClass('active');
    $('#gallery-realizations-footer .arrow-sth').addClass('opacity0');
  });

  $('.gallery-relizations-abs .close-popup').click(function(){
    // open gallery absolute
    $('.gallery-relizations-abs').removeClass('active');
    $('#gallery-realizations-footer .arrow-sth').removeClass('opacity0');
  })

}

  $('#gallery-partner .wrapper-gallery').slick({
    dots: false,
    arrows: true,
    infinite: true,
    speed: 200,
    slidesToShow: 5,
    slidesToScroll: 1,
    prevArrow: '#gallery-partner .arrow-sth.prev',
    nextArrow: '#gallery-partner .arrow-sth.next',
    responsive: [
      {breakpoint: 1000, settings: {slidesToShow: 5, slidesToScroll: 1  }},
      {breakpoint: 750, settings: {slidesToShow: 4, slidesToScroll: 1  }},
      {breakpoint: 500, settings: {slidesToShow: 2, slidesToScroll: 1 }},
      {breakpoint: 200, settings: {slidesToShow: 1 }}
  ],
  });


  $('#gallery-single-rel .w-image img').on('click', function(){
    let src = $(this).attr('src');
    $('#layer-popup-gallery').addClass('active');
    $('#layer-popup-gallery .w-image').append('<img src="'+src+'">');
  });

  $('#layer-popup-gallery').on('click', function(){
    $('#layer-popup-gallery').removeClass('active');
    $('#layer-popup-gallery .w-image img').remove();
  });
  /*------------------------------------------------
    MENU
  ------------------------------------------------*/
  $("#ham").click(function(){

   if ($("#ham").hasClass("open")) {
      actionCloseMenu();
   }
   else{
     actionOpenMenu()
   }

     /*   CLICK in site-content end site-footer   */
   // $(".site-content, .site-footer, #primary-menu a[href=#contacts]").click(function(){
   //
   //   if ($("#ham").hasClass("open")) {
   //       $("#container-primary-menu").animate( {left: "-105%"}, 400, "linear", function(){
   //       $("#primary-menu").css("opacity", "0");
   //     });
   //     $("#ham").toggleClass("open");
   //   } });

 });

  $('#site-nav-out, a[href="#contacts"]').click( actionCloseMenu );



function actionCloseMenu() {
  $("#site-navigation").removeClass( "active");
  $("#ham").removeClass("open");
  $('#primary-menu li a').removeClass('active');
  $('.wrap_images_menu .wrap_attachment_menu').css('z-index', '1');
  // touchSideSwipe.tssClose();
}

function actionOpenMenu() {
  $("#site-navigation").addClass( "active");
  $("#ham").addClass("open");
  // touchSideSwipe.tssOpen();
}

/*-----------------------------------------------
  MANAGE NEWSLETTER FORM >>>>
  -----------------------------------------------*/
/*  function open_newsletter_banner(){

    $('#newsletter-float-banner').addClass('banner-out');
    $('#open-banner').addClass('banner-out');

  } // open_newsletter_banner()

  function close_newsletter_banner(){

    $('#newsletter-float-banner').removeClass('banner-out');
    $('#open-banner').removeClass('banner-out');

    // set close banner session variable
    // $.ajax({
    //   method: 'post',
    //   url: ajax.ajax_url,
    //   data: {
    //     action: 'lab71_newsletter_status',
    //     nonce: ajax.nonce
    //   }
    // })

  } // close_newsletter_banner()

  $('#open-banner').click(function(){

    if( !$(this).hasClass('banner-out') ){
      open_newsletter_banner();
    } else{
      close_newsletter_banner();
    }

  })

  $('#close-banner').click(function(){

    close_newsletter_banner();

  })*/
/*-----------------------------------------------
    MANAGE NEWSLETTER FORM <<<<
-----------------------------------------------*/

/*------------------------------------------------
  TOUCH SIDE SWIPE >>><
------------------------------------------------*/
 // Toggle sidebar on swipe
 var start = {}, end = {}

 document.body.addEventListener('touchstart', function (e) {
   start.x = e.changedTouches[0].clientX
   start.y = e.changedTouches[0].clientY
   console.log(start);
 })

 document.body.addEventListener('touchend', function (e) {

   // prevent touchmove in slider/gallery
   let s = $(e.target).parents('.slick-slider'); // .touch-ignore
   if (s.length) return;

   end.y = e.changedTouches[0].clientY
   end.x = e.changedTouches[0].clientX

   var xDiff = end.x - start.x
   var yDiff = end.y - start.y

   if (Math.abs(xDiff) > Math.abs(yDiff)) {
     if (xDiff > 0 && start.x <= 80) actionOpenMenu();
     else actionCloseMenu();
   }
 })

 /*------------------------------------------------
   <<<< TOUCH SIDE SWIPE
 ------------------------------------------------*/



  // var ids = [];
  // $("#primary-menu li").each(function(index){
  //   ids[index] = $(this).attr('id');
  // });
  //
  // $(".wrap_images_menu .wrap_attachment_menu").each(function(index){
  //   $(this).attr('id', ids[index]);
  // });
  //
  // /* ==== Image menu ====*/
  $('#primary-menu li a').on('mouseover', function(){
    $('#primary-menu li a').removeClass('active');
    $(this).addClass('active');
    $('.wrap_images_menu .wrap_attachment_menu').css('z-index', '1');
    $('.wrap_images_menu .wrap_attachment_menu[data-id="'+$(this).parent().attr('id')+'"]').css('z-index', '3');
  });

  // $('#primary-menu li').on('mouseleave', function(){
  //   $('.wrap_images_menu .wrap_attachment_menu[data-id="'+$(this).attr('id')+'"]').css('z-index', '1');
  // });



  /*------------------------------------------------
    FOOTER
  ------------------------------------------------*/
  // ajax.wp_nonce

  // init global vue app instance
  // document.addEventListener( "DOMContentLoaded", initVueApp);

  initVueApp_formFooter();

  initVueApp_formSingle();

  initVueApp_formNewsletter();

  /*------------------------------------------------
    FORM FOOTER >>>>
  ------------------------------------------------*/
  function initVueApp_formFooter(){

    const vueFormFooter = new Vue({

      el: '#app-form-footer',
      data: {
        field: {
          name_1: '',
          name_2: '',
          email : '',
          category: '',
          object_message: '',
          message: '',
          condition: false,
        },
        message_error: {
          name_1: ['Il nome è obbligatorio','Nome non valido'],
          name_2: ['Il cognome è obbligatorio','Cognome non valido'],
          email : ['L\'email è obbligatoria', 'Formato email non valido'],
          category: ['Categoria obbliagatoria', 'Categoria non valida'],
          object_message: ['L\'oggetto del messaggio è obbligatorio',''],
          message: ['Il messaggio è obbligatorio',''],
          condition: ['Il consenso è obbligatorio',''],
          isValid: ['Ci sono degli errori nella compilazione. Ricontrolla i campi', '']
        },
        firstSubmit: true,
        isLoading: false,

      },
      mounted: function() {

      },
      computed: {
        validate: function() {
          let fields = {
            name_1: this.isDef(this.field.name_1) ? (re_is_nominative_user(this.field.name_1) ? true : 1) : 0,
            name_2: this.isDef(this.field.name_2) ? (re_is_nominative_user(this.field.name_2) ? true : 1) : 0,
            email: this.isDef(this.field.email) ? (re_is_email( this.field.email) ? true : 1) : 0,
            category: this.isDef(this.field.category.trim()) ? true : 0,
            object_message: this.isDef(this.field.object_message.trim()) ? true : 0,
            message: this.isDef(this.field.message.trim()) ? true : 0,
            condition: this.field.condition ? true : 0,
          };
          let isValid = true;
          for (let i in fields) {
            if (!(fields[i] === true)) {isValid = false; break; }
          }
          fields['isValid'] = isValid ? true : 0;
          return fields;
        },

        errorMessage: function() {
          let messages = {};
          for (let key in this.validate) {
            if (this.validate[key] === true || !(this.validate[key] === true) && this.firstSubmit) {
              messages[key] = null;
            }
            else {
              messages[key] = this.message_error[key][this.validate[key]];
            }
          }
          return messages;
        }

      },

      methods: {
        isDef: function(v) {
          return v !== '';
        },

        preventSubmit: function() {

          this.firstSubmit = false;

          if (!this.validate.isValid) {
            return;
          }

          this.firstSubmit = false;

          this.isLoading = true;

          var data_to_send = {
            dataUser: {
              name_1: this.field.name_1,
              name_2: this.field.name_2,
              email : this.field.email,
              category: this.field.category,
              object_message: this.field.object_message,
              message: this.field.message,
              link_page: window.location.href,
            },
            action: 'RequestGeneralPostMail',
            wp_nonce: ajax.wp_nonce,
            type_form: 'footer',
          };

          let vue = this;
          $.ajax({

              method: 'post',
              url: ajax.wp_url,
              data: data_to_send,
              dataType: 'json',
              beforeSend: function(){
                vue.isLoading = true;
                // button.addClass('loading');
              },
              complete: function(){
                vue.isLoading = false;
                // button.removeClass('loading');
              },
              error: function(data){
                console.log(data);
                _messageAlert(data);
              },
              success: function(data){
                console.log(data);
                alert(data.message.it);
                vue.resetForm();
              } // ajax.function

            }) // ajax.call

        },

        cssloader: function() {
          return _loader();
        },

        resetForm: function() {
          for (let i in this.field) {
            this.field[i] = typeof this.field[i] == 'string' ? '' : false;
          }
          this.firstSubmit = true;
        }

      }


    });

      // console.log(vueFormFooter);

  } // <<< function initVueApp()

  /*------------------------------------------------
    FORM FOOTER <<<<
  ------------------------------------------------*/

  /*------------------------------------------------
    FORM SINGLE >>>>
  ------------------------------------------------*/
function initVueApp_formSingle() {

  if (!document.getElementById('app-form-single')) {
    return;
  }

  const vueFormSingle = new Vue({

    el: '#app-form-single',
    data: {
      field: {
        name_1: '',
        name_2: '',
        email : '',
        category: '',
        object_message: '',
        message: '',
        condition: false,
      },
      message_error: {
        name_1: ['Il nome è obbligatorio','Nome non valido'],
        name_2: ['Il cognome è obbligatorio','Cognome non valido'],
        email : ['L\'email è obbligatoria', 'Formato email non valido'],
        category: ['Categoria obbliagatoria', 'Categoria non valida'],
        object_message: ['L\'oggetto del messaggio è obbligatorio',''],
        message: ['Il messaggio è obbligatorio',''],
        condition: ['Il consenso è obbligatorio',''],
        isValid: ['Ci sono degli errori nella compilazione. Ricontrolla i campi', ''],
      },
      firstSubmit: true,
      is_opened: false,
      isLoading: false,

    },
    mounted: function() {
      let cat = $('#category-name');
      this.field.category = cat ? cat.val() : '';
    },
    computed: {
      validate: function() {
        let fields = {
          name_1: this.isDef(this.field.name_1) ? (re_is_nominative_user(this.field.name_1) ? true : 1) : 0,
          name_2: this.isDef(this.field.name_2) ? (re_is_nominative_user(this.field.name_2) ? true : 1) : 0,
          email: this.isDef(this.field.email) ? (re_is_email( this.field.email) ? true : 1) : 0,
          category: this.isDef(this.field.category.trim()) ? true : 0,
          object_message: this.isDef(this.field.object_message.trim()) ? true : 0,
          message: this.isDef(this.field.message.trim()) ? true : 0,
          condition: this.field.condition ? true : 0,
        };
        let isValid = true;
        for (let i in fields) {
          if (!(fields[i] === true)) {isValid = false; break; }
        }
        fields['isValid'] = isValid ? true : 0;
        return fields;
      },

      errorMessage: function() {
        let messages = {};
        for (let key in this.validate) {
          if (this.validate[key] === true || !(this.validate[key] === true) && this.firstSubmit) {
            messages[key] = null;
          }
          else {
            messages[key] = this.message_error[key][this.validate[key]];
          }
        }
        return messages;
      }

    },

    methods: {
      isDef: function(v) {
        return v !== '';
      },

      preventSubmit: function() {

        this.firstSubmit = false;

        if (!this.validate.isValid) {
          // app messages for ...

          return;
        }
        this.firstSubmit = false;

        var data_to_send = {
          dataUser: {
            name_1: this.field.name_1,
            name_2: this.field.name_2,
            email : this.field.email,
            category: this.field.category,
            object_message: this.field.object_message,
            message: this.field.message,
            link_page: window.location.href,
          },
          action: 'RequestGeneralPostMail',
          wp_nonce: ajax.wp_nonce,
          type_form: 'single',
        };

        let vue = this;

        $.ajax({

            method: 'post',
            url: ajax.wp_url,
            data: data_to_send,
            dataType: 'json',
            beforeSend: function(){
              vue.isLoading = true;
              // button.addClass('loading');
            },
            complete: function(){
              vue.isLoading = false;
              // button.removeClass('loading');
            },
            error: function(data){
              console.log(data);
              _messageAlert(data);
            },
            success: function(data){
              console.log(data);
              alert(data.message.it);
              vue.resetForm();
            } // ajax.function
          }) // ajax.call
      },

      cssloader: function() {
        return _loader();
      },

      resetForm: function() {
        for (let i in this.field) {
          this.field[i] = typeof this.field[i] == 'string' ? '' : false;
        }
        this.firstSubmit = true;
      }

    }


  });

    // console.log(vueFormSingle);
    $('#request-info').on('click', function() {
      vueFormSingle.$set(vueFormSingle, 'is_opened', true);
    })

} // <<< function initVueApp()
/*------------------------------------------------
  FORM SINGLE <<<<
------------------------------------------------*/

/*------------------------------------------------
  FORM NEWSLETTER >>>>
------------------------------------------------*/

function initVueApp_formNewsletter() {
  if (!document.getElementById('newsletter-float-banner')) {
    return;
  }

  const vueFormNewsletter = new Vue({

    el: '#newsletter-float-banner',
    data: {
      field: {
        name_1: '',
        name_2: '',
        email : '',
        condition: false,
      },
      message_error: {
        name_1: ['Il nome è obbligatorio','Nome non valido'],
        name_2: ['Il cognome è obbligatorio','Cognome non valido'],
        email : ['L\'email è obbligatoria', 'Formato email non valido'],
        condition : ['Consenso obbligatorio', 'Consenso obbligatorio'],
        isValid: ['Errore nella compilazione'],
      },
      firstSubmit: true,
      is_opened: false,
      isLoading: false,

    },
    mounted: function() {

    },
    created: function(){
      if (!('w_status_newsletter' in localStorage) || localStorage['w_status_newsletter'] != 'off') {
        let vue = this;
        setTimeout(function() {
          vue.is_opened = true;
        }, 200);
      }

    },
    computed: {
      validate: function() {
        let fields = {
          name_1: this.isDef(this.field.name_1) ? (re_is_nominative_user(this.field.name_1) ? true : 1) : 0,
          name_2: this.isDef(this.field.name_2) ? (re_is_nominative_user(this.field.name_2) ? true : 1) : 0,
          email: this.isDef(this.field.email) ? (re_is_email( this.field.email) ? true : 1) : 0,
          condition: this.field.condition ? true : 0
        };
        let isValid = true;
        for (let i in fields) {
          if (!(fields[i] === true)) {isValid = false; break; }
        }
        fields['isValid'] = isValid;
        return fields;
      },

      errorMessage: function() {
        let messages = {};
        for (let key in this.validate) {
          if (this.validate[key] === true || !(this.validate[key] === true) && this.firstSubmit) {
            messages[key] = null;
          }
          else {
            messages[key] = this.message_error[key][this.validate[key]];
          }
        }
        return messages;
      }

    },

    methods: {
      isDef: function(v) {
        return v !== '';
      },

      preventSubmit: function() {

        this.firstSubmit = false;

        if (!this.validate.isValid) {
          return;
        }

        this.firstSubmit = false;

        this.isLoading = true;

        var data_to_send = {
          dataUser: {
            fname: this.field.name_1,
            lname: this.field.name_2,
            email: this.field.email,
          },
          action: 'RequestGeneralPostMail',
          wp_nonce: ajax.wp_nonce,
          type_form: 'newsletter',
        };

        let vue = this;

        $.ajax({

            method: 'post',
            url: ajax.wp_url,
            data: data_to_send,
            dataType: 'json',
            beforeSend: function(){
              vue.isLoading = true;
              // button.addClass('loading');
            },
            complete: function(){
              vue.isLoading = false;
              // button.removeClass('loading');
            },
            error: function(data){
              console.log(data);
              _messageAlert(data);
            },
            success: function(data){
              console.log(data);
              alert(data.message.it);
            } // ajax.function

          }) // ajax.call

      },

      clickBanner: function() {
        this.is_opened = !this.is_opened;
        this.resetForm();
        localStorage['w_status_newsletter'] = 'off';
      },

      closeBanner: function() {
        this.is_opened = false; // prevent
        this.resetForm();
        localStorage['w_status_newsletter'] = 'off';
      },
      resetForm: function() {
        for (let i in this.field) {
          this.field[i] = typeof this.field[i] == 'string' ? '' : false;
        }
        this.firstSubmit = true;
      }
    }


  });

    // console.log(vueFormNewsletter);
}
/*------------------------------------------------
  FORM NEWSLETTER <<<<
------------------------------------------------*/

function _messageAlert(data, hasAlert = true) {
  if ('responseJSON' in data && 'message' in data.responseJSON && 'it' in data.responseJSON.message) {
    message = data.responseJSON.message.it;
  } else if ('message' in data && 'it' in data.message) {
    message = data.message.it;
  } else  {
    message = 'Si è verificato un errore, si prega di riprovare più tardi';
  }
  if(hasAlert)
    alert(message);
}

function _loader() {
  return '<div class="lds-roller"><div></div><div></div><div></div><div>';
}

/*------------------------------------------------
  LINK ANCOR
------------------------------------------------*/

$('a[href*="#"]').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'')
    && location.hostname == this.hostname) {
    var $target = $(this.hash);
    $target = $target.length && $target || $('[name=' + this.hash.slice(1) +']');
    if ($target.length) {
    var targetOffset = $target.offset().top;
    $('html,body').animate({scrollTop: targetOffset}, 1000);
    return false;}
    }
  });

});



/* == Email == */
function re_is_email(pattern) {
  var regex = /^[a-z0-9._-]{3,}@[a-z0-9-]{1,}\.[a-z]{2,10}$/i;
  return regex.test(pattern.trim());
}
/* == Nominativo Utente == */
function re_is_nominative_user(pattern){
  var regex = /^[a-záàéèóòúùíì]{1,}([a-záàéèóòúùíì]{1,}[ ']*){1,}[a-záàéèóòúùíì]{1,}$/i;
  return regex.test(pattern.trim());
}
/* == Telefono == */
function re_is_tel(pattern){
  var regex = /^(\+[0-9]{2,4}[ ]*)?[0-9]{10,15}$/ig;
  return regex.test(pattern.trim());
}
