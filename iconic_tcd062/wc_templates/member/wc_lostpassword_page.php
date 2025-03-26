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
			<div class="p-entry p-wc p-wc-member p-wc-login p-wc-<?php usces_page_name(); ?>">
				<div class="p-entry__body p-wc__body">
					<div class="p-wc-header_explanation"><?php do_action( 'usces_action_newpass_page_header' ); ?></div>
					<form class="p-wc-loginform" name="p-wc-loginform" id="loginform" action="<?php echo apply_filters( 'usces_filter_login_form_action', USCES_MEMBER_URL ); ?>" method="post" onKeyDown="if (event.keyCode == 13) {return false;}">
						<div class="p-wc-error_message"><?php usces_error_message(); ?></div>
						<p class="p-wc-loginform__inputs">
							<label for="loginmail"><?php _e( 'E-mail adress', 'tcd-w' ); ?></label>
							<input type="text" name="loginmail" id="loginmail" class="p-wc-loginmail" value="">
						</p>
						<p class="p-wc-loginform__button">
							<input type="submit" class="p-button p-button--lg" name="lostpassword" id="member_login" value="<?php _e( 'Obtain new password', 'tcd-w' ); ?>">
						</p>
						<?php do_action( 'usces_action_newpass_page_inform' ); ?>
						<p class="p-wc-newpass__message"><?php _e( 'Change your password by following the instruction in this mail.', 'tcd-w' ); ?></p>
						<?php if ( ! usces_is_login() ) : ?>
						<ul class="p-wc-member__links">
							<li><a href="<?php usces_url( 'login' ); ?>" title="<?php _e( 'Log-in', 'tcd-w' ); ?>"><?php _e( 'Log-in', 'tcd-w' ); ?></a></li>
						</ul>
						<?php endif; ?>
					</form>
					<div class="p-wc-footer_explanation"><?php do_action( 'usces_action_newpass_page_footer' ); ?></div>
				</div>
				<script type="text/javascript">
				try{document.getElementById('loginmail').focus();}catch(e){}
				</script>
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
