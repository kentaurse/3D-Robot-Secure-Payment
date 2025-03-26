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
					<div class="p-wc-header_explanation"><?php do_action( 'usces_action_login_page_header' ); ?></div>
					<form class="p-wc-loginform" name="p-wc-loginform" id="loginform" action="<?php echo apply_filters( 'usces_filter_login_form_action', USCES_MEMBER_URL ); ?>" method="post" onKeyDown="if (event.keyCode == 13) {return false;}">
						<div class="p-wc-error_message"><?php usces_error_message(); ?></div>
						<p class="p-wc-loginform__inputs">
							<label for="loginmail"><?php _e( 'E-mail adress', 'tcd-w' ); ?></label>
							<input type="text" name="loginmail" id="loginmail" class="p-wc-loginmail" value="<?php echo esc_attr( usces_remembername( 'return' ) ); ?>">
						</p>
						<p class="p-wc-loginform__inputs">
							<label for="loginpass"><?php _e( 'Password', 'tcd-w' ); ?></label>
							<input class="hidden" value=" ">
							<input type="password" name="loginpass" id="loginpass" class="p-wc-password" autocomplete="off">
						</p>
						<p class="p-wc-rememberme">
							<label><input name="rememberme" type="checkbox" id="rememberme" value="forever"> <?php _e( 'Memorize login information', 'tcd-w' ); ?></label>
						</p>
						<p class="p-wc-loginform__button">
							<?php usces_login_button(); ?>
						</p>
						<?php do_action( 'usces_action_login_page_inform' ); ?>
						<ul class="p-wc-member__links">
							<li><a href="<?php usces_url( 'lostmemberpassword' ); ?>" title="<?php _e( 'Did you forget your password?', 'tcd-w' ); ?>"><?php _e( 'Did you forget your password?', 'tcd-w' ); ?></a></li>
						<?php if ( ! usces_is_login() ) : ?>
							<li><a href="<?php usces_url( 'newmember' ) . apply_filters( 'usces_filter_newmember_urlquery', NULL ); ?>" title="<?php _e( 'New enrollment for membership.', 'tcd-w' ); ?>"><?php _e( 'New enrollment for membership.', 'tcd-w' ); ?></a></li>
						<?php endif; ?>
						</ul>
					</form>
					<div class="p-wc-footer_explanation"><?php do_action( 'usces_action_login_page_footer' ); ?></div>
				</div>

				<script type="text/javascript">
				<?php if ( usces_is_login() ) : ?>
				setTimeout(function(){
					try{
						d = document.getElementById('loginpass');
						d.value = '';
						d.focus();
					} catch(e){}
				}, 200 );
				<?php else : ?>
				try{document.getElementById('loginmail').focus();}catch(e){}
				<?php endif; ?>
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
