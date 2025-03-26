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

if ( have_posts() ) :
	the_post();
	usces_remove_filter();
?>
			<div class="p-entry p-wc p-wc-cart-page p-wc-<?php usces_page_name(); ?>">
				<div class="p-entry__body p-wc__body">
					<h2 class="p-wc-headline"><?php _e( 'Your order has not been completed', 'tcd-w' ); ?></h2>
<?php
	uesces_get_error_settlement();
?>
				</div>
			</div>
<?php
else:
?>
			<p><?php _e( 'There is no registered post.', 'tcd-w' ); ?></p>
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
