jQuery(function($){

	/**
	 * グローバルナビゲーション モバイル
	 */
	$('#js-menu-button').click(function() {
		var w = window.innerWidth || $('#js-header').width();
		if (w < 992) {
			$('#js-header-view-cart').removeClass('is-active');
			$(this).toggleClass('is-active');
			$('#js-global-nav').stop().slideToggle(500);
		}
		return false;
	});
	$('#js-global-nav .menu-item-has-children > a span').click(function() {
		var w = window.innerWidth || $('#js-header').width();
		if (w < 992) {
			$(this).toggleClass('is-active');
			$(this).closest('.menu-item-has-children').toggleClass('is-active').find('> .sub-menu').stop().slideToggle(300);
		}
		return false;
	});

	/**
	 * ヘッダー検索
	 */
	$('#js-header #js-search-button').click(function() {
		$(this).closest('#js-header').toggleClass('is-header-search-active');
		return false;
	});

	/**
	 * ヘッダーカート
	 */
	if ($('#js-header-cart').length) {
		var hide_viewcart_timer;
		var hide_viewcart_interval = function() {
			clearInterval(hide_viewcart_timer);
			var w = window.innerWidth || $('#js-header').width();
			if (w < 992) return;
			hide_viewcart_timer = setInterval(function() {
				if (!$('#js-header-cart').is(':hover') && !$('#js-header-view-cart').is(':hover')) {
					clearInterval(hide_viewcart_timer);
					$('#js-header-view-cart').removeClass('is-active');
				}
			}, 20);
		};

		var set_viewcart_top = function() {
			var w = window.innerWidth || $('#js-header').width();
			if (w < 992) return;
			$('#js-header-view-cart').css('top', $('#js-header-cart').height());
		};
		set_viewcart_top();
		$(window).on('load resize', set_viewcart_top);

		$('#js-header-cart').hover(
			function() {
				$('#js-header-view-cart').addClass('is-active');
			},
			function() {
				hide_viewcart_interval();
			}
		);
	}

	/**
	 * ヘッダーカートモバイル
	 */
	$('#js-header-cart--mobile').click(function() {
		$('#js-menu-button.is-active').toggleClass('is-active');
		$('#js-global-nav').stop().hide();
		$('#js-header-view-cart').toggleClass('is-active');
		return false;
	});

	/**
	 * メガメニュー
	 */
	if ($('#js-header .p-megamenu').length) {
		var hide_megamenu_timer = {};
		var hide_megamenu_interval = function(menu_id) {
			if (hide_megamenu_timer[menu_id]) {
				clearInterval(hide_megamenu_timer[menu_id]);
				hide_megamenu_timer[menu_id] = null;
			}
			hide_megamenu_timer[menu_id] = setInterval(function() {
				if (!$('#menu-item-' + menu_id).is(':hover') && !$('#p-megamenu--' + menu_id).is(':hover')) {
					clearInterval(hide_megamenu_timer[menu_id]);
					hide_megamenu_timer[menu_id] = null;
					$('#menu-item-' + menu_id + ', #p-megamenu--' + menu_id).removeClass('is-active');
				}
			}, 20);
		};
		$('#js-global-nav .menu-megamenu').hover(
			function(){
				var menu_id = $(this).attr('id').replace('menu-item-', '');
				var w = window.innerWidth || $('#js-header').width();
				if (hide_megamenu_timer[menu_id]) {
					clearInterval(hide_megamenu_timer[menu_id]);
					hide_megamenu_timer[menu_id] = null;
				}
				if (w >= 992) {
					$(this).addClass('is-active');
					$('#p-megamenu--' + menu_id).addClass('is-active');
				}
			},
			function(){
				var menu_id = $(this).attr('id').replace('menu-item-', '');
				hide_megamenu_interval(menu_id);
			}
		);
		$('#js-header').on('mouseout', '.p-megamenu', function(){
			var menu_id = $(this).attr('id').replace('p-megamenu--', '');
			hide_megamenu_interval(menu_id);
		});

		var set_megamenu_top = function() {
			if ($('#js-header').hasClass('is-header-fixed')) {
				$('.p-megamenu').css('top', Math.ceil($('#js-global-nav').height()) + ($('#wpadminbar').height()||0));
			} else {
				$('.p-megamenu').css('top', Math.ceil($('#js-global-nav').offset().top) + $('#js-global-nav').height() - ($('#wpadminbar').height()||0));
			}
		};
		set_megamenu_top();
		$(window).on('load resize', set_megamenu_top);

		var megamenu_scroll_timer;
		$(window).on('scroll', function(){
			clearTimeout(megamenu_scroll_timer);
			var w = window.innerWidth || $('#js-header').width();
			if (w >= 992) {
				megamenu_scroll_timer = setTimeout(set_megamenu_top, 100);
			}
		});

		/**
		 * メガメニューB (type3)
		 */
		$('.p-megamenu--type3 > ul > li > a').hover(
			function(){
				var $li = $(this).closest('li');
				$li.addClass('is-active');
				$li.siblings('.is-active').removeClass('is-active');
				set_megamenu_type3_height();
			},
			function(){}
		);

		var set_megamenu_type3_height = function(){
			$('.p-megamenu--type3').each(function(){
				if ($(this).find('> ul > li').length < 5) {
					$(this).find('> ul').css('minHeight', 0);
					$(this).find('> ul').css('minHeight', $(this).find('.is-active .sub-menu li').height() + parseInt($(this).find('> ul').css('borderTopWidth'), 10));
				}
			});
		};
		set_megamenu_type3_height();
		$(window).on('load resize', set_megamenu_type3_height);
	}

	/**
	 * ページトップ
	 */
	var pagetop = $('#js-pagetop');
	pagetop.hide().click(function() {
		$('body, html').animate({
			scrollTop: 0
		}, 1000);
		return false;
	});
	$(window).scroll(function() {
		if ($(this).scrollTop() > 100) {
			pagetop.fadeIn(1000);
		} else {
			pagetop.fadeOut(300);
		}
	});

	/**
	 * 記事一覧でのカテゴリークリック
	 */
	$('a span[data-url]').hover(
		function(){
			var $a = $(this).closest('a');
			$a.attr('data-href', $a.attr('href'));
			if ($(this).attr('data-url')) {
				$a.attr('href', $(this).attr('data-url'));
			}
		},
		function(){
			var $a = $(this).closest('a');
			$a.attr('href', $a.attr('data-href'));
		}
	);

	/**
	 * コメント
	 */
	if ($('#js-comment__tab').length) {
		var commentTab = $('#js-comment__tab');
		commentTab.find('a').click(function() {
			if (!$(this).parent().hasClass('is-active')) {
				$($('.is-active a', commentTab).attr('href')).animate({opacity: 'hide'}, 0);
				$('.is-active', commentTab).removeClass('is-active');
				$(this).parent().addClass('is-active');
				$($(this).attr('href')).animate({opacity: 'show'}, 1000);
			}
			return false;
		});
	}

	/**
	 * カテゴリー ウィジェット
	 */
	$('.p-widget-categories li ul.children').each(function() {
		$(this).closest('li').addClass('has-children');
		$(this).hide().before('<span class="toggle-children"></span>');
	});
	$('.p-widget-categories .toggle-children').click(function() {
		$(this).closest('li').toggleClass('is-active').find('> ul.children').slideToggle();
	});

	/**
	 * アーカイブウィジェット
	 */
	if ($('.p-dropdown').length) {
		$('.p-dropdown__title').click(function() {
			$(this).toggleClass('is-active');
			$('+ .p-dropdown__list:not(:animated)', this).slideToggle();
		});
	}

	/**
	 * WP検索ウィジェット
	 */
	$('.p-widget .searchform #searchsubmit').val($('<div>').html('&#xe915;').text());

	/**
	 * フッターウィジェット
	 */
	if ($('#js-footer-widget').length) {
		var footer_widget_resize_timer;
		var footer_widget_layout = function(){
			$('#js-footer-widget .p-widget').filter('.p-footer-widget__border-top').removeClass('p-footer-widget__border-top');

			var w = window.innerWidth || $('#js-header').width();
			if (w < 992) {
				var $elems = $('#js-footer-widget .p-widget:visible');
				var elems_top = $elems.position().top || 0;
				var top = elems_top;
				$elems.each(function(i){
					var pos = $(this).position();
					if (pos.top !== elems_top && i > 0) {
						$(this).addClass('p-footer-widget__border-top');
					}
				});
			}
		};
		$(window).on('load', footer_widget_layout);
		$(window).on('resize', function(){
			clearTimeout(footer_widget_resize_timer);
			footer_widget_resize_timer = setTimeout(footer_widget_layout, 100);
		});
	}

	/**
	 * object-fit: cover未対応ブラウザ対策
	 */
	var ua = window.navigator.userAgent.toLowerCase();
	if (ua.indexOf('msie') > -1 || ua.indexOf('trident') > -1) {
		// object-fit: cover前提のcssをリセット
		var init_object_fit_cover = function(el) {
			$(el).css({
				width: 'auto',
				height: 'auto',
				maxWidth: 'none',
				minWidth: '100%',
				minHeight: '100%',
				top : 0,
				left : 0
			});
		};

		// サイズに応じてcss指定
		var fix_object_fit_cover = function(el) {
			$(el).each(function(){
				var $cl, cl_w, cl_h, cl_ratio, img_w, img_h, img_ratio, inc_ratio;
				$cl = $(this).closest('.js-object-fit-cover');
				cl_w = $cl.innerWidth();
				cl_h = $cl.innerHeight();
				cl_ratio = cl_w / cl_h;
				img_w = $(this).width();
				img_h = $(this).height();
				img_ratio = img_w / img_h;
				inc_ratio = cl_ratio - img_ratio;

				// 同じ縦横比
				if (inc_ratio >= 0 && inc_ratio < 0.1 || inc_ratio <= 0 && inc_ratio > -0.1) {
					$(this).removeAttr('style');

				// 縦長
				} else if (cl_ratio > img_ratio) {
					var t = (cl_w / img_w * img_h - cl_h) / 2 * -1;
					if (t < 0) {
						$(this).css({
							width: '100%',
							top: t
						});
					}

				// 横長・正方形
				} else {
					var l = (cl_h / img_h * img_w - cl_w) / 2 * -1;
					if (l < 0) {
						$(this).css({
							height: '100%',
							left: l
						});
					}
				}
			});
		};

		// cssリセット
		init_object_fit_cover($('.js-object-fit-cover img'));

		// 画像読み込み時処理
		$('.js-object-fit-cover img').load(function(){
			fix_object_fit_cover(this);
		}).each(function(){
			if (this.complete || this.readyState === 4 || this.readyState === 'complete'){
				fix_object_fit_cover(this);
			}
		});

		var object_fit_cover_resize_timer;
		$(window).on('resize', function(){
			clearTimeout(object_fit_cover_resize_timer);
			object_fit_cover_resize_timer = setTimeout(function(){
				$('.js-object-fit-cover img').each(function(){
					init_object_fit_cover(this);
					fix_object_fit_cover(this);
				});
			}, 500);
		});
	}

	/**
	 * Welcart 商品画像
	 */
	if ($('#js-entry-item__images').length) {
		$('#js-entry-item__images .p-entry-item__subimage img').click(function(){
			var w = window.innerWidth || $('#js-header').width();
			var $mainimage = $(this).closest('#js-entry-item__images').find('.p-entry-item__mainimage');

			if ($mainimage.find('img').attr('src') != this.src) {
				$mainimage.html($(this).clone());
				$('#js-entry-item__images .p-entry-item__subimage.is-active').removeClass('is-active');
				$(this).closest('.p-entry-item__subimage').addClass('is-active');
			}
		});
	}

	/**
	 * 初期化処理
	 */
	$(document).on('js-initialized', function(){
		// ページヘッダー
		if ($('#js-page-header').length) {
			$('#js-page-header').addClass('is-active');
		}

		// 複数行対応3点リーダ
		if ($('.js-multiline-ellipsis').length) {
			initMultilineEllipsis('.js-multiline-ellipsis');
		}

		// WCEX Widget Cart対応
	    if (typeof widgetcart != 'undefined' && !$('#wgct_alert').length) {
			$('body').append('<div id="wgct_alert"></div>');
		}
	});

	/**
	 * WCEX Widget Cart対応（カート追加後のリロード処理）
	 */
	$('.p-wc-button-sku').click(function() {
		if ($('#wgct_alert').length) {
			$(this).delay(100).queue(function(){
				location.reload(false);
			});
		}
	});
});


/**
 * 複数行対応3点リーダ
 */
var multilineEllipsisVars = {
	winHeight: 0,
	winWidth: 0,
	timer: null
};
var initMultilineEllipsis = function(el){
	if (!el) {
		el = '.js-multiline-ellipsis';
	}
	jQuery(el).each(function(){
		jQuery(this).attr('data-default-text', jQuery(this).text());
	});
	multilineEllipsisVars.winHeight = 0;
	multilineEllipsisVars.winWidth = 0;
	setMultilineEllipsis(el);
	jQuery(window).off('resize.multilineEllipsis').on('resize.multilineEllipsis', resizeMultilineEllipsis);
};
var setMultilineEllipsis = function(el, force){
	var winHeight = window.innerHeight;
	var winWidth = window.innerWidth;

	if (!force && winHeight == multilineEllipsisVars.winHeight && winWidth == multilineEllipsisVars.winWidth) {
		return false;
	}
	multilineEllipsisVars.winHeight = winHeight;
	multilineEllipsisVars.winWidth = winWidth;

	if (!el) {
		el = '.js-multiline-ellipsis';
	}

	jQuery(el).each(function(){
		var $target = jQuery(this);
		if ($target.is(':hidden')) return;

		var text = $target.attr('data-default-text');
		if (!text) return;
		$target.text(text);
		var targetHeight = $target.innerHeight();
		var targetWidth;
		if (document.defaultView) {
			// サブピクセル対応の横幅取得
			var style = document.defaultView.getComputedStyle(this, '');
			targetWidth = parseFloat(style.getPropertyValue('width'));
		}
		if (!targetWidth) {
			targetWidth = $target.innerWidth();
		}
		var $clone = $target.clone();
		$clone.css({
			display : 'none',
			height: 'auto',
			maxHeight: 'none',
			overflow : 'visible',
			position : 'absolute',
			width: targetWidth
		}).text(text);

		$target.after($clone);
		while(text.length > 0 && $clone.innerHeight() > targetHeight) {
			text = text.substr(0, text.length - 1);
			$clone.text(text + '...');
		}
		$target.text($clone.text());
		$clone.remove();
	});
};
var resizeMultilineEllipsis = function(){
	clearTimeout(multilineEllipsisVars.timer);
	multilineEllipsisVars.timer = setTimeout(setMultilineEllipsis, 500);
};