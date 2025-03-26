<?php
/**
 * Item category (tcd ver)
 */
class Tcdw_Item_Category extends WP_Widget {

	public $exclude_cat_num = '';
	public $current_categories = array();

	function __construct() {
		parent::__construct(
			'tcdw_item_category', // ID
			__( 'Item Category (tcd ver)', 'tcd-w' ), // Name
			array(
				'classname' => 'tcdw_item_category',
				'description' => __( 'Displays designed welcart item category.', 'tcd-w' )
			)
		);
	}

	function widget( $args, $instance ) {
		if ( ! is_welcart_active() || ! defined( 'USCES_ITEM_CAT_PARENT_ID' ) ) {
			return;
		}

		extract( $args );

		$title = apply_filters( 'widget_title', $instance['title'] ); // the widget title
		$category = isset( $instance['category'] ) ? intval( $instance['category'] ) : USCES_ITEM_CAT_PARENT_ID;
		$child_categories_mode = ! empty( $instance['child_categories_mode'] ) ? 1 : 0;
		$exclude_cat_num = $instance['exclude_cat_num']; // category id to exclude

		// カレントカテゴリーID配列
		if ( is_welcart_archive() ) {
			$queried_object = get_queried_object();
			if ( ! empty( $queried_object->term_id ) ) {
				$this->current_categories[] = $queried_object->term_id;
			}
		} elseif ( is_welcart_single() ) {
			$_cat = get_welcart_category();
			if ( $_cat ) {
				$this->current_categories[] = $_cat->term_id;
			}
			/*
			foreach( get_the_category() as $_cat ) {
				$this->current_categories[] = $_cat->term_id;
			}
			*/
		}

		$wp_list_categories_args = array(
			'title_li' => '',
			'child_of' => $category,
			'exclude' => $exclude_cat_num,
			'show_count' => 0,
			'hierarchical' => 1,
			'echo' => 0,
			'use_desc_for_title' => 0
		);

		// 子カテゴリーモード
		$is_child_categories_mode = 0;
		if ( $child_categories_mode && is_welcart_archive() ) {
			$queried_object = get_queried_object();
			if ( ! empty( $queried_object->term_id ) ) {
				// 設定親カテゴリーもしくは子カテゴリーのみ
				if ( $queried_object->term_id == $category ) {
					$is_child_categories_mode = 1;
				} else {
					$ancestors = get_ancestors( $queried_object->term_id, 'category', 'taxonomy' );
					if ( $ancestors && in_array( $category, $ancestors ) ) {
						$is_child_categories_mode = 2;
					}
				}

				if ( $is_child_categories_mode ) {
					$children = get_categories(array(
						'exclude' => $exclude_cat_num,
						'hide_empty' => 0,
						'hierarchical' => 1,
						'parent' => $queried_object->term_id
					) );
					if ( $children ) {
						$wp_list_categories_args = array(
							'title_li' => '',
							'child_of' => $queried_object->term_id,
							'exclude' => $exclude_cat_num,
							'show_count' => 0,
							'hierarchical' => 1,
							'echo' => 0,
							'show_option_none' => '',
							'use_desc_for_title' => 0
						);
					} elseif ( ! empty( $_GET['tcdw_item_category'] ) ) {
						$wp_list_categories_args = array(
							'title_li' => '',
							'include' => $queried_object->term_id,
							'show_count' => 0,
							'hierarchical' => 1,
							'echo' => 0,
							'show_option_none' => '',
							'use_desc_for_title' => 0
						);
					}
				}
			}
		}

		echo $before_widget;

		if ( $title ) {
			echo $before_title . $title . $after_title;
		}

		// カレントカテゴリー用のフィルター追加
		add_filter( 'category_css_class', array( &$this, 'category_css_class' ), 10, 4 );

		// 子カテゴリー用のフィルター追加
		if ( $child_categories_mode ) {
			$this->exclude_cat_num = $exclude_cat_num;
			add_filter( 'term_link', array( &$this, 'term_link' ), 10, 3 );
		}

		$categories = wp_list_categories( $wp_list_categories_args );

		// カレントカテゴリー用のフィルター削除
		remove_filter( 'category_css_class', array( &$this, 'category_css_class' ), 10 );

		// 子カテゴリー用のフィルター削除
		if ( $child_categories_mode ) {
			remove_filter( 'term_link', array( &$this, 'term_link' ), 10 );
		}

		echo '<ul class="p-widget-categories">' . "\n";
		echo $categories;
		echo '</ul>' . "\n";

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['category'] = intval( $new_instance['category'] );
		$instance['child_categories_mode'] = ! empty( $new_instance['child_categories_mode'] ) ? 1 : 0;
		$instance['exclude_cat_num'] = strip_tags( $new_instance['exclude_cat_num'] );
		return $instance;
	}

	function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$category = 0;
		if ( isset( $instance['category'] ) ) {
			$category = intval( $instance['category'] );
		} else {
			$cat = get_category_by_slug('itemgenre');
			if ( $cat ) {
				$category = $cat->term_id;
			} elseif ( defined( 'USCES_ITEM_CAT_PARENT_ID' ) ) {
				$category = USCES_ITEM_CAT_PARENT_ID;
			} else {
				$category = 0;
			}
		}
		$child_categories_mode = ! empty( $instance['child_categories_mode'] ) ? 1 : 0;
		$exclude_cat_num = ! empty( $instance['exclude_cat_num'] ) ? $instance['exclude_cat_num'] : '';
?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'tcd-w' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Parent category:', 'tcd-w' ); ?></label>
<?php
		$exclude_tree_cats = array();
		if ( defined( 'USCES_ITEM_CAT_PARENT_ID' ) ) {
			$cats = get_categories(array(
				'exclude' => USCES_ITEM_CAT_PARENT_ID,
				'exclude_tree' => USCES_ITEM_CAT_PARENT_ID,
				'hide_empty' => 0,
				'hierarchical' => 1,
				'parent' => 0
			) );
			if ( $cats ) {
				foreach( $cats as $cat ) {
					$exclude_tree_cats[] = $cat->term_id;
				}
			}
		}
		wp_dropdown_categories( array(
			'class' => 'widefat',
			'echo' => 1,
			'exclude_tree' => $exclude_tree_cats,
			'hide_empty' => 0,
			'hierarchical' => 1,
			'id' => $this->get_field_id( 'category' ),
			'name' => $this->get_field_name( 'category' ),
			'selected' => $category,
			'show_count' => 0,
			'value_field' => 'term_id'
		) );
?>
		<p>
			<input id="<?php echo $this->get_field_id( 'child_categories_mode' ); ?>" name="<?php echo $this->get_field_name( 'child_categories_mode' ); ?>" type="checkbox" value="1" <?php checked( $child_categories_mode, 1 ); ?>>
			<label for="<?php echo $this->get_field_id( 'child_categories_mode' ); ?>"><?php _e( 'When displaying the item category archive, display the child categories of the displaying item category.', 'tcd-w' ); ?></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'exclude_cat_num' ); ?>"><?php _e( 'Categories To Exclude:', 'tcd-w' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'exclude_cat_num' ); ?>" name="<?php echo $this->get_field_name( 'exclude_cat_num' ); ?>" type="text" value="<?php echo esc_attr( $exclude_cat_num ); ?>">
			<span><?php _e( 'Enter a comma-seperated list of category ID numbers, example 2,4,10<br />(Don\'t enter comma for last number).', 'tcd-w' ); ?></span>
		</p>
<?php
	}

	// カレントカテゴリー用cssフィルター追加
	function category_css_class( $css_classes, $category, $depth, $args ) {
		if ( $this->current_categories && in_array( $category->term_id, $this->current_categories ) ) {
			$css_classes[] = 'current-cat-item';
		}
		return $css_classes;
	}

	// ウィジェットからのリンクを判別するためのフィルター
	function term_link( $termlink, $term, $taxonomy ) {
		return add_query_arg( 'tcdw_item_category', '1', $termlink );
	}
}

function register_tcdw_item_category() {
	if ( is_welcart_active() ) {
		register_widget( 'Tcdw_Item_Category' );
	}
}
add_action( 'widgets_init', 'register_tcdw_item_category' );
