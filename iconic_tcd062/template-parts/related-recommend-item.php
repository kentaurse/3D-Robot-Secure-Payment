<?php
global $dp_options, $post;
if ( ! $dp_options ) $dp_options = get_design_plus_option();

if ( is_welcart_single() ) :
	$post_id = $post->ID;

	if ( $dp_options['show_related_item'] ) :
		$assistance_ids = usces_get_assistance_ids( $post_id );
		if ( $assistance_ids ) :
			$the_query = new WP_Query( array(
				'ignore_sticky_posts'=> 1,
				'post__in' => $assistance_ids,
				'posts_per_page' => $dp_options['related_item_num'] > 0 ? $dp_options['related_item_num'] : 6
			) );
			if ( $the_query->have_posts() ) :
?>
			<section class="p-entry-item__related">
<?php
				if ( $dp_options['related_item_headline'] ) :
?>
				<h3 class="p-headline"><?php echo esc_html( $dp_options['related_item_headline'] ); ?></h3>
<?php
				endif;
?>
				<div class="p-item-archive">
<?php
				while ( $the_query->have_posts() ) :
					$the_query->the_post();
					if ( ! is_welcart_single( $post->ID ) ) continue;
					usces_remove_filter();
					usces_the_item();
					usces_have_skus();
?>
					<article class="p-item-archive__item">
						<a class="p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); ?>" href="<?php the_permalink(); ?>">
							<div class="p-item-archive__item-thumbnail p-hover-effect__image">
								<div class="p-item-archive__item-thumbnail__inner js-object-fit-cover">
<?php
					echo "\t\t\t\t\t\t\t\t\t";
					if ( usces_the_itemImageURL( 0, 'return' ) ) :
						usces_the_itemImage( 0, 500, 500 );
					elseif ( has_post_thumbnail() ) :
						the_post_thumbnail( 'size2' );
					else :
						echo '<img src="' . get_template_directory_uri() . '/img/no-image-500x500.gif" alt="">';
					endif;
					if ( ! usces_have_zaiko_anyone() ) :
						echo '<div class="p-article__thumbnail-soldout u-visible-sm"><span class="p-article__soldout">'. __( 'Sold Out', 'tcd-w' ) . '</span></div>';
					endif;
					echo "\n";
?>
								</div>
							</div>
							<div class="p-item-archive__item-info">
								<h3 class="p-item-archive__item-title p-article-item__title p-article__title"><?php echo mb_strimwidth( strip_tags( get_the_title() ), 0, is_mobile() ? 82 : 108, '...' ); ?></h3>
<?php
					echo "\t\t\t\t\t\t\t\t";
					echo '<p class="p-item-archive__item-price p-article__price">' . usces_the_itemPriceCr( 'return' ) . usces_guid_tax( 'return' );
					if ( ! usces_have_zaiko_anyone() ) :
						echo '<span class="p-item-archive__item-soldout p-article__soldout u-hidden-sm">'. __( 'Sold Out', 'tcd-w' ) . '</span>';
					endif;
					echo '</p>';
?>
							</div>
						</a>
					</article>
<?php
				endwhile;
?>
				</div>
			</section>
<?php 
			endif;
		endif;
	endif;

	if ( $dp_options['show_recommend_item'] ) :
		$recommend_item_ids = get_recommend_item_ids( $post_id, $dp_options['recommend_item_num'], 'year' );
		if ( $recommend_item_ids ) :
?>
			<section class="p-entry-item__recommend">
<?php
			if ( $dp_options['recommend_item_headline'] ) :
?>
				<h3 class="p-headline"><?php echo esc_html( $dp_options['recommend_item_headline'] ); ?></h3>
<?php
			endif;
?>
				<div class="p-item-archive">
<?php
			foreach( $recommend_item_ids as $recommend_item_id ):
				$post = get_post( $recommend_item_id );
				if ( ! $post || ! is_welcart_single( $recommend_item_id ) ) continue;
				setup_postdata( $post );
				usces_remove_filter();
				usces_the_item();
				usces_have_skus();
?>
					<article class="p-item-archive__item">
						<a class="p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); ?>" href="<?php the_permalink(); ?>">
							<div class="p-item-archive__item-thumbnail p-hover-effect__image">
								<div class="p-item-archive__item-thumbnail__inner js-object-fit-cover">
<?php
				echo "\t\t\t\t\t\t\t\t\t";
				if ( usces_the_itemImageURL( 0, 'return' ) ) :
					usces_the_itemImage( 0, 500, 500 );
				elseif ( has_post_thumbnail() ) :
					the_post_thumbnail( 'size2' );
				else :
					echo '<img src="' . get_template_directory_uri() . '/img/no-image-500x500.gif" alt="">';
				endif;
				if ( ! usces_have_zaiko_anyone() ) :
					echo '<div class="p-article__thumbnail-soldout u-visible-sm"><span class="p-article__soldout">'. __( 'Sold Out', 'tcd-w' ) . '</span></div>';
				endif;
				echo "\n";
?>
								</div>
							</div>
							<div class="p-item-archive__item-info">
								<h3 class="p-item-archive__item-title p-article-item__title p-article__title"><?php echo mb_strimwidth( strip_tags( get_the_title() ), 0, is_mobile() ? 82 : 108, '...' ); ?></h3>
<?php
				echo "\t\t\t\t\t\t\t\t";
				echo '<p class="p-item-archive__item-price p-article__price">' . usces_the_itemPriceCr( 'return' ) . usces_guid_tax( 'return' );
				if ( ! usces_have_zaiko_anyone() ) :
					echo '<span class="p-item-archive__item-soldout p-article__soldout u-hidden-sm">'. __( 'Sold Out', 'tcd-w' ) . '</span>';
				endif;
				echo '</p>';
?>
							</div>
						</a>
					</article>
<?php
			endforeach;
?>
				</div>
			</section>
<?php 
		endif;
	endif;

	wp_reset_postdata();
endif;
