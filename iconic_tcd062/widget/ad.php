<?php
/**
 * AdSense (tcd ver)
 */
class tcdw_ad_widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			'tcdw_ad_widget', // ID
			__( 'AdSense (tcd ver)', 'tcd-w' ), // Name
			array(
				'classname' => 'tcdw_ad_widget',
				'description' => __( 'Show AdSense at random in front page.', 'tcd-w' )
			)
		);
	}

	function widget( $args, $instance ) {
		extract( $args );

		echo $before_widget;

		for ( $i = 1; $i <= 3; $i++ ) {
			${ 'banner_code' . $i } = $instance['banner_code' . $i];
			${ 'banner_image' . $i } = wp_get_attachment_image_src( $instance['banner_image' . $i], 'full' );
			${ 'banner_url' . $i } = $instance['banner_url' . $i];
		}

		if ( $banner_code3 || $banner_image3 ) {
			$random = rand( 0, 2 );
		} elseif ( $banner_code2 || $banner_image2 ) {
			$random = rand( 0, 1 );
		} elseif ( $banner_code1 || $banner_image1 ) {
			$random = rand( 0, 0 );
		} else {
			$random = '';
		}

		if ( 0 === $random ) {
			if ( $banner_code1 ) {
				echo $banner_code1;
			} else {
				echo '<a href="' . esc_url( $banner_url1 ) . '" target="_blank"><img src="' . esc_attr( $banner_image1[0] ) . '" alt=""></a>' . "\n";
			}
		} elseif ( 1 === $random ) {
			if ( $banner_code2 ) {
				echo $banner_code2;
			} else {
				echo '<a href="' . esc_url( $banner_url2 ) . '" target="_blank"><img src="' . esc_attr( $banner_image2[0] ) . '" alt=""></a>' . "\n";
			}
		} elseif ( 2 === $random ) {
			if ( $banner_code3 ) {
				echo $banner_code3;
			} else {
				echo '<a href="' . esc_url( $banner_url3 ) . '" target="_blank"><img src="' . esc_attr( $banner_image3[0] ) . '" alt=""></a>' . "\n";
			}
		}

		echo $after_widget;
	}

	function form( $instance ) {
		for ( $i = 1; $i <= 3; $i++ ) {
			${ 'banner_code' . $i } = isset( $instance['banner_code' . $i] ) ? $instance['banner_code' . $i] : '';
			${ 'banner_image' . $i } = isset( $instance['banner_image' . $i] ) ? $instance['banner_image' . $i] : '';
			${ 'banner_url' . $i } = isset( $instance['banner_url' . $i] ) ? $instance['banner_url' . $i] : '';
		}
?>
		<p><?php _e( 'One out of three AdSense will be displayed at random in front page.', 'tcd-w' ); ?></p>
		<div class="tcd_toggle_widget_box_wrap">
<?php for ( $i = 1; $i <= 3; $i++ ) : ?>
			<h3 class="tcd_toggle_widget_headline"><?php _e( 'AdSense','tcd-w' ); ?><?php echo $i; ?></h3>
			<div class="tcd_toggle_widget_box">
				<div class="tcd_toggle_widget_box_inner">
					<h4 class="tcd_toggle_widget_sub_headline"><?php _e( 'Register AdSense code','tcd-w' ); ?></h4>
					<p><?php _e( 'If you are using Google AdSense or similar kind of AdSense, enter all code below.', 'tcd-w' ); ?></p>
					<p><textarea id="<?php echo $this->get_field_id( 'banner_code' . $i ); ?>" class="widefat" rows="10" name="<?php echo $this->get_field_name( 'banner_code' . $i ); ?>"><?php echo ${ 'banner_code' . $i }; ?></textarea></p>
				</div>
				<p class="widget_notice"><?php _e( 'If you want to register banner image and affiliate code individually, leave the field above blank and use the field below.', 'tcd-w' ); ?></p>
				<div class="tcd_toggle_widget_box_inner">
					<h4 class="tcd_toggle_widget_sub_headline"><?php _e( 'Register AdSense image', 'tcd-w' ); ?></h4>
					<div class="widget_media_upload cf cf_media_field hide-if-no-js <?php echo $this->get_field_id( 'banner_image' . $i ); ?>">
						<input type="hidden" id="<?php echo $this->get_field_id( 'banner_image' . $i ); ?>" class="cf_media_id" name="<?php echo $this->get_field_name( 'banner_image' . $i ); ?>" value="<?php echo esc_attr( ${ 'banner_image' . $i } ); ?>">
						<div class="preview_field">
							<?php
								if ( ${ 'banner_image' . $i } ) {
									echo wp_get_attachment_image( ${ 'banner_image' . $i }, 'medium' );
								}
							?>
						</div>
						<div class="button_area">
							<input type="button" class="cfmf-select-img button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>">
							<input type="button" class="cfmf-delete-img button <?php if ( ! ${ 'banner_image' . $i } ) { echo 'hidden'; } ?>" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>">
						</div>
					</div>
				</div>
				<div class="tcd_toggle_widget_box_inner">
					<h4 class="tcd_toggle_widget_sub_headline"><?php _e( 'Register affiliate code or link url for registered image', 'tcd-w' ); ?></h4>
					<input type="text" id="<?php echo $this->get_field_id( 'banner_url' . $i ); ?>" class="img widefat" name="<?php echo $this->get_field_name( 'banner_url' . $i ); ?>" value="<?php echo ${ 'banner_url' . $i }; ?>">
				</div>
			</div>
<?php endfor; ?>
		</div>
<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = array();
		for ( $i = 1; $i <= 3; $i++ ) {
			$instance['banner_code' . $i] = $new_instance['banner_code' . $i];
			$instance['banner_image' . $i] = strip_tags( $new_instance['banner_image' . $i] );
			$instance['banner_url' . $i] = strip_tags( $new_instance['banner_url' . $i] );
		}
		return $instance;
	}
}

function register_tcdw_ad_widget() {
	register_widget( 'tcdw_ad_widget' );
}
add_action( 'widgets_init', 'register_tcdw_ad_widget' );
