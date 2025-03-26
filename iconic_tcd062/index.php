<?php
$dp_options = get_design_plus_option();

if ( is_post_type_archive( $dp_options['news_slug'] ) ) :
	get_template_part( 'archive-news' );
	return;
elseif ( is_welcart_archive() ) :
	get_template_part( 'item-category' );
	return;
endif;

$active_sidebar = get_active_sidebar();
get_header();
?>
<main class="l-main">
<?php
get_template_part( 'template-parts/page-header' );
get_template_part( 'template-parts/breadcrumb' );

if ( $active_sidebar ) :
?>
	<div class="l-inner l-2columns">
		<div class="l-primary">
<?php
else :
?>
	<div class="l-inner">
<?php
endif;

if ( have_posts() ) :
?>
			<div class="p-blog-archive">
<?php
	while ( have_posts() ) :
		the_post();
		$usces_is_item = false;
		if ( function_exists( 'usces_the_item' ) ) :
			usces_the_item();
			$usces_is_item = usces_is_item() && usces_have_skus();
		endif;
?>
				<article class="p-blog-archive__item">
					<a class="p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); ?>" href="<?php the_permalink(); ?>">
						<div class="p-blog-archive__item-thumbnail p-hover-effect__image js-object-fit-cover">
<?php
		echo "\t\t\t\t\t\t\t";
		if ( $usces_is_item && usces_the_itemImageURL( 0, 'return' ) ) :
			usces_the_itemImage( 0, 740, 460 );
		elseif ( has_post_thumbnail() ) :
			the_post_thumbnail( 'size3' );
		else :
			echo '<img src="' . get_template_directory_uri() . '/img/no-image-740x460.gif" alt="">';
		endif;
		echo "\n";
?>
						</div>
						<h2 class="p-blog-archive__item-title p-article__title"><?php echo mb_strimwidth( strip_tags( get_the_title() ), 0, is_mobile() ? 82 : 108, '...' ); ?></h2>
<?php
		if ( $usces_is_item ) :
			echo "\t\t\t\t\t\t";
			echo '<p class="p-blog-archive__item-price p-article__price">' . usces_the_itemPriceCr( 'return' ) . usces_guid_tax( 'return' );
			if ( ! usces_have_zaiko_anyone() ) :
				echo '<span class="p-blog-archive__item-soldout p-article__soldout">'. __( 'Sold Out', 'tcd-w' ) . '</span>';
			endif;
			echo '</p>';

			if ( $dp_options['show_date_item'] || $dp_options['show_category_item'] ) :
				echo "\t\t\t\t\t\t";
				echo '<p class="p-blog-archive__item-meta p-article__meta">';
				if ( $dp_options['show_date_item'] ) :
					echo '<time class="p-article__date" datetime="' . get_the_time( 'Y-m-d' ) . '">' . get_the_time( 'Y.m.d' ) . '</time>';
				endif;
				if ( !$dp_options['show_category_item'] ) :
					$categories = array( get_welcart_category() );
					if ( $categories && ! is_wp_error( $categories ) ) :
						echo '<span class="p-article__category" data-url="' . get_category_link( $categories[0] ) . '">' . esc_html( $categories[0]->name ) . '</span>';
					endif;
				endif;
				echo "</p>\n";
			endif;
		else :
			if ( $dp_options['show_date'] || ( ! is_category() && $dp_options['show_category'] && has_category() ) ) :
				echo "\t\t\t\t\t\t";
				echo '<p class="p-blog-archive__item-meta p-article__meta">';
				if ( $dp_options['show_date'] ) :
					echo '<time class="p-article__date" datetime="' . get_the_time( 'Y-m-d' ) . '">' . get_the_time( 'Y.m.d' ) . '</time>';
				endif;
				if ( ! is_category() && $dp_options['show_category'] && has_category() ) :
					$categories = get_the_category();
					if ( $categories && ! is_wp_error( $categories ) ) :
						echo '<span class="p-article__category" data-url="' . get_category_link( $categories[0] ) . '">' . esc_html( $categories[0]->name ) . '</span>';
					endif;
				endif;
				echo "</p>\n";
			endif;
		endif;
?>
					</a>
				</article>
<?php
	endwhile;
?>
			</div>
<?php
	$paginate_links = paginate_links( array(
		'current' => max( 1, get_query_var( 'paged' ) ),
		'next_text' => '&#xe910;',
		'prev_text' => '&#xe90f;',
		'total' => $wp_query->max_num_pages,
		'type' => 'array',
	) );
	if ( $paginate_links ) :
?>
			<ul class="p-pager">
<?php
		foreach ( $paginate_links as $paginate_link ) :
?>
				<li class="p-pager__item<?php if ( strpos( $paginate_link, 'current' ) ) echo ' p-pager__item--current'; ?>"><?php echo $paginate_link; ?></li>
<?php
		endforeach;
?>
			</ul>
<?php
	endif;
else :
?>
			<p class="no_post"><?php _e( 'There is no registered post.', 'tcd-w' ); ?></p>
<?php
endif;

if ( $active_sidebar ) :
?>
		</div>
<?php
	get_sidebar();
?>
	</div>
<?php
else :
?>
	</div>
<?php
endif;
?>
</main>
<?php get_footer(); ?>
