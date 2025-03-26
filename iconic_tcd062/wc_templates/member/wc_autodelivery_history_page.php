<?php
global $dp_options, $post, $usces;

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
			<div class="p-entry p-wc p-wc-mypage p-wc-<?php if ( 'login' != usces_page_name() ) echo usces_page_name(); ?>">
				<div class="p-entry__body p-wc__body">
					<div class="p-wc-header_explanation"><?php do_action( 'wcad_action_autodelivery_history_page_header' ); ?></div>

					<h2 class="p-wc-headline"><?php _e( 'Regular purchase information', 'autodelivery' ); ?></h2>
					<div class="p-wc-error_message"><?php usces_error_message(); ?></div>

					<form action="<?php usces_url('member'); ?>#autodelivery" class="p-wc-autodelivery_history" method="post" onKeyDown="if (event.keyCode == 13) {return false;}">
<?php wcad_autodelivery_history(); ?>
						<input name="member_regmode" type="hidden" value="editmemberform">
						<input name="member_id" type="hidden" value="<?php usces_memberinfo( 'ID' ); ?>">
<?php do_action('wcad_action_autodelivery_history_page_inform'); ?>
					</form>

					<ul class="p-wc-member_submenu">
						<li><a class="p-button p-button--gray" href="<?php echo USCES_MEMBER_URL; ?>"><?php _e( 'Back to the member page.', 'usces' ); ?></a></li>
					</ul>
					<div class="p-wc-footer_explanation"><?php do_action( 'wcad_action_autodelivery_history_page_footer' ); ?></div>
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
