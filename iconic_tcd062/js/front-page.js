jQuery(function($){

	/**
	 * 初期化処理
	 */
	$(document).on('js-initialized', function(){
		// header slider
		if ($('#js-index-slider').length) {
			var $slider = $('#js-index-slider');
			var $slides = $('#js-index-slider .p-index-slider__item');

			$slider.attr('data-slides', $slides.length).slick({
				infinite: true,
				dots: true,
				arrows: false,
				prevArrow: '<button type="button" class="slick-prev">&#xe90f;</button>',
				nextArrow: '<button type="button" class="slick-next">&#xe910;</button>',
				slidesToShow: 1,
				slidesToScroll: 1,
				lazyLoad: 'progressive',
				adaptiveHeight: true,
				autoplay: true,
				speed: 1000,
				autoplaySpeed: $('#js-index-slider').attr('data-slide-time') || 7000,
				responsive: [
					{
						breakpoint: 992,
						settings: {
							dots: false,
							arrows: false
						}
					}
				]
			});

			// first slide activate
			setTimeout(function(){
				$slides.filter('.slick-active').addClass('is-active');
			}, 1000);

			// beforeChange
			$slider.on('beforeChange', function(event, slick, currentSlide, nextSlide) {
				$slides.filter('.is-active').removeClass('is-active');
			});

			// afterChange
			$slider.on('afterChange', function(event, slick, currentSlide) {
				$slides.filter('.slick-active').addClass('is-active');
			});
		}

		// news ticker
		if ($('#js-index-newsticker').length) {
			$('#js-index-newsticker').slick({
				infinite: true,
				dots: false,
				arrows: false,
				slidesToShow: 1,
				slidesToScroll: 1,
				adaptiveHeight: true,
				autoplay: true,
				speed: 1000,
				fade: true,
				autoplaySpeed: $('#js-index-newsticker').attr('data-slide-time') || 7000
			});
		}

		// ヘッダーカルーセル
		if ($('.p-index-carousel').length) {
			$('.p-index-carousel').each(function(){
				$(this).slick({
					infinite: true,
					dots: false,
					arrows: true,
					prevArrow: '<button type="button" class="slick-prev">&#xe90f;</button>',
					nextArrow: '<button type="button" class="slick-next">&#xe910;</button>',
					slidesToShow: 5,
					slidesToScroll: 5,
					adaptiveHeight: true,
					autoplay: true,
					speed: 1000,
					autoplaySpeed: $(this).attr('data-slide-time') || 7000,
					responsive: [
						{
							breakpoint: 992,
							settings: {
								arrows: true,
								slidesToShow: 4,
								slidesToScroll: 4
							}
						},
						{
							breakpoint: 768,
							settings: {
								arrows: false,
								slidesToShow: 3,
								slidesToScroll: 3,
								swipeToSlide: true
							}
						},
						{
							breakpoint: 481,
							settings: {
								arrows: false,
								slidesToShow: 2,
								slidesToScroll: 1,
								swipeToSlide: true
							}
						}
					]
				});
			});
		}
	});

});
