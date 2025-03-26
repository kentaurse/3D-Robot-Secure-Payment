jQuery(function($){
	if($('.cf_media_field').size() > 0) {
		var media_frame;
		var cfmf_current;
		var cfmf_text_title = 'Select an Image';
		var cfmf_text_select = 'Use Image';

		if (typeof cfmf_text == 'object') {
			if (typeof cfmf_text.image_title == 'string') {
				cfmf_text_title = cfmf_text.image_title;
			} else if (typeof cfmf_text.title == 'string') {
				cfmf_text_title = cfmf_text.title;
			}
			if (typeof cfmf_text.image_button == 'string') {
				cfmf_text_select = cfmf_text.image_button;
			} else if (typeof cfmf_text.button == 'string') {
				cfmf_text_select = cfmf_text.button;
			}
		}

		// click event
		$(document).on('click', '.cf_media_field .cfmf-select-img', function(e){
			e.preventDefault();
			if (typeof media_frame != 'undefined') {
				media_frame.close();
			}

			// create and open new file frame
			media_frame = wp.media({
				title: cfmf_text_title,
				library: {
					type: 'image'
				},
				button: {
					text: cfmf_text_select
				},
				multiple: false,
			});

			media_frame.on('open',function(){
				var selection = media_frame.state().get('selection');
				var selected_media_id = cfmf_current.find('.cf_media_id').val();
				if (selected_media_id) {
					selection.add(wp.media.attachment(selected_media_id));
				}
			});

			// callback for selected image
			media_frame.on('select', function(){
				var selection = media_frame.state().get('selection').first();
				cfmf_current.find('.cf_media_id').val(selection.attributes.id);
				cfmf_current.find('.preview_field').html('<img src="'+selection.attributes.url+'" />');
				cfmf_current.find('.cfmf-delete-img').show();
				cfmf_current = null;
			});

			// form element
			cfmf_current = $(this).closest('.cf_media_field');

			// open
			media_frame.open();
		});

		// delete image
		$(document).on('click', '.cf_media_field .cfmf-delete-img', function(e){
			var c = $(this).closest('.cf_media_field');
			c.find('.cf_media_id').val('');
			c.find('.preview_field').html('');
			$(this).hide();
		});
	}

	if($('.cf_video_field').size() > 0) {
		var media_video_frame;
		var cfvf_current;
		var cfvf_text_title = 'Select an Video';
		var cfvf_text_select = 'Use Video';

		if (typeof cfmf_text == 'object') {
			if (typeof cfmf_text.video_title == 'string') {
				cfvf_text_title = cfmf_text.video_title;
			}
			if (typeof cfmf_text.video_button == 'string') {
				cfvf_text_select = cfmf_text.video_button;
			}
		}
		if (typeof cfvf_text == 'object') {
			if (typeof cfvf_text.title == 'string') {
				cfvf_text_title = cfvf_text.title;
			}
			if (typeof cfvf_text.button == 'string') {
				cfvf_text_select = cfvf_text.button;
			}
		}

		// click event
		$(document).on('click', '.cf_video_field .cfvf-select-video', function(e){
			e.preventDefault();
			if (typeof media_video_frame != 'undefined') {
				media_video_frame.close();
			}

			// create and open new file frame
			media_video_frame = wp.media({
				title: cfvf_text_title,
				library: {
					type: 'video'
				},
				button: {
					text: cfvf_text_select
				},
				multiple: false,
			});

			media_video_frame.on('open',function(){
				var selection = media_video_frame.state().get('selection');
				var selected_media_id = cfvf_current.find('.cf_media_id').val();
				if (selected_media_id) {
					selection.add(wp.media.attachment(selected_media_id));
				}
			});

			// callback for selected video
			media_video_frame.on('select', function(){
				var selection = media_video_frame.state().get('selection').first();
				cfvf_current.find('.cf_media_id').val(selection.attributes.id);
				if (selection.attributes.url) {
					cfvf_current.find('.preview_field').html('<p class="media_url">'+selection.attributes.url+'</p>');
				} else {
					cfvf_current.find('.preview_field').html('');
				}
				cfvf_current.find('.cfvf-delete-video').show();
				cfvf_current = null;
			});

			// form element
			cfvf_current = $(this).closest('.cf_video_field');

			// open
			media_video_frame.open();
		});

		// delete video
		$(document).on('click', '.cf_video_field .cfvf-delete-video', function(e) {
			var c = $(this).closest('.cf_video_field');
			c.find('.cf_media_id').val('');
			c.find('.preview_field').html('');
			$(this).hide();
		});
	}
});
