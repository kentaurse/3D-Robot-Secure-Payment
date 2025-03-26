<?php
global $dp_options, $usces;

if ( ! $dp_options ) $dp_options = get_design_plus_option();
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
	<div class="l-inner l-primary">
<?php
endif;

$uscpaged = isset( $_REQUEST['paged'] ) ? intval( $_REQUEST['paged'] ) : 1;
if ( $uscpaged < 1 ) $uscpaged = 1;
?>
		<h2 class="p-wc-headline"><?php _e( 'Categories: AND Search', 'tcd-w' ); ?></h2>
		<form id="p-wc-search__form" class="p-wc-search__form" action="<?php echo USCES_CART_URL . $usces->delim; ?>usces_page=search_item" method="post">
<?php
			echo usces_categories_checkbox( 'return' );
?>
			<input name="usces_search_button" class="p-wc-search__button p-button" type="submit" value="<?php _e( 'Search', 'tcd-w' ); ?>">
			<input name="paged" id="usces_paged" type="hidden" value="1">
			<input name="usces_search" type="hidden">
<?php
			do_action( 'usces_action_search_item_inform' );
?>
		</form>
<?php
if ( isset( $_REQUEST['usces_search'] ) ) :
	$search_query = array(
		'category__and' => usces_search_categories(),
		'ignore_sticky_posts' => true,
		'paged' => $uscpaged
	);
	$search_query = apply_filters( 'usces_filter_search_query', $search_query );
	$the_query = new WP_Query( $search_query );

	$search_result = apply_filters( 'usces_filter_search_result', NULL, $the_query );
	if ( $search_result ) :
		echo $search_result;
	elseif ( $the_query->have_posts() ) :
?>
			<div class="p-item-archive">
<?php

		while ( $the_query->have_posts() ) :
			$the_query->the_post();
			usces_the_item();
			usces_have_skus();
?>
				<article class="p-item-archive__item">
					<a class="p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); ?>" href="<?php the_permalink(); ?>">
						<div class="p-item-archive__item-thumbnail p-hover-effect__image">
							<div class="p-item-archive__item-thumbnail__inner js-object-fit-cover">
<?php
			echo "\t\t\t\t\t\t\t\t";
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
							<h2 class="p-item-archive__item-title p-article-item__title p-article__title"><?php echo mb_strimwidth( strip_tags( get_the_title() ), 0, is_mobile() ? 82 : 108, '...' ); ?></h2>
<?php
			echo "\t\t\t\t\t\t\t";
			echo '<p class="p-item-archive__item-price p-article__price">' . usces_the_itemPriceCr( 'return' ) . usces_guid_tax( 'return' );
			if ( ! usces_have_zaiko_anyone() ) :
				echo '<span class="p-item-archive__item-soldout p-article__soldout u-hidden-sm">'. __( 'Sold Out', 'tcd-w' ) . '</span>';
			endif;
			echo '</p>';

			if ( $dp_options['show_date_item'] || $dp_options['show_category_item'] ) :
				echo "\t\t\t\t\t\t\t";
				echo '<p class="p-item-archive__item-meta p-article__meta">';
				if ( $dp_options['show_date_item'] ) :
					echo '<time class="p-article__date" datetime="' . get_the_time( 'Y-m-d' ) . '">' . get_the_time( 'Y.m.d' ) . '</time>';
				endif;
				if ( $dp_options['show_category_item'] ) :
					$categories = array( get_welcart_category() );
					if ( $categories && ! is_wp_error( $categories ) ) :
						echo '<span class="p-article__category" data-url="' . get_category_link( $categories[0] ) . '">' . esc_html( $categories[0]->name ) . '</span>';
					endif;
				endif;
				echo "</p>\n";
			endif;
?>
						</div>
					</a>
				</article>
<?php
		endwhile;
?>
			</div>
<?php
		if ( $the_query->max_num_pages > 1 ) :
?>
			<ul class="p-pager">
				<li class="p-pager__item p-pager__num u-hidden-xs"><span><?php echo $uscpaged . ' / ' . $the_query->max_num_pages; ?></span></li>
<?php
			if ( $uscpaged > 1 ) :
?>
				<li class="p-pager__item"><a class="first page-numbers" href="javascript:usces_changepage(1)">First</a></li>
				<li class="p-pager__item"><a class="prev page-numbers" href="javascript:usces_changepage(<?php echo $uscpaged - 1; ?>)">&#xe90f;</a></li>
<?php
			endif;
			for ( $i = 1; $i <= $the_query->max_num_pages; $i++ ) :
				if ( $i == $uscpaged ) :
?>
				<li class="p-pager__item"><span aria-current="page" class="page-numbers current"><?php echo $i; ?></span></li>
<?php
				else :
?>
				<li class="p-pager__item"><a class="page-numbers" href="javascript:usces_changepage(<?php echo $i; ?>)"><?php echo $i; ?></a></li>
<?php
				endif;
			endfor;
			if ( $uscpaged < $the_query->max_num_pages ) :
?>
				<li class="p-pager__item"><a class="next page-numbers" href="javascript:usces_changepage(<?php echo $uscpaged + 1; ?>)">&#xe910;</a></li>
				<li class="p-pager__item"><a class="last page-numbers" href="javascript:usces_changepage(<?php echo $wp_query->max_num_pages; ?>)">Last</a></li>
<?php
			endif;
?>
			</ul>
			<script type="text/javascript">
			function usces_changepage( page ) {
				jQuery('#usces_paged').val(page);
				jQuery('#p-wc-search__form').submit();
			}
			</script>
<?php
		endif;

		wp_reset_postdata();
	else :
?>
			<p class="no_post"><?php _e( 'The item was not found.', 'tcd-w' ); ?></p>
<?php
	endif;
endif;
?>

<?php
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
