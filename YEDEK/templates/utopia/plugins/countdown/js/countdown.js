(function (jQuery) {
    jQuery.fn.JTV_CountDown = function (options) {
        return this.each(function () {
            new jQuery.JTV_CountDown(this, options);
        });
    }
    jQuery.JTV_CountDown = function (obj, options) {
        this.options = jQuery.extend({
            autoStart: true,
            LeadingZero: true,
            DisplayFormat: "<div><span>%%D%%</span> Gün</div><div><span>%%H%%</span> Saat</div><div><span>%%M%%</span> Dakika</div><div><span>%%S%%</span> Saniye</div>",
            FinishMessage: "Expired",
            CountActive: true,
            TargetDate: null
        }, options || {});
        if (this.options.TargetDate == null || this.options.TargetDate == '') {
            return;
        }
        this.timer = null;
        this.element = obj;
        this.CountStepper = -1;
        this.CountStepper = Math.ceil(this.CountStepper);
        this.SetTimeOutPeriod = (Math.abs(this.CountStepper) - 1) * 1000 + 990;
        var dthen = new Date(this.options.TargetDate);
        var dnow = new Date();
        if (this.CountStepper > 0) {
            ddiff = new Date(dnow - dthen);
        } else {
            ddiff = new Date(dthen - dnow);
        }
        gsecs = Math.floor(ddiff.valueOf() / 1000);
        this.CountBack(gsecs, this);
    };
    jQuery.JTV_CountDown.fn = jQuery.JTV_CountDown.prototype;
    jQuery.JTV_CountDown.fn.extend = jQuery.JTV_CountDown.extend = jQuery.extend;
    jQuery.JTV_CountDown.fn.extend({
        calculateDate: function (secs, num1, num2) {
            var s = ((Math.floor(secs / num1)) % num2).toString();
            if (this.options.LeadingZero && s.length < 2) {
                s = "0" + s;
            }
            return "<b>" + s + "</b>";
        }, CountBack: function (secs, self) {
            if (secs < 0) {
                self.element.innerHTML = '<div class="labelexpired"> ' + self.options.FinishMessage + "</div>";
                return;
            }
            clearInterval(self.timer);
            DisplayStr = self.options.DisplayFormat.replace(/%%D%%/g, self.calculateDate(secs, 86400, 100000));
            DisplayStr = DisplayStr.replace(/%%H%%/g, self.calculateDate(secs, 3600, 24));
            DisplayStr = DisplayStr.replace(/%%M%%/g, self.calculateDate(secs, 60, 60));
            DisplayStr = DisplayStr.replace(/%%S%%/g, self.calculateDate(secs, 1, 60));
            self.element.innerHTML = DisplayStr;
            if (self.options.CountActive) {
                self.timer = null;
                self.timer = setTimeout(function () {
                    self.CountBack((secs + self.CountStepper), self);
                }, (self.SetTimeOutPeriod));
            }
        }
    });
    jQuery(document).on("ready", function () {
        jQuery('[data-countdown="countdown"]').each(function (index, el) {
            var jQuerythis = jQuery(this);
            var jQuerydate = jQuerythis.data('date').split("-");
            jQuerythis.JTV_CountDown({
                TargetDate: jQuerydate[0] + "/" + jQuerydate[1] + "/" + jQuerydate[2] + " " + jQuerydate[3] + ":" + jQuerydate[4] + ":" + jQuerydate[5],
                DisplayFormat: "<div class=\"timer-box sale-end-timer-days\"><div class=\"digits\">%%D%%</div><span>Gün</span></div><div class=\"timer-box sale-end-timer-hours\"><div class=\"digits\">%%H%%</div><span>Saat</span></div><div class=\"timer-box sale-end-timer-minutes\"><div class=\"digits\">%%M%%</div><span>Dakika</span></div><div class=\"timer-box sale-end-timer-seconds\"><div class=\"digits\">%%S%%</div><span>Saniye</span></div>",
                FinishMessage: ""
            });
        });
    });
})(jQuery)