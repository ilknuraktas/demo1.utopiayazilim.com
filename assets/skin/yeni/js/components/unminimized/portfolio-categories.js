(function ($) {
  'use strict';

  Utopia.behaviors.portfolio_categories_init = {
    attach: function (context, settings) {
      if (typeof $.fn.slick === 'undefined') {
        console.log('Waiting for the slick library');
        setTimeout(Utopia.behaviors.portfolio_categories_init.attach, settings.timeout_delay, context, settings);
        return;
      }
      $('.brs-portfolio-carousel-item:not(.rendered)', context)
        .slick({
          infinite: true,
          dots: true,
          prevArrow: false,
          nextArrow: false,
          slidesToshow: 4,
          slidesToScroll: 4,
          responsive: [{
              breakpoint: 1024,
              settings: {
                slidesToshow: 3,
                slidesToScroll: 3,
                infinite: true,
                dots: true
              }
            },
            {
              breakpoint: 600,
              settings: {
                slidesToshow: 2,
                slidesToScroll: 2
              }
            },
            {
              breakpoint: 480,
              settings: {
                slidesToshow: 1,
                slidesToScroll: 1
              }
            }

          ]
        }).addClass('rendered');
    }
  }
})(jQuery);
