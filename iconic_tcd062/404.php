<?php
$dp_options = get_design_plus_option();
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
<?php
endif;
?>

		<div class="p-entry <?php echo $active_sidebar ? 'l-primary' : 'l-inner'; ?>">
			<p><?php _e( "Sorry, but you are looking for something that isn't here.", 'tcd-w' ); ?></p>
		</div>
<?php
if ( $active_sidebar ) :
	get_sidebar();
?>
	</div>
<?php
endif;
?>
</main>
<?php get_footer(); ?>
