<?php
/**
 * Styled post list tab (tcd ver)
 */
class Styled_Post_List_Tab_widget extends WP_Widget {

	/**
	 * Tab count.
	 */
	protected $tab_count = 2;

	/**
	 * List types.
	 */
	protected $list_types = array();

	/**
	 * Default instance.
	 */
	protected $default_instance = array();

	function __construct() {
		$this->list_types = array(
			'recent_post' => __( 'Recent post', 'tcd-w' ),
			'recommend_post' => __( 'Recommend post', 'tcd-w' ),
			'recommend_post2' => __( 'Recommend post2', 'tcd-w' ),
			'pickup_post' => __( 'Pickup post', 'tcd-w' ),
			'category' => __( 'Category', 'tcd-w'),
			'recent_item' => __( 'Recent item', 'tcd-w' )
		);

		$this->default_instance = array(
			'title' => '',
			'hide_one_tab' => 0,
			'tab1' => array(
				'show_tab' => 1,
				'title' => __( 'Recent post', 'tcd-w' ),
				'list_type' => 'recent_post',
				'category' => 0,
				'post_num' => 5,
				'post_order' => 'date1',
				'show_date' => 1,
				'show_category' => 1,
				'exclude_item' => 1
			),
			'tab2' => array(
				'show_tab' => 0,
				'title' => __( 'Recommend post', 'tcd-w' ),
				'list_type' => 'recommend_post',
				'category' => 0,
				'post_num' => 5,
				'post_order' => 'date1',
				'show_date' => 1,
				'show_category' => 1,
				'exclude_item' => 1
			)
		);

		parent::__construct(
			'styled_post_list_tab_widget', // ID
			__( 'Styled post list (tcd ver)', 'tcd-w' ), // Name
			array(
				'classname' => 'styled_post_list_tab_widget',
				'description' => __( 'Displays styled post list.', 'tcd-w' )
			)
		);
	}

	function widget( $args, $instance ) {
		global $dp_options, $usces;
		if ( ! $dp_options ) $dp_options = get_design_plus_option();

		extract( $args );

		$radios = '';
		$tabs = 0;
		$hide_one_tab = ! empty ( $instance['hide_one_tab'] ) ? 1 : 0;

		for ( $i = 1; $i <= $this->tab_count; $i++ ) {
			if ( empty( $instance['tab' . $i]['show_tab'] ) ) continue;
			if ( ! $radios ) {
				$checked = ' checked="checked"';
			} else {
				$checked = '';
			}
			$radios .= '<input type="radio" id="' . esc_attr( $widget_id ) . '-tab--' . esc_attr( $i ) . '" name="' . esc_attr( $widget_id ) . '-tab" class="tab-radio tab-radio--' . esc_attr( $i ) . '"' . $checked . '>';
			$tabs++;
		}
		if ( ! $tabs ) return;

		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $before_widget;

		if ( $title ) {
			echo $before_title . $title . $after_title;
		}

		if ( $tabs > 1 || ! $hide_one_tab ) {
			echo $radios . "\n";

			echo '<ul class="styled_post_list_tabs">' . "\n";
			for ( $i = 1; $i <= $this->tab_count; $i++ ) {
				if ( empty( $instance['tab' . $i]['show_tab'] ) ) continue;
				$title = apply_filters('widget_title', $instance['tab' . $i]['title']);
				echo '<li class="tab-label--' . esc_attr( $i ) . '"><label for="' . esc_attr( $widget_id ) . '-tab--' . esc_attr( $i ).'">' . esc_html( $instance['tab' . $i]['title'] ) . '</label></li>' . "\n";
			}
			echo '</ul>' . "\n";
		}

		for ( $i = 1; $i <= $this->tab_count; $i++ ) :
			if ( empty( $instance['tab' . $i]['show_tab'] ) ) continue;

			$list_type = isset( $instance['tab' . $i]['list_type'] ) ? $instance['tab' . $i]['list_type'] : 'recent_post';
			$category = isset( $instance['tab' . $i]['category'] ) ? $instance['tab' . $i]['category'] : 0;
			$post_num = isset( $instance['tab' . $i]['post_num'] ) ? absint( $instance['tab' . $i]['post_num'] ) : 5;
			$post_order = isset( $instance['tab' . $i]['post_order'] ) ? $instance['tab' . $i]['post_order'] : 'date1';
			$show_date = ! empty( $instance['tab' . $i]['show_date'] );
			$show_category = ! empty( $instance['tab' . $i]['show_category'] );
			$exclude_item = ! empty( $instance['tab' . $i]['exclude_item'] );

			if ( 'date2' == $post_order ) {
				$order = 'ASC';
			} else {
				$order = 'DESC';
			}
			if ( $post_order == 'date1' || $post_order == 'date2' ) {
				$post_order = 'date';
			}

			$args = array();

			if ( in_array( $list_type, array( 'recommend_post', 'recommend_post2', 'pickup_post' ) ) ) {
				$args = array(
					'post_type' => 'post',
					'posts_per_page' => $post_num,
					'ignore_sticky_posts' => 1,
					'orderby' => $post_order,
					'order' => $order,
					'meta_key' => $list_type,
					'meta_value' => 'on',
					'post__not_in' => $exclude_item && is_welcart_active() ? $usces->getItemIds( 'front' ) : array()
				);
			} elseif ( 'category' == $list_type ) {
				$args = array(
					'post_type' => 'post',
					'posts_per_page' => $post_num,
					'ignore_sticky_posts' => 1,
					'orderby' => $post_order,
					'order' => $order,
					'cat' => $category
				);
			} elseif ( 'recent_item' == $list_type && defined( 'USCES_ITEM_CAT_PARENT_ID' ) ) {
				$args = array(
					'post_type' => 'post',
					'posts_per_page' => $post_num,
					'ignore_sticky_posts' => 1,
					'orderby' => $post_order,
					'order' => $order,
					'cat' => USCES_ITEM_CAT_PARENT_ID
				);
			} elseif ( 'recent_post' == $list_type ) {
				$args = array(
					'post_type' => 'post',
					'posts_per_page' => $post_num,
					'ignore_sticky_posts' => 1,
					'orderby' => $post_order,
					'order' => $order,
					'post__not_in' => $exclude_item && is_welcart_active() ? $usces->getItemIds( 'front' ) : array()
				);
			}

			if ( $tabs > 1 || ! $hide_one_tab ) {
				echo '<ul class="styled_post_list_tab-content styled_post_list_tab-content--' . esc_attr( $i ) . ' p-widget-list">' . "\n";
			} else {
				echo '<ul class="p-widget-list">' . "\n";
			}

			if ( ! $args) {
				echo '<li class="p-widget-list__item no_post">' . __( 'There is no registered post.', 'tcd-w' ) . '</li>';
				echo "\n</ul>\n";
				continue;
			}

			$widget_query = new WP_Query( $args );

			if ( $widget_query->have_posts() ) :
				global $post;

				while ( $widget_query->have_posts() ) :
					$widget_query->the_post();
					$usces_is_item = false;
					if ( function_exists( 'usces_the_item' ) ) :
						usces_the_item();
						$usces_is_item = usces_is_item() && usces_have_skus();
					endif;
?>
	<li class="p-widget-list__item">
		<a class="p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); ?>" href="<?php the_permalink(); ?>">
			<div class="p-widget-list__item-thumbnail p-hover-effect__image"><?php
					if ( $usces_is_item && usces_the_itemImageURL( 0, 'return' ) ) :
						usces_the_itemImage( 0, 300, 300 );
					elseif ( has_post_thumbnail() ) :
						the_post_thumbnail( 'size1' );
					else :
						echo '<img src="' . get_template_directory_uri() . '/img/no-image-300x300.gif" alt="">';
					endif;
					if ( $usces_is_item && ! usces_have_zaiko_anyone() ) :
						echo '<div class="p-article__thumbnail-soldout"><span class="p-article__soldout">'. __( 'Sold Out', 'tcd-w' ) . '</span></div>';
					endif;
			?></div>
			<div class="p-widget-list__item-info">
				<div class="p-widget-list__item-info__upper">
					<h3 class="p-widget-list__item-title p-article__title"><?php echo mb_strimwidth( strip_tags( get_the_title() ), 0, is_mobile() ? 54 : 60, '...' ); ?></h3>
<?php
					if ( $usces_is_item ) :
						echo "\t\t\t\t\t";
						echo '<p class="p-widget-list__item-price p-price">' . usces_the_itemPriceCr( 'return' ) . usces_guid_tax( 'return' ) . '</p>';
					endif;
?>
				</div>
<?php
					if ( $show_date || $show_category ) :
						echo "\t\t\t\t";
						echo '<p class="p-widget-list__item-meta p-article__meta">';
						if ( $show_date ) :
							echo '<time class="p-widget-list__item-date p-article__date" datetime="' . get_the_time( 'Y-m-d' ) . '">' . get_the_time( 'Y.m.d' ) . '</time>';
						endif;
						if ( $show_category ) :
							if ( $usces_is_item ) :
								$categories = array( get_welcart_category() );
							else :
								$categories = get_the_category();
							endif;
							if ( $categories && ! is_wp_error( $categories ) ) :
								echo '<span class="p-widget-list__item-category p-article__category">' . esc_html( $categories[0]->name ) . '</span>';
							endif;
						endif;
						echo '</p>' . "\n";
					endif;
?>
			</div>
		</a>
	</li>
<?php
				endwhile;
				wp_reset_postdata();
			else :
?>
	<li class="p-widget-list__item no_post"><?php _e( 'There is no registered post.', 'tcd-w' ); ?></li>
<?php
			endif;

			echo "</ul>\n";

		endfor;

		echo $after_widget;
	}

	function form( $instance ) {
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$hide_one_tab = ! empty ( $instance['hide_one_tab'] ) ? 1 : 0;
?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'tcd-w' ); ?></label>
			<input class="large-text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>

		<div class="tcd_toggle_widget_box_wrap">
<?php
		for ( $i = 1; $i <= $this->tab_count; $i++ ) :
			if ( isset( $instance['tab' . $i] ) ) :
				$instance['tab' . $i] = array_merge( $this->default_instance['tab' . $i], $instance['tab' . $i] );
			else :
				$instance['tab' . $i] = $this->default_instance['tab' . $i];
			endif;
?>
			<h3 class="tcd_toggle_widget_headline"><?php
				_e( 'Tab', 'tcd-w' );
				echo $i.' ';
				echo esc_html( $instance['tab' . $i]['title'] ? $instance['tab' . $i]['title'] : '' );
			?></h3>
			<div class="tcd_toggle_widget_box">
				<p style="margin-top:0;">
					<input id="<?php echo $this->get_field_id( 'tab' . $i . '[show_tab]'); ?>" name="<?php echo $this->get_field_name( 'tab' . $i . '[show_tab]' ); ?>" type="checkbox" value="1" <?php checked( 1, $instance['tab' . $i]['show_tab'] ); ?> />
					<label for="<?php echo $this->get_field_id( 'tab' . $i . '[show_tab]'); ?>"><?php _e( 'Display this tab', 'tcd-w' ); ?></label>
				</p>
				<p>
					<label for="<?php echo $this->get_field_id( 'tab' . $i . '[title]' ); ?>"><?php _e( 'Title:', 'tcd-w' ); ?></label>
					<input class="large-text" id="<?php echo $this->get_field_id( 'tab' . $i . '[title]' ); ?>" name="<?php echo $this->get_field_name( 'tab' . $i . '[title]' ); ?>" type="text" value="<?php echo esc_attr( $instance['tab' . $i]['title'] ); ?>">
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'tab' . $i . '[list_type]' ); ?>"><?php _e( 'Post type:', 'tcd-w' ); ?></label>
					<select class="widefat js-styled_post_list_tab-list_type" id="<?php echo $this->get_field_id( 'tab' . $i . '[list_type]' ); ?>" name="<?php echo $this->get_field_name( 'tab' . $i . '[list_type]' ); ?>">
<?php
			foreach ( $this->list_types as $key => $value ) :
				echo '<option value="' . esc_attr( $key ) . '" ' . selected( $instance['tab' . $i]['list_type'], $key, false ) . '>' . esc_html( $value ) . '</option>';
			endforeach;
?>
					</select>
				</p>
				<p class="styled_post_list_tab-list_type-category<?php echo 'category' == $instance['tab' . $i]['list_type'] ? '' : ' hidden'; ?>">
					<label for="<?php echo $this->get_field_id( 'tab' . $i . '[category]' ); ?>"><?php _e( 'Category:', 'tcd-w' ); ?></label>
<?php
			wp_dropdown_categories( array(
				'class' => 'widefat',
				'echo' => 1,
				'hide_empty' => 0,
				'hierarchical' => 1,
				'id' => $this->get_field_id( 'tab' . $i . '[category]' ),
				'name' => $this->get_field_name( 'tab' . $i . '[category]' ),
				'selected' => $instance['tab' . $i]['category'],
				'show_count' => 0,
				'value_field' => 'term_id'
			) );
?>
				</p>
				<p>
					<label for="<?php echo $this->get_field_id( 'tab' . $i . '[post_num]' ); ?>"><?php _e( 'Number of post:', 'tcd-w' ); ?></label>
					<input class="large-text" id="<?php echo $this->get_field_id( 'tab' . $i . '[post_num]' ); ?>" name="<?php echo $this->get_field_name( 'tab' . $i . '[post_num]' ); ?>" type="number" value="<?php echo esc_attr( $instance['tab' . $i]['post_num'] ); ?>" min="1">
				</p>
				<p>
					<label for="<?php echo $this->get_field_id( 'tab' . $i . '[post_order]' ); ?>"><?php _e( 'Post order:', 'tcd-w' ); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id( 'tab' . $i . '[post_order]' ); ?>" name="<?php echo $this->get_field_name( 'tab' . $i . '[post_order]' ); ?>">
						<option value="date1" <?php selected( $instance['tab' . $i]['post_order'], 'date1' ); ?>><?php _e( 'Date (DESC)', 'tcd-w' ); ?></option>
						<option value="date2" <?php selected( $instance['tab' . $i]['post_order'], 'date2' ); ?>><?php _e( 'Date (ASC)', 'tcd-w' ); ?></option>
						<option value="rand" <?php selected( $instance['tab' . $i]['post_order'], 'rand' ); ?>><?php _e( 'Random', 'tcd-w' ); ?></option>
					</select>
				</p>
				<p>
					<input id="<?php echo $this->get_field_id( 'tab' . $i . '[show_date]' ); ?>" name="<?php echo $this->get_field_name( 'tab' . $i . '[show_date]' ); ?>" type="checkbox" value="1" <?php checked( $instance['tab' . $i]['show_date'], 1 ); ?>>
					<label for="<?php echo $this->get_field_id( 'tab' . $i . '[show_date]' ); ?>"><?php _e( 'Display date', 'tcd-w' ); ?></label>
				</p>
				<p>
					<input id="<?php echo $this->get_field_id( 'tab' . $i . '[show_category]' ); ?>" name="<?php echo $this->get_field_name( 'tab' . $i . '[show_category]' ); ?>" type="checkbox" value="1" <?php checked( $instance['tab' . $i]['show_category'], 1 ); ?>>
					<label for="<?php echo $this->get_field_id( 'tab' . $i . '[show_category]' ); ?>"><?php _e( 'Display category', 'tcd-w' ); ?></label>
				</p>
				<p class="styled_post_list_tab-list_type-recent_post styled_post_list_tab-list_type-recommend_post styled_post_list_tab-list_type-recommend_post2 styled_post_list_tab-list_type-category<?php echo $instance['tab' . $i]['list_type'] == 'recent_item' ? ' hidden' : ''; ?>">
					<input id="<?php echo $this->get_field_id( 'tab' . $i . '[exclude_item]' ); ?>" name="<?php echo $this->get_field_name( 'tab' . $i . '[exclude_item]' ); ?>" type="checkbox" value="1" <?php checked( $instance['tab' . $i]['exclude_item'], 1 ); ?>>
					<label for="<?php echo $this->get_field_id( 'tab' . $i . '[exclude_item]' ); ?>"><?php _e( 'Exclude welcart items', 'tcd-w' ); ?></label>
				</p>
			</div>
<?php
		endfor;
?>
		</div>

		<p>
			<input id="<?php echo $this->get_field_id( 'hide_one_tab' ); ?>" name="<?php echo $this->get_field_name( 'hide_one_tab' ); ?>" type="checkbox" value="1" <?php checked( $hide_one_tab, 1 ); ?>>
			<label for="<?php echo $this->get_field_id( 'hide_one_tab' ); ?>"><?php _e( 'If displayed only one tab, hide tab', 'tcd-w' ); ?></label>
		</p>
<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['hide_one_tab'] = ! empty( $new_instance['hide_one_tab'] ) ? 1 : 0;
		for ( $i = 1; $i <= $this->tab_count; $i++ ) {
			$instance['tab' . $i]['show_tab'] = ! empty( $new_instance['tab' . $i]['show_tab'] ) ? 1 : 0;
			$instance['tab' . $i]['title'] = isset( $new_instance['tab' . $i]['title'] ) ? strip_tags( $new_instance['tab' . $i]['title'] ) : '';
			$instance['tab' . $i]['list_type'] = isset( $new_instance['tab' . $i]['list_type'] ) ? strip_tags( $new_instance['tab' . $i]['list_type'] ) : 'recent_post';
			$instance['tab' . $i]['category'] = isset( $new_instance['tab' . $i]['category'] ) ? absint( $new_instance['tab' . $i]['category'] ) : 0;
			$instance['tab' . $i]['post_num'] = isset( $new_instance['tab' . $i]['post_num'] ) ? absint( $new_instance['tab' . $i]['post_num'] ) : 5;
			$instance['tab' . $i]['post_order'] = isset( $new_instance['tab' . $i]['list_type'] ) ? strip_tags( $new_instance['tab' . $i]['post_order'] ) : 'date1';
			$instance['tab' . $i]['show_date'] = ! empty( $new_instance['tab' . $i]['show_date'] ) ? 1 : 0;
			$instance['tab' . $i]['show_category'] = ! empty( $new_instance['tab' . $i]['show_category'] ) ? 1 : 0;
			$instance['tab' . $i]['exclude_item'] = ! empty( $new_instance['tab' . $i]['exclude_item'] ) ? 1 : 0;
		}
		return $instance;
	}
}

function register_styled_post_list_tab_widget() {
	register_widget( 'Styled_Post_List_Tab_widget' );
}
add_action( 'widgets_init', 'register_styled_post_list_tab_widget' );
