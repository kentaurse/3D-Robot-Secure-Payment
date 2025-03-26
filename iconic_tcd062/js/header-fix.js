jQuery(function($) {

	$(window).on('scroll', function() {
		// ヘッダーを固定する
		if ($(this).scrollTop() > 300) {
			$('#js-header').addClass('is-header-fixed');
		} else {
			$('#js-header').removeClass('is-header-fixed');
		}
	});

});