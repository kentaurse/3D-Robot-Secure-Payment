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
			<div class="p-entry p-wc p-wc-cart-page p-wc-<?php usces_page_name(); ?>">
				<div class="p-entry__body p-wc__body">
					<div class="p-wc-cart_navi">
						<ul>
							<li><span><?php _e( '1.Cart', 'tcd-w' ); ?></span></li>
							<li class="is-current"><span><?php _e( '2.Customer Info', 'tcd-w' ); ?></span></li>
							<li><span><?php _e( '3.Deli. & Pay.', 'tcd-w' ); ?></span></li>
							<li><span><?php _e( '4.Confirm', 'tcd-w' ); ?></span></li>
						</ul>
					</div>
					<div class="p-wc-header_explanation"><?php do_action( 'usces_action_customer_page_header' ); ?></div>
					<div class="p-wc-error_message"><?php usces_error_message(); ?></div>
<?php
	if ( usces_is_membersystem_state() ) :
?>
					<h2 class="p-wc-headline"><?php _e( 'The member please enter at here.', 'tcd-w' ); ?></h2>
					<form action="<?php usces_url( 'cart' ); ?>" method="post" name="customer_loginform" onKeyDown="if (event.keyCode == 13) {return false;}">
						<table class="p-wc-customer_form">
							<tr>
								<th scope="row"><?php _e( 'E-mail adress', 'tcd-w' ); ?></th>
								<td><input name="loginmail" id="loginmail" type="text" value="<?php echo esc_attr( $usces_entries['customer']['mailaddress1'] ); ?>" style="ime-mode: inactive"></td>
							</tr>
							<tr>
								<th scope="row"><?php _e( 'Password', 'tcd-w' ); ?></th>
								<td>
									<input class="hidden" value=" "><input name="loginpass" id="loginpass" type="password" value="" autocomplete="off">
									<a href="<?php usces_url( 'lostmemberpassword' ); ?>" title="<?php _e( 'Did you forget your password?', 'tcd-w' ); ?>"><?php _e( 'Did you forget your password?', 'tcd-w' ); ?></a>
								</td>
							</tr>
						</table>
						<div class="send"><input name="customerlogin" type="submit" class="p-button p-button--lg" value="<?php _e( ' Next ', 'tcd-w' ); ?>"></div>
<?php
		if ( tcd_welcart_have_ex_order() ) :
?>
						<ul class="p-wc-member__links">
							<li><a href="<?php usces_url( 'newmember' ) . apply_filters( 'usces_filter_newmember_urlquery', NULL ); ?>" title="<?php _e( 'New enrollment for membership.', 'tcd-w' ); ?>"><?php _e( 'New enrollment for membership.', 'tcd-w' ); ?></a></li>
						</ul>
<?php
		endif;

		do_action( 'usces_action_customer_page_member_inform' );
?>
					</form>
<?php
	endif;

	if ( ! tcd_welcart_have_ex_order() ) :
		if ( usces_is_membersystem_state() ) :
?>
					<h2 class="p-wc-headline"><?php _e( 'The nonmember please enter at here.', 'tcd-w' ); ?></h2>
<?php
		endif;
?>					<form action="<?php echo USCES_CART_URL; ?>" method="post" name="customer_form" onKeyDown="if (event.keyCode == 13) {return false;}">
						<table class="p-wc-customer_form">
							<tr>
								<th scope="row"><em><?php _e( '*', 'tcd-w' ); ?></em><?php _e( 'E-mail adress', 'tcd-w' ); ?></th>
								<td colspan="2"><input name="customer[mailaddress1]" id="mailaddress1" type="text" value="<?php echo esc_attr( $usces_entries['customer']['mailaddress1'] ); ?>" style="ime-mode: inactive"></td>
							</tr>
							<tr>
								<th scope="row"><em><?php _e( '*', 'tcd-w' ); ?></em><?php _e( 'E-mail address (confirm)', 'tcd-w' ); ?></th>
								<td colspan="2"><input name="customer[mailaddress2]" id="mailaddress2" type="text" value="<?php echo esc_attr( $usces_entries['customer']['mailaddress2'] ); ?>" style="ime-mode: inactive"></td>
							</tr>
<?php
		if ( usces_is_membersystem_state() ) :
?>
							<tr>
								<th scope="row"><?php if ( $member_regmode == 'editmemberfromcart' ) : ?><em><?php _e( '*', 'tcd-w' ); ?></em><?php endif; ?><?php _e( 'Password', 'tcd-w' ); ?></th>
								<td colspan="2"><input class="hidden" value=" "><input name="customer[password1]" type="password" value="<?php echo esc_attr( $usces_entries['customer']['password1'] ); ?>" autocomplete="off"><?php if ( $member_regmode != 'editmemberfromcart' ) _e( 'When you enroll newly, please fill it out.', 'tcd-w' ); ?>	</td>
							</tr>
							<tr>
								<th scope="row"><?php if ( $member_regmode == 'editmemberfromcart' ) : ?><em><?php _e( '*', 'tcd-w' ); ?></em><?php endif; ?><?php _e( 'Password (confirm)', 'tcd-w' ); ?></th>
								<td colspan="2"><input name="customer[password2]"type="password" value="<?php echo esc_attr( $usces_entries['customer']['password2'] ); ?>"><?php if ( $member_regmode != 'editmemberfromcart' ) _e( 'When you enroll newly, please fill it out.', 'tcd-w' ); ?></td>
							</tr>
<?php
		endif;

		uesces_addressform( 'customer', $usces_entries, 'echo' );
?>
						</table>
<?php
	usces_agree_member_field();
?>
						<input name="member_regmode" type="hidden" value="<?php echo $member_regmode; ?>">
						<div class="send"><?php usces_get_customer_button(); ?></div>

						<?php do_action( 'usces_action_customer_page_inform' ); ?>
					</form>
					<div class="p-wc-footer_explanation"><?php do_action( 'usces_action_customer_page_footer' ); ?></div>
				</div>
			</div>
<?php
	endif;
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
