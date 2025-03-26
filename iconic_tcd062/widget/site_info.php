<?php
/**
 * Site info (tcd ver)
 */
class Site_Info_Widget extends WP_Widget {

	/**
	 * Default instance.
	 */
	protected $default_instance = array(
		'title' => '',
		'title_font_size' => 36,
		'title_font_size_mobile' => 26,
		'image' => '',
		'image_retina' => 0,
		'image_url' => '',
		'image_target_blank' => 0,
		'description' => '',
		'button' => '',
		'button_font_color' => '#ffffff',
		'button_bg_color' => '#000000',
		'button_font_color_hover' => '#ffffff',
		'button_bg_color_hover' => '#000000',
		'button_url' => '',
		'button_target_blank' => 0,
		'use_sns_theme_options' => 1,
		'instagram_url' => '',
		'twitter_url' => '',
		'pinterest_url' => '',
		'facebook_url' => '',
		'googleplus_url' => '',
		'youtube_url' => '',
		'contact_url' => '',
		'show_rss' => 0
	);

	function __construct() {
		global $dp_options;
		if ( ! $dp_options ) $dp_options = get_design_plus_option();

		if ( isset( $dp_options['primary_color'] ) ) {
			$this->default_instance['button_bg_color'] = $dp_options['primary_color'];
			$this->default_instance['button_bg_color_hover'] = $dp_options['primary_color'];
		}
		if ( isset( $dp_options['secondary_color'] ) ) {
			$this->default_instance['button_bg_color_hover'] = $dp_options['secondary_color'];
		}

		parent::__construct(
			'site_info_widget', // ID
			__( 'Site info (tcd ver)', 'tcd-w' ), // Name
			array(
				'classname' => 'site_info_widget',
				'description' => __( 'Displays site info.', 'tcd-w' )
			)
		);
	}

	function widget( $args, $instance ) {
		global $dp_options;
		if ( ! $dp_options ) $dp_options = get_design_plus_option();

		extract( $args );

		$title = apply_filters( 'widget_title', $instance['title'] );

		$instance = array_merge( $this->default_instance, $instance );

		// image
		if ( $instance['image'] ) {
			$image = wp_get_attachment_image_src( $instance['image'], 'full' );
		}

		// description
		if ( $instance['description'] ) {
			$instance['description'] = trim( $instance['description'] );
		}

		// button
		if ( $instance['button'] ) {
			$instance['button'] = trim( $instance['button'] );
		}

		// sns
		$sns_html = '';

		if ( $instance['use_sns_theme_options'] ) {
			$instagram_url = $dp_options['instagram_url'];
			$twitter_url = $dp_options['twitter_url'];
			$pinterest_url = $dp_options['pinterest_url'];
			$facebook_url = $dp_options['facebook_url'];
			$googleplus_url = $dp_options['googleplus_url'];
			$youtube_url = $dp_options['youtube_url'];
			$contact_url = $dp_options['contact_url'];
			$show_rss = $dp_options['show_rss'];
		} else {
			$instagram_url = $instance['instagram_url'];
			$twitter_url = $instance['twitter_url'];
			$pinterest_url = $instance['pinterest_url'];
			$facebook_url = $instance['facebook_url'];
			$googleplus_url = $instance['googleplus_url'];
			$youtube_url = $instance['youtube_url'];
			$contact_url = $instance['contact_url'];
			$show_rss = $instance['show_rss'];
		}

		if ( $instagram_url ) {
			$sns_html .= '<li class="p-social-nav__item p-social-nav__item--instagram"><a href="' . esc_attr( $instagram_url ) . '" target="_blank"></a></li>';
		}
		if ( $twitter_url ) {
			$sns_html .= '<li class="p-social-nav__item p-social-nav__item--twitter"><a href="' . esc_attr( $twitter_url ) . '" target="_blank"></a></li>';
		}
		if ( $pinterest_url ) {
			$sns_html .= '<li class="p-social-nav__item p-social-nav__item--pinterest"><a href="' . esc_attr( $pinterest_url ) . '" target="_blank"></a></li>';
		}
		if ( $facebook_url ) {
			$sns_html .= '<li class="p-social-nav__item p-social-nav__item--facebook"><a href="' . esc_attr( $facebook_url ) . '" target="_blank"></a></li>';
		}
		if ( $googleplus_url ) {
			$sns_html .= '<li class="p-social-nav__item p-social-nav__item--googleplus"><a href="' . esc_attr( $googleplus_url ) . '" target="_blank"></a></li>';
		}
		if ( $youtube_url ) {
			$sns_html .= '<li class="p-social-nav__item p-social-nav__item--youtube"><a href="' . esc_attr( $youtube_url ) . '" target="_blank"></a></li>';
		}
		if ( $contact_url ) {
			$sns_html .= '<li class="p-social-nav__item p-social-nav__item--contact"><a href="' . esc_attr( $contact_url ) . '" target="_blank"></a></li>';
		}
		if ( $show_rss ) {
			$sns_html .= '<li class="p-social-nav__item p-social-nav__item--rss"><a href="' . get_bloginfo( 'rss2_url' ) . '" target="_blank"></a></li>';
		}
		if ( $sns_html ) {
			$sns_html = '<ul class="p-social-nav">' . $sns_html . "</ul>\n";
		}

		echo $before_widget;

		// フッター
		if ( isset( $args['id'] ) && false !== strpos( $args['id'], 'footer_widget' ) ) {
			echo '<div class="p-siteinfo">' . "\n";

			if ( ! empty( $image[0] ) ) {
				echo '<div class="p-siteinfo__image p-siteinfo__logo' . ( $instance['image_retina'] ? ' p-siteinfo__logo--retina' : '' ) . '">';

				if ( $instance['image_url'] ) {
					echo '<a href="' . esc_attr( $instance['image_url'] ) . '"';
					if ( $instance['image_target_blank'] ) {
						echo ' target="_blank"';
					}
					echo '>';
				}

				echo '<img alt="' . esc_attr( $title ) . '" src="' . esc_attr( $image[0] ) . '"' . ( $instance['image_retina'] ? ' width="' . floor( $image[1] / 2 ) . '"' : '' ) . '>';

				if ( $instance['image_url'] ) {
					echo '</a>';
				}

				echo "</div>\n";
			} elseif ( $title ) {
				echo '<h2 class="p-siteinfo__title p-logo">' . $title . "</h2>\n";
			}

			if ( $instance['description'] ) {
				echo '<div class="p-siteinfo__desc">';
				echo str_replace( array( "\r\n", "\r", "\n" ), '<br>', esc_html( $instance['description'] ) );
				echo "</div>\n";
			}

			if ( $instance['button'] ) {
				if ( $instance['button_url'] ) {
					echo '<a class="p-siteinfo__button p-button" href="' . esc_attr( $instance['button_url'] ) . '"';
					if ( $instance['button_target_blank'] ) {
						echo ' target="_blank"';
					}
					echo '>' . esc_html( $instance['button'] ) . "</a>\n";
				} else {
					echo '<div class="p-siteinfo__button p-button">' . esc_html( $instance['button'] ) . "</div>\n";
				}
			}

			echo $sns_html;

			echo "</div>\n";

		// サイドバー
		} else {
			if ( $title ) {
				echo $before_title . $title . $after_title;
			}

			echo '<div class="p-siteinfo">' . "\n";

			if ( ! empty( $image[0] ) ) {
				echo '<div class="p-siteinfo__image' . ( $instance['image_retina'] ? ' p-siteinfo__image--retina' : '' ) . '">';

				if ( $instance['image_url'] ) {
					echo '<a class="p-hover-effect--' . esc_attr( $dp_options['hover_type'] ) . '" href="' . esc_attr( $instance['image_url'] ) . '"';
					if ( $instance['image_target_blank'] ) {
						echo ' target="_blank"';
					}
					echo '>';
				}

				echo '<img alt="" src="' . esc_attr( $image[0] ) . '"' . ( $instance['image_retina'] ? ' width="' . floor( $image[1] / 2 ) . '"' : '' ) . '>';

				if ( $instance['image_url'] ) {
					echo '</a>';
				}

				echo "</div>\n";
			}

			if ( $instance['description'] ) {
				echo '<div class="p-siteinfo__desc">';
				echo str_replace( array( "\r\n", "\r", "\n" ), '<br>', esc_html( $instance['description'] ) );
				echo "</div>\n";
			}

			if ( $instance['button'] ) {
				if ( $instance['button_url'] ) {
					echo '<a class="p-siteinfo__button p-button" href="' . esc_attr( $instance['button_url'] ) . '"';
					if ( $instance['button_target_blank'] ) {
						echo ' target="_blank"';
					}
					echo '>' . esc_html( $instance['button'] ) . "</a>\n";
				} else {
					echo '<div class="p-siteinfo__button p-button">' . esc_html( $instance['button'] ) . "</div>\n";
				}
			}

			echo $sns_html;

			echo "</div>\n";
		}

		echo $after_widget;
	}

	function form( $instance ) {
		$instance = array_merge( $this->default_instance, $instance );
?>
		<p><?php _e( 'The display style varies depending on where you display the widget', 'tcd-w' ); ?></p>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'tcd-w' ); ?></label>
			<input class="large-text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'title_font_size' ); ?>"><?php _e( 'Title font size:', 'tcd-w' ); ?></label>
			<input class="small-text" id="<?php echo $this->get_field_id( 'title_font_size' ); ?>" name="<?php echo $this->get_field_name( 'title_font_size' ); ?>" type="number" value="<?php echo esc_attr( $instance['title_font_size'] ); ?>" min="1"> px
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'title_font_size_mobile' ); ?>"><?php _e( 'Title font size for mobile:', 'tcd-w' ); ?></label>
			<input class="small-text" id="<?php echo $this->get_field_id( 'title_font_size_mobile' ); ?>" name="<?php echo $this->get_field_name( 'title_font_size_mobile' ); ?>" type="number" value="<?php echo esc_attr( $instance['title_font_size_mobile'] ); ?>" min="1"> px
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'image' ); ?>"><?php _e( 'Image / logo', 'tcd-w' ); ?>:</label>
			<div class="widget_media_upload cf cf_media_field hide-if-no-js">
				<input type="hidden" id="<?php echo $this->get_field_id( 'image' ); ?>" class="cf_media_id" name="<?php echo $this->get_field_name( 'image' ); ?>" value="<?php echo esc_attr( $instance['image'] ); ?>">
				<div class="preview_field">
					<?php
						if ( $instance['image'] ) {
							echo wp_get_attachment_image( $instance['image'], 'medium' );
						}
					?>
				</div>
				<div class="button_area">
					<input type="button" class="cfmf-select-img button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>">
					<input type="button" class="cfmf-delete-img button <?php if ( ! $instance['image'] ) { echo 'hidden'; } ?>" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>">
				</div>
			</div>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'image_retina' ); ?>">
				<input id="<?php echo $this->get_field_id( 'image_retina' ); ?>" name="<?php echo $this->get_field_name( 'image_retina' ); ?>" type="checkbox" value="1" <?php checked( $instance['image_retina'], '1' ); ?>><?php _e( 'Use retina display logo image in footer widget', 'tcd-w' ); ?>
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'image_url' ); ?>"><?php _e( 'Image link URL', 'tcd-w' ); ?>:</label>
			<input class="large-text" id="<?php echo $this->get_field_id( 'image_url' ); ?>" name="<?php echo $this->get_field_name( 'image_url' ); ?>" type="text" value="<?php echo esc_attr( $instance['image_url'] ); ?>">
			<label for="<?php echo $this->get_field_id( 'image_target_blank' ); ?>">
				<input id="<?php echo $this->get_field_id( 'image_target_blank' ); ?>" name="<?php echo $this->get_field_name( 'image_target_blank' ); ?>" type="checkbox" value="1" <?php checked( $instance['image_target_blank'], '1' ); ?>><?php _e( 'Open link in new window', 'tcd-w' ); ?>
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php _e( 'Description', 'tcd-w' ); ?>:</label>
			<textarea class="large-text" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>" rows="4"><?php echo esc_textarea( $instance['description'] ); ?></textarea>
		</p>
		<div style="margin:1em 0;">
			<label for="<?php echo $this->get_field_id( 'button' ); ?>"><?php _e( 'Button label', 'tcd-w' ); ?>:</label>
			<input class="large-text" id="<?php echo $this->get_field_id( 'button' ); ?>" name="<?php echo $this->get_field_name( 'button' ); ?>" type="text" value="<?php echo esc_attr( $instance['button'] ); ?>">
			<label for="<?php echo $this->get_field_id( 'button_font_color' ); ?>"><?php _e( 'Font color', 'tcd-w' ); ?>:</label>
			<div><input class="c-color-picker-widget" id="<?php echo $this->get_field_id( 'button_font_color' ); ?>" name="<?php echo $this->get_field_name( 'button_font_color' ); ?>" type="text" value="<?php echo esc_attr( $instance['button_font_color'] ); ?>" data-default-color="<?php echo esc_attr( $this->default_instance['button_font_color'] ); ?>"></div>
			<label for="<?php echo $this->get_field_id( 'button_bg_color' ); ?>"><?php _e( 'Background color', 'tcd-w' ); ?>:</label>
			<div><input class="c-color-picker-widget" id="<?php echo $this->get_field_id( 'button_bg_color' ); ?>" name="<?php echo $this->get_field_name( 'button_bg_color' ); ?>" type="text" value="<?php echo esc_attr( $instance['button_bg_color'] ); ?>" data-default-color="<?php echo esc_attr( $this->default_instance['button_bg_color'] ); ?>"></div>
			<label for="<?php echo $this->get_field_id( 'button_font_color_hover' ); ?>"><?php _e( 'Font hover color', 'tcd-w' ); ?>:</label>
			<div><input class="c-color-picker-widget" id="<?php echo $this->get_field_id( 'button_font_color_hover' ); ?>" name="<?php echo $this->get_field_name( 'button_font_color_hover' ); ?>" type="text" value="<?php echo esc_attr( $instance['button_font_color_hover'] ); ?>" data-default-color="<?php echo esc_attr( $this->default_instance['button_font_color_hover'] ); ?>"></div>
			<label for="<?php echo $this->get_field_id( 'button_bg_color_hover' ); ?>"><?php _e( 'Background hover color', 'tcd-w' ); ?>:</label>
			<div><input class="c-color-picker-widget" id="<?php echo $this->get_field_id( 'button_bg_color_hover' ); ?>" name="<?php echo $this->get_field_name( 'button_bg_color_hover' ); ?>" type="text" value="<?php echo esc_attr( $instance['button_bg_color_hover'] ); ?>" data-default-color="<?php echo esc_attr( $this->default_instance['button_bg_color_hover'] ); ?>"></div>
		</div>
		<p>
			<label for="<?php echo $this->get_field_id( 'button_url' ); ?>"><?php _e( 'Button link URL', 'tcd-w' ); ?>:</label>
			<input class="large-text" id="<?php echo $this->get_field_id( 'button_url' ); ?>" name="<?php echo $this->get_field_name( 'button_url' ); ?>" type="text" value="<?php echo esc_attr( $instance['button_url'] ); ?>">
			<label for="<?php echo $this->get_field_id( 'button_target_blank' ); ?>">
				<input id="<?php echo $this->get_field_id( 'button_target_blank' ); ?>" name="<?php echo $this->get_field_name( 'button_target_blank' ); ?>" type="checkbox" value="1" <?php checked( $instance['button_target_blank'], '1' ); ?>><?php _e( 'Open link in new window', 'tcd-w' ); ?>
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'use_sns_theme_options' ); ?>">
				<input class="use_sns_theme_options" id="<?php echo $this->get_field_id( 'use_sns_theme_options' ); ?>" name="<?php echo $this->get_field_name( 'use_sns_theme_options' ); ?>" type="checkbox" value="1" <?php checked( $instance['use_sns_theme_options'], '1' ); ?>><?php _e( 'Use SNS button settings from theme options.', 'tcd-w' ); ?>
			</label>
		</p>
		<div class="widget-sns-fields" style="display:<?php echo $instance['use_sns_theme_options'] ? 'none' : 'block'; ?>;">
			<p>
				<label for="<?php echo $this->get_field_id( 'instagram_url' ); ?>"><?php _e( 'Your Instagram URL:', 'tcd-w' ); ?></label>
				<input class="large-text" id="<?php echo $this->get_field_id( 'instagram_url' ); ?>" name="<?php echo $this->get_field_name( 'instagram_url' ); ?>" type="text" value="<?php echo esc_attr( $instance['instagram_url'] ); ?>">
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'twitter_url' ); ?>"><?php _e( 'Your Twitter URL', 'tcd-w' ); ?>:</label>
				<input class="large-text" id="<?php echo $this->get_field_id( 'twitter_url' ); ?>" name="<?php echo $this->get_field_name( 'twitter_url' ); ?>" type="text" value="<?php echo esc_attr( $instance['twitter_url'] ); ?>">
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'pinterest_url' ); ?>"><?php _e( 'Your Pinterest URL', 'tcd-w' ); ?>:</label>
				<input class="large-text" id="<?php echo $this->get_field_id( 'pinterest_url' ); ?>" name="<?php echo $this->get_field_name( 'pinterest_url' ); ?>" type="text" value="<?php echo esc_attr( $instance['pinterest_url'] ); ?>">
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'facebook_url' ); ?>"><?php _e( 'Your Facebook URL', 'tcd-w' ); ?>:</label>
				<input class="large-text" id="<?php echo $this->get_field_id( 'facebook_url' ); ?>" name="<?php echo $this->get_field_name( 'facebook_url' ); ?>" type="text" value="<?php echo esc_attr( $instance['facebook_url'] ); ?>">
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'youtube_url' ); ?>"><?php _e( 'Your Google+ URL', 'tcd-w' ); ?>:</label>
				<input class="large-text" id="<?php echo $this->get_field_id( 'youtube_url' ); ?>" name="<?php echo $this->get_field_name( 'googleplus_url' ); ?>" type="text" value="<?php echo esc_attr( $instance['googleplus_url'] ); ?>">
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'youtube_url' ); ?>"><?php _e( 'Your Youtube URL', 'tcd-w' ); ?>:</label>
				<input class="large-text" id="<?php echo $this->get_field_id( 'youtube_url' ); ?>" name="<?php echo $this->get_field_name( 'youtube_url' ); ?>" type="text" value="<?php echo esc_attr( $instance['youtube_url'] ); ?>">
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'contact_url' ); ?>"><?php _e( 'Your contact page URL (You can use mailto:)', 'tcd-w' ); ?>:</label>
				<input class="large-text" id="<?php echo $this->get_field_id( 'contact_url' ); ?>" name="<?php echo $this->get_field_name( 'contact_url' ); ?>" type="text" value="<?php echo esc_attr( $instance['contact_url'] ); ?>">
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'show_rss' ); ?>">
					<input id="<?php echo $this->get_field_id( 'show_rss' ); ?>" name="<?php echo $this->get_field_name( 'show_rss' ); ?>" type="checkbox" value="1" <?php checked( $instance['show_rss'], '1' ); ?>><?php _e( 'Display RSS button', 'tcd-w' ); ?>
				</label>
			</p>
		</div>
<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = wp_filter_nohtml_kses( $new_instance['title'] );
		$instance['title_font_size'] = intval( $new_instance['title_font_size'] );
		$instance['title_font_size_mobile'] = intval( $new_instance['title_font_size_mobile'] );
		$instance['image'] = wp_filter_nohtml_kses( $new_instance['image'] );
		$instance['image_retina'] = ! empty( $new_instance['image_retina'] ) ? 1 : 0;
		$instance['image_url'] = wp_filter_nohtml_kses( $new_instance['image_url'] );
		$instance['image_target_blank'] = ! empty( $new_instance['image_target_blank'] ) ? 1 : 0;
		$instance['description'] = wp_filter_nohtml_kses( $new_instance['description'] );
		$instance['button'] = wp_filter_nohtml_kses( $new_instance['button'] );
		$instance['button_font_color'] = wp_filter_nohtml_kses( $new_instance['button_font_color'] );
		$instance['button_bg_color'] = wp_filter_nohtml_kses( $new_instance['button_bg_color'] );
		$instance['button_font_color_hover'] = wp_filter_nohtml_kses( $new_instance['button_font_color_hover'] );
		$instance['button_bg_color_hover'] = wp_filter_nohtml_kses( $new_instance['button_bg_color_hover'] );
		$instance['button_url'] = wp_filter_nohtml_kses( $new_instance['button_url'] );
		$instance['button_target_blank'] = ! empty( $new_instance['button_target_blank'] ) ? 1 : 0;
		$instance['use_sns_theme_options'] = ! empty( $new_instance['use_sns_theme_options'] ) ? 1 : 0;
		$instance['instagram_url'] = wp_filter_nohtml_kses( $new_instance['instagram_url'] );
		$instance['twitter_url'] = wp_filter_nohtml_kses( $new_instance['twitter_url'] );
		$instance['pinterest_url'] = wp_filter_nohtml_kses( $new_instance['pinterest_url'] );
		$instance['facebook_url'] = wp_filter_nohtml_kses( $new_instance['facebook_url'] );
		$instance['googleplus_url'] = wp_filter_nohtml_kses( $new_instance['googleplus_url'] );
		$instance['youtube_url'] = wp_filter_nohtml_kses( $new_instance['youtube_url'] );
		$instance['contact_url'] = wp_filter_nohtml_kses( $new_instance['contact_url'] );
		$instance['show_rss'] = ! empty( $new_instance['show_rss'] ) ? 1 : 0;
		return $instance;
	}
}

function register_Site_Info_Widget() {
	register_widget( 'Site_Info_Widget' );
}
add_action( 'widgets_init', 'register_Site_Info_Widget' );
