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
			<div class="p-entry p-wc p-wc-member p-wc-<?php usces_page_name(); ?>">
				<div class="p-entry__body p-wc__body">
					<div class="p-wc-header_explanation"><?php do_action( 'usces_action_membercompletion_page_header' ); ?></div>
<?php
	$member_compmode = usces_page_name( 'return' );
	if ( 'newcompletion' == $member_compmode ) :
?>
					<p><?php _e( 'Thank you in new membership.', 'tcd-w' ); ?></p>
<?php
	elseif ( 'editcompletion' == $member_compmode ) :
?>
					<p><?php _e( 'Membership information has been updated.', 'tcd-w' ); ?></p>
<?php
	elseif ( 'lostcompletion' == $member_compmode ) :
?>
					<p><?php _e( 'I transmitted an email.', 'tcd-w' ); ?></p>
					<p><?php _e( 'Change your password by following the instruction in this mail.', 'tcd-w' ); ?></p>
<?php
	elseif ( 'changepasscompletion' == $member_compmode ) :
?>
					<p><?php _e( 'Password has been changed.', 'tcd-w' ); ?></p>
<?php
	endif;
?>
					<div class="p-wc-footer_explanation"><?php do_action( 'usces_action_membercompletion_page_footer' ); ?></div>
					<ul class="p-wc-member__links">
						<li><a href="<?php usces_url( 'member' ); ?>"><?php _e( 'to vist membership information page', 'tcd-w' ); ?></a></li>
						<li><a href="<?php echo home_url(); ?>" class="back_to_top_button"><?php _e( 'Back to the top page.', 'tcd-w' ); ?></a></li>
					</ul>
				</div>
			</div>
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
