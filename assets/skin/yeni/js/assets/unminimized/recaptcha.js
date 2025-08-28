(function ($) {
  'use strict';

  Utopia.behaviors.recaptcha = {
    attach: function (context, settings) {

      var forms = $('[data-brk-library="recaptcha"]:not(.brk-recaptcha-rendered)');

      if (!forms.length) {
        return;
      }

      if (typeof grecaptcha === 'undefined') {
        console.log('Waiting for the grecaptcha');
        setTimeout(Utopia.behaviors.recaptcha.attach, settings.timeout_delay, context, settings);
        return;
      }

      forms.addClass('brk-recaptcha-rendered');

      grecaptcha.ready(function() {
        grecaptcha.execute(Utopia.settings.recaptcha_api_key, {action: 'login'}).then(function(token) {
           forms.append('<input name="g-recaptcha-response" type="hidden" value="' + token +'">');
        });
      });

    }
  }
})(jQuery);