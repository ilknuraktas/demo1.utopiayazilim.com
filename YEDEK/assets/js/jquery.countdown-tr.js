/* http://keith-wood.name/countdown.html
* Turkish initialisation for the jQuery countdown extension
* Written by Bekir Ahmetoğlu (bekir@cerek.com) Aug 2008. */
(function($) {
	$.countdown.regional['tr'] = {
		labels: ['Yıl', 'Ay', 'Hafta', 'Gün', 'Saat', 'Dk.', 'San.'],
		labels1: ['Yıl', 'Ay', 'Hafta', 'Gün', 'Saat', 'Dk.', 'San.'],
		compactLabels: ['y', 'a', 'h', 'g'],
		whichLabels: null,
		timeSeparator: ':', isRTL: false};
	$.countdown.setDefaults($.countdown.regional['tr']);
})(jQuery);
