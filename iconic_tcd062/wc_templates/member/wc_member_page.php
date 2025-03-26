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
					<div class="p-wc-header_explanation"><?php do_action( 'usces_action_memberinfo_page_header' ); ?></div>

					<h2 class="p-wc-headline"><?php _e( 'Member information', 'tcd-w' ); ?></h2>
					<table class="p-wc-member-info u-hidden-sm">
						<tr>
							<th scope="row"><?php _e( 'Member number', 'tcd-w' ); ?></th>
							<td><?php usces_memberinfo( 'ID' ); ?></td>
							<th><?php _e( 'Strated date', 'tcd-w' ); ?></th>
							<td><?php usces_memberinfo( 'registered' ); ?></td>
						</tr>
<?php
	if ( usces_is_membersystem_point() ) :
?>
						<tr>
							<th scope="row"><?php _e( 'Full name', 'tcd-w' ); ?></th>
							<td><?php usces_the_member_name(); ?></td>
							<th><?php _e( 'The current point', 'tcd-w' ); ?></th>
							<td class="currentpoint"><span><?php echo number_format( usces_memberinfo( 'point', 'return' ) ); ?></span> <?php echo 0 == usces_memberinfo( 'point', 'return' ) ? __( 'point', 'tcd-w' ) : __( 'points', 'tcd-w' ); ?></td>
						</tr>
						<tr>
							<th scope="row"><?php _e( 'E-mail adress', 'tcd-w' ); ?></th>
							<td><?php usces_memberinfo( 'mailaddress1' ); ?></td>
							<th></th>
							<td></td>
						</tr>
<?php
	else :
?>
						<tr>
							<th scope="row"><?php _e( 'Full name', 'tcd-w' ); ?></th>
							<td><?php usces_the_member_name(); ?></td>
							<th scope="row"><?php _e( 'E-mail adress', 'tcd-w' ); ?></th>
							<td><?php usces_memberinfo( 'mailaddress1' ); ?></td>
						</tr>
<?php
	endif;
?>
					</table>
					<div class="u-visible-sm">
						<table class="p-wc-member-info">
							<tr>
								<th scope="row"><?php _e( 'Member number', 'tcd-w' ); ?></th>
								<td><?php usces_memberinfo( 'ID' ); ?></td>
							</tr>
							<tr>
								<th scope="row"><?php _e( 'Full name', 'tcd-w' ); ?></th>
								<td><?php usces_the_member_name(); ?></td>
							</tr>
							<tr>
								<th scope="row"><?php _e( 'E-mail adress', 'tcd-w' ); ?></th>
								<td><?php usces_memberinfo( 'mailaddress1' ); ?></td>
							</tr>
							<tr>
								<th><?php _e( 'Strated date', 'tcd-w' ); ?></th>
								<td><?php usces_memberinfo( 'registered' ); ?></td>
							</tr>
<?php
	if ( usces_is_membersystem_point() ) :
?>
							<tr>
								<th><?php _e( 'The current point', 'tcd-w' ); ?></th>
								<td class="currentpoint"><span><?php echo number_format( usces_memberinfo( 'point', 'return' ) ); ?></span> <?php echo 0 == usces_memberinfo( 'point', 'return' ) ? __( 'point', 'tcd-w' ) : __( 'points', 'tcd-w' ); ?></td>
							</tr>
<?php
	endif;
?>
						</table>
					</div>
<?php
	// プラグイン用会員サブメニューフィルター
	$member_submenu_list = apply_filters( 'usces_filter_member_submenu_list', '', $usces->get_member() );
	if ( $member_submenu_list ) :
?>
					<ul class="p-wc-member_submenu"><?php echo $member_submenu_list ?></ul>
<?php
	endif;
?>
					<h2 class="p-wc-headline"><?php _e( 'Purchase history', 'tcd-w' ); ?></h2>
<?php
	usces_member_history();
?>

					<h2 class="p-wc-headline"><?php _e( 'Member information editing', 'tcd-w' ); ?></h2>
					<div class="p-wc-error_message"><?php usces_error_message(); ?></div>
					<form action="<?php usces_url( 'member' ); ?>#edit" method="post" onKeyDown="if (event.keyCode == 13) {return false;}">
						<table class="p-wc-customer_form">
							<tr>
								<th scope="row"><?php _e( 'E-mail adress', 'tcd-w' ); ?></th>
								<td colspan="2"><input name="member[mailaddress1]" id="mailaddress1" type="text" value="<?php usces_memberinfo( 'mailaddress1' ); ?>"></td>
							</tr>
							<tr>
								<th scope="row"><?php _e( 'Password', 'tcd-w' ); ?></th>
								<td colspan="2"><input class="hidden" value=" "><input name="member[password1]" id="password1" type="password" value="<?php usces_memberinfo( 'password1' ); ?>" autocomplete="off">
								<?php _e( 'Leave it blank in case of no change.', 'tcd-w' ); ?></td>
							</tr>
							<tr>
								<th scope="row"><?php _e( 'Password (confirm)', 'tcd-w' ); ?></th>
								<td colspan="2"><input name="member[password2]" id="password2" type="password" value="<?php usces_memberinfo( 'password2' ); ?>">
								<?php _e( 'Leave it blank in case of no change.', 'tcd-w' ); ?></td>
							</tr>
<?php
	uesces_addressform( 'member', usces_memberinfo( NULL ), 'echo' );
?>
						</table>
						<input name="member_regmode" type="hidden" value="editmemberform">
						<div class="send">
							<input name="editmember" type="submit" value="<?php _e( 'Update it', 'tcd-w' ); ?>" class="p-button p-button-lg">
							<input name="deletemember" type="submit" value="<?php _e( 'Delete it', 'tcd-w' ); ?>" class="p-button p-button-lg" onclick="return confirm( '<?php _e( 'All information about the member is deleted. Are you all right?', 'tcd-w' ); ?>' );">
						</div>
						<?php do_action( 'usces_action_memberinfo_page_inform' ); ?>
					</form>

					<div class="p-wc-footer_explanation"><?php do_action( 'usces_action_memberinfo_page_footer' ); ?></div>
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
