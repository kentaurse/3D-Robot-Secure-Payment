<?php
/**
 * Google custom search (tcd ver)
 */
class google_search extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'google_search_widget', // ID
			__( 'Google Custom Search (tcd ver)', 'tcd-w' ), // Name
			array(
				'classname' => 'google_search_widget',
				'description' => __( 'Displays Google Custom Search form.', 'tcd-w' )
			)
		);
	}

	public function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters( 'widget_title', $instance['title'] );
		$google_search_id = $instance['google_search_id'];

		echo $before_widget;

		if ( $title ) {
			echo $before_title . $title . $after_title;
		}
?>
		<div class="p-widget-search">
			<form action="https://www.google.com/cse" method="get">
				<div>
					<input class="p-widget-search__input" type="text" value="" name="q">
					<input class="p-widget-search__submit" type="submit" name="sa" value="&#xe915;">
					<input type="hidden" name="cx" value="<?php echo esc_attr( $google_search_id ); ?>">
					<input type="hidden" name="ie" value="UTF-8">
				</div>
			</form>
		</div>
<?php
		echo $after_widget;
	}

	function form( $instance ) {
		$title = isset( $instance['title'] ) ? $instance['title'] : __( 'Search', 'tcd-w' );
		$google_search_id = isset( $instance['google_search_id'] ) ? $instance['google_search_id'] : '';
?>
		<p><?php _e( 'If you want to use google custom search for your WordPress, enter your google custom search ID.<br><a href="https://www.google.com/cse/" target="_blank">Read more about Google custom search page.</a>', 'tcd-w' ); ?></p>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'tcd-w' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'google_search' ); ?>"><?php _e( 'Google custom search ID', 'tcd-w' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'google_search_id' ); ?>" name="<?php echo $this->get_field_name( 'google_search_id' ); ?>" type="text" value="<?php echo esc_attr( $google_search_id ); ?>">
		</p>
<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['google_search_id'] = strip_tags( $new_instance['google_search_id'] );
		return $instance;
	}
}

function register_google_search_widget() {
	register_widget( 'google_search' );
}
add_action( 'widgets_init', 'register_google_search_widget' );
