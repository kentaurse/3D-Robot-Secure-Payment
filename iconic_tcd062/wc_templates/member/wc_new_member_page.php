<?php
global $dp_options, $usces, $member_regmode;

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
					<div class="p-wc-header_explanation">
						<h2 class="p-wc-headline"><?php _e( 'About member registration', 'tcd-w' ); ?></h2>
						<ul>
							<li><?php _e( 'All your personal information will be protected and handled with carefull attention.', 'tcd-w' ); ?></li>
							<li><?php _e( 'Your information is entrusted to us for the purpose of providing information and respond to your requests, but to be used for any other purpose. More information, please visit our Privacy Notice.', 'tcd-w' ); ?></li>
							<li><?php _e( 'The items marked with *, are mandatory. Please complete.', 'tcd-w' ); ?></li>
							<li><?php _e( 'Please use Alphanumeric characters for numbers.', 'tcd-w' ); ?></li>
						</ul>
						<?php do_action( 'usces_action_newmember_page_header' ); ?>
					</div>
					<div class="p-wc-error_message"><?php usces_error_message(); ?></div>

					<form action="<?php echo apply_filters( 'usces_filter_newmember_form_action', usces_url( 'member', 'return' ) ); ?>" method="post" onKeyDown="if (event.keyCode == 13) {return false;}">
						<table class="p-wc-customer_form">
							<tr>
								<th scope="row"><em><?php _e( '*', 'tcd-w' ); ?></em><?php _e( 'E-mail adress', 'tcd-w' ); ?></th>
								<td colspan="2"><input name="member[mailaddress1]" id="mailaddress1" type="text" value="<?php usces_memberinfo( 'mailaddress1' ); ?>"></td>
							</tr>
							<tr>
								<th scope="row"><em><?php _e( '*', 'tcd-w' ); ?></em><?php _e( 'E-mail address (confirm)', 'tcd-w' ); ?></th>
								<td colspan="2"><input name="member[mailaddress2]" id="mailaddress2" type="text" value="<?php usces_memberinfo( 'mailaddress2' ); ?>"></td>
							</tr>
							<tr>
							<th scope="row"><em><?php _e( '*', 'tcd-w' ); ?></em><?php _e( 'Password', 'tcd-w' ); ?></th>
							<td colspan="2"><input class="hidden" value=" "><input name="member[password1]" id="password1" type="password" value="<?php usces_memberinfo( 'password1' ); ?>" autocomplete="off"></td>
							</tr>
							<tr>
							<th scope="row"><em><?php _e( '*', 'tcd-w' ); ?></em><?php _e( 'Password (confirm)', 'tcd-w' ); ?></th>
							<td colspan="2"><input name="member[password2]" id="password2" type="password" value="<?php usces_memberinfo( 'password2' ); ?>"></td>
							</tr>
							<?php uesces_addressform( 'member', usces_memberinfo( NULL ), 'echo' ); ?>
						</table>
						<?php usces_agree_member_field(); ?>
						<div class="p-wc-customer_form-button"><?php usces_newmember_button( $member_regmode ); ?></div>
						<?php do_action( 'usces_action_newmember_page_inform' ); ?>
					</form>

					<div class="p-wc-footer_explanation"><?php do_action( 'usces_action_login_page_footer' ); ?></div>
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
