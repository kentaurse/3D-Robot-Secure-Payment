<?php
global $dp_options, $tcd_megamenu;
if ( ! $dp_options ) $dp_options = get_design_plus_option();

if ( $tcd_megamenu ) :
	foreach ( $tcd_megamenu as $menu_id => $value ) :
		if ( empty( $value['categories'] ) ) continue;
?>
	<div id="p-megamenu--<?php echo esc_attr( $menu_id ); ?>" class="p-megamenu p-megamenu--<?php echo esc_attr( $value['type'] ); ?><?php
			if ( ! empty( $value['item']->object_id ) && 'taxonomy' === $value['item']->type && 'category' === $value['item']->object ) :
				echo ' p-megamenu-parent-category p-megamenu-term-id-' . esc_attr( $value['item']->object_id );
			endif;
		?>">
		<ul class="l-inner p-megamenu__bg">
<?php
		$cnt = 0;
		foreach ( $value['categories'] as $menu ) :
			$category = get_term_by( 'id', $menu->object_id, 'category' );
			if ( empty( $category->term_id ) ) continue;

			if ( 'type2' === $value['type'] ) :
				$term_meta = get_option( 'taxonomy_' . $category->term_id );
				$image_src = null;
				$li_class = array();
				if ( ! empty( $term_meta['image_megamenu'] ) ) :
					$image_src = wp_get_attachment_image_src( $term_meta['image_megamenu'], 'size3' );
				endif;
				if ( ! $image_src && ! empty( $term_meta['image'] ) ) :
					$image_src = wp_get_attachment_image_src( $term_meta['image'], 'size3' );
				endif;
				if ( ! empty( $image_src[0] ) ) :
					$image_src = $image_src[0];
				else :
					$image_src = get_template_directory_uri() . '/img/no-image-740x460.gif';
				endif;
				if ( is_category( $category->slug ) ) :
					$li_class[] = 'p-megamenu__current';
				endif;
				if (count($value['categories']) - $cnt <= count($value['categories']) % 5 ) :
					$li_class[] = 'p-megamenu__last-row';
				endif;
				if ( $li_class ) :
					$li_class = ' class="' . implode( ' ', $li_class ) . '"';
				else :
					$li_class = '';
				endif;
?>
			<li<?php echo $li_class; ?>><a class="p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); ?>" href="<?php echo get_category_link( $category->term_id ); ?>"><div class="p-megamenu__image p-hover-effect__image js-object-fit-cover"><img src="<?php echo esc_attr( $image_src ); ?>" alt=""></div><?php echo esc_html( $menu->title ); ?></a></li>
<?php
			elseif ( 'type3' === $value['type'] ) :
				$megamenu_posts = get_posts( array(
					'cat' => $category->term_id,
					'post_type' => 'post',
					'post_status' => 'publish',
					'posts_per_page' => 4
				) );
?>
			<li<?php if ( ! $cnt ) echo ' class="is-active"'; ?>>
				<a href="<?php echo get_category_link( $category->term_id ); ?>"><?php echo esc_html( $menu->title ); ?></a>
<?php
				if ( $megamenu_posts ) :
?>
				<ul class="sub-menu p-megamenu__bg">
<?php
					foreach ( $megamenu_posts as $megamenu_post ) :
						if ( has_post_thumbnail( $megamenu_post->ID ) ) :
							$image_src = wp_get_attachment_image_src( get_post_thumbnail_id( $megamenu_post->ID ), 'size3' );
						else :
							$image_src = null;
						endif;
						if ( ! empty( $image_src[0] ) ) :
							$image_src = $image_src[0];
						else :
							$image_src = get_template_directory_uri() . '/img/no-image-740x460.gif';
						endif;
?>
					<li><a class="p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); ?>" href="<?php echo get_permalink( $megamenu_post ); ?>"><div class="p-megamenu__image p-hover-effect__image js-object-fit-cover"><img src="<?php echo esc_attr( $image_src ); ?>" alt=""></div><?php echo mb_strimwidth( strip_tags( get_the_title( $megamenu_post ) ), 0, 56, '...' ); ?></a></li>
<?php
					endforeach;
?>
				</ul>
<?php
				endif;
?>
			</li>
<?php
			elseif ( 'type4' === $value['type'] ) :
?>
			<li<?php if ( is_category( $category->slug ) ) echo ' class="p-megamenu__current"'; ?>><a class="p-megamenu__hover" href="<?php echo get_category_link( $category->term_id ); ?>"><span><?php echo esc_html( $menu->title ); ?></span></a></li>
<?php
			endif;
			$cnt++;
		endforeach;
?>
		</ul>
	</div>
<?php
	endforeach;
endif;

