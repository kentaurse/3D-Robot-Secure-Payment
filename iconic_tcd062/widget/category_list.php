<?php
/**
 * Category list (tcd ver)
 */
class Tcdw_Category_List_Widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			'tcdw_category_list_widget', // ID
			__( 'Category list (tcd ver)', 'tcd-w' ), // Name
			array(
				'classname' => 'tcdw_category_list_widget',
				'description' => __( 'Displays designed category list.', 'tcd-w' )
			)
		);
	}

	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters( 'widget_title', $instance['title'] ); // the widget title
		$exclude_cat_num = $instance['exclude_cat_num']; // category id to exclude
		$exclude_welcart_cat = ! empty( $instance['exclude_welcart_cat'] ) ? 1 : 0;

		echo $before_widget;

		if ( $title ) {
			echo $before_title . $title . $after_title;
		}

		if ( $exclude_welcart_cat && defined( 'USCES_ITEM_CAT_PARENT_ID' ) ) {
			$exclude_cat_num = trim( $exclude_cat_num . ',' . USCES_ITEM_CAT_PARENT_ID, ',' );
		}

		$args = array(
			'title_li' => '',
			'exclude' => $exclude_cat_num,
			'show_count' => 0,
			'hierarchical' => 1,
			'echo' => 0,
			'use_desc_for_title' => 0
		);
		$categories = wp_list_categories( $args );
		if ( $categories ) {
			echo '<ul class="p-widget-categories">' . "\n";
			echo $categories;
			echo '</ul>' . "\n";
		}

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['exclude_cat_num'] = strip_tags( $new_instance['exclude_cat_num'] );
		$instance['exclude_welcart_cat'] = ! empty( $new_instance['exclude_welcart_cat'] ) ? 1 : 0;
		return $instance;
	}

	function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$exclude_cat_num = ! empty( $instance['exclude_cat_num'] ) ? $instance['exclude_cat_num'] : '';
		$exclude_welcart_cat = ! empty( $instance['exclude_welcart_cat'] ) ? 1 : 0;
?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'tcd-w' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'exclude_cat_num' ); ?>"><?php _e( 'Categories To Exclude:', 'tcd-w' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'exclude_cat_num' ); ?>" name="<?php echo $this->get_field_name( 'exclude_cat_num' ); ?>" type="text" value="<?php echo esc_attr( $exclude_cat_num ); ?>">
			<span><?php _e( 'Enter a comma-seperated list of category ID numbers, example 2,4,10<br />(Don\'t enter comma for last number).', 'tcd-w' ); ?></span>
		</p>
		<p>
			<input id="<?php echo $this->get_field_id( 'exclude_welcart_cat' ); ?>" name="<?php echo $this->get_field_name( 'exclude_welcart_cat' ); ?>" type="checkbox" value="1" <?php checked( $exclude_welcart_cat, 1 ); ?>>
			<label for="<?php echo $this->get_field_id( 'exclude_welcart_cat' ); ?>"><?php _e( 'Exclude welcart categories', 'tcd-w' ); ?></label>
		</p>
<?php
	}
}

function register_tcdw_category_list_widget() {
	register_widget( 'Tcdw_Category_List_Widget' );
}
add_action( 'widgets_init', 'register_tcdw_category_list_widget' );
