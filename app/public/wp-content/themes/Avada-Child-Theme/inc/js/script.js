jQuery(document).ready(function($) {

    $('img[src$=".svg"]').each(function () {
        var $img = jQuery(this);
        var imgURL = $img.attr('src');
        var attributes = $img.prop("attributes");
        $.get(imgURL, function (data) {
            var $svg = jQuery(data).find('svg');
            $svg = $svg.removeAttr('xmlns:a');
            $.each(attributes, function () {
                $svg.attr(this.name, this.value);
            });
            $img.replaceWith($svg);
        }, 'xml');
    });

    //Hero Sliders
    var heroSlider = $('.hero-slider.style-4');
    heroSlider.slick({
        slidesToShow: 3,
        centerMode: true,
        variableWidth: true,
        arrows: true,
        infinite: true,
        autoplay: false,
        autoplaySpeed: 12000,
        adaptiveHeight: true,
        responsive: [
            {
              breakpoint: 1200,
              settings: {
                centerMode: false,
                adaptiveHeight: true,
              }
            },
            {
              breakpoint: 1100,
              settings: {
                slidesToShow: 1,
                variableWidth: false,
                centerMode: false,
                adaptiveHeight: false,
              }
            },
        ]
    });

    var heroSlider = $('.main-slider, .hero-slider.style-1, .hero-slider.style-2, .hero-slider.style-3');
    heroSlider.slick({
        arrows: true,
        dots: false,
        infinite: true,
        autoplay: true,
        fade: true,
        speed: 3000,
        pauseOnHover: false,
        autoplaySpeed: 8000
    });

    var heroSlider = $('.slider');
    heroSlider.slick({
        arrows: true,
        dots: false,
        infinite: true,
        autoplay: true,
        fade: true,
        speed: 3000,
        pauseOnHover: false,
        autoplaySpeed: 8000
    });

    if ( $('.pofw-product-options-wrapper .fieldset').children().length == 0 ) {
        $('.single-product h2.choose-product-options').hide();
    }else{
        $('.single-product h2.choose-product-options').show();
    }

    (function($) {
        $(document).on('facetwp-loaded', function() {
            if (FWP.loaded) {
                $('html, body').animate({
                    scrollTop: $('.facetwp-template').offset().top - 150
                }, 500);
            }
        });
    })(jQuery);


    //Set fluid containers
    $(".fluid-container").each(function() { 
        $(this).closest(".fusion-fullwidth").addClass("fluid-container");
    });

    //Set Container Gradients
    $(".container-gradient-bg").each(function() { 
        $(this).closest(".fusion-fullwidth").addClass("gradient-bg");
    });


    /**
    * Match heights on elements
    */
    function resourceHeights() {
        // Select and loop the container element of the elements you want to equalise
        $('.equal-heights').each(function(){
          // Cache the highest
          var highestBox = 0;
          // Select and loop the elements you want to equalise
          $('.equal-height', this).each(function(){
            // If this box is higher than the cached highest then store it
            $(this).css("min-height", 'auto');
            if($(this).outerHeight() > highestBox) {
              highestBox = $(this).outerHeight(); 
            }
          });
          // Set the height of all those children to whichever was highest
          $('.equal-height',this).css("min-height", highestBox);
        }); 
    }
    resourceHeights();

    $(window).resize(function(){
        resourceHeights();
    });

    /**
    * Video Popup
    */
    $('.popup-youtube').magnificPopup({
      disableOn: 700,
      type: 'iframe',
      mainClass: 'mfp-fade',
      removalDelay: 160,
      preloader: false,

      fixedContentPos: false
    });

    $('.open-popup-link').magnificPopup({
      type:'inline',
      midClick: true
    });

});