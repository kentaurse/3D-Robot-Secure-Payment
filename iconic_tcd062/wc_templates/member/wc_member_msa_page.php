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
					<div class="p-wc-header_explanation"><?php do_action( 'msa_action_memberinfo_page_header' ); ?></div>

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
					<ul class="p-wc-member_submenu">
						<li><a class="p-button p-button--gray" href="<?php echo USCES_MEMBER_URL; ?>"><?php _e( 'Back to the member page.', 'usces' ); ?></a></li>
					</ul>

<?php
	$usces_members = $usces->get_member();
?>
					<h2 class="p-wc-headline"><?php echo apply_filters( 'msa_filter_gift_label', 'ギフト用' ); ?>配送先を登録</h2>
					<div class="msa_area">
						<div class="msa_total"><?php _e( '登録件数', 'usces' ); ?><span id="msa_num"></span>件<input id="new_destination" type="button" value="<?php _e( '新しい配送先を追加する', 'usces' ); ?>"></div>
<?php
	if ( isset( $_GET['msa_backurl'] ) ) :
		$cusurl = str_replace( 'customerinfo=1','customerinfo=msa', USCES_CUSTOMER_URL );
?>
						<div class="return_navi"><a href="<?php echo $cusurl; ?>">発送先設定へ戻る</a></div>
						<div class="allocation_dialog_exp">１．「新しい配送先を登録する」を押すと、新規登録画面になります。<br>２．お名前やご住所などの入力が終わりましたら「登録」を押してください。<br>３．登録がすべて終わりましたら、画面下の「発送先設定に戻る」を押してください。<br><br>※ （ご本人）と書かれた配送先は削除できません。登録した配送先を変更・削除する場合は「編集する配送先を選ぶ」から（ご本人）以外のデータを選択してください。</div>
<?php
	else :
?>
						<div class="allocation_dialog_exp">１．「新しい配送先を登録する」を押すと、新規登録画面になります。<br>２．お名前やご住所などの入力が終わりましたら「登録」を押してください。<br><br>※ （ご本人）と書かれた配送先は削除できません。登録した配送先を変更・削除する場合は「編集する配送先を選ぶ」から（ご本人）以外のデータを選択してください。</div>
<?php
	endif;
?>
						<div class="msa_operation">
							<label for="destination" class="destination_label">編集する配送先を選ぶ</label><select id="destination"></select>
<?php
	do_action('msa_action_memberinfo_page_operation');
?>
						</div>
						<div class="msa_title"><?php _e( '配送先', 'usces' ); ?> : <span id="destination_title" class="msa_title_inner"></span></div>
						<table class="p-wc-customer_form p-wc-customer_form--msa">
							<tr>
								<th scope="row"><?php _e( '法人名', 'usces' ); ?></th>
								<td><input id="msa_company" name="msa_company" type="text"></td>
							</tr>
							<tr>
								<th scope="row"><em><?php _e( '*', 'usces' ); ?></em><?php _e( 'name', 'usces' ); ?></th>
								<td><?php _e( 'Familly name', 'usces' ); ?> <input id="msa_name" name="msa_name" type="text"> <br class="u-visible-xs"><?php _e( 'Given name', 'usces' ); ?> <input id="msa_name2" name="msa_name2" type="text"><span id="name_message" class="msa_message"></span></td>
							</tr>
							<tr>
								<th scope="row"><?php _e( 'furigana', 'usces' ); ?></th>
								<td><?php _e( 'Familly name', 'usces' ); ?> <input id="msa_furigana" name="msa_furigana" type="text"> <br class="u-visible-xs"><?php _e( 'Given name', 'usces' ); ?> <input id="msa_furigana2" name="msa_furigana2" type="text"></td>
							</tr>
							<tr>
								<th scope="row"><em><?php _e( '*', 'usces' ); ?></em><?php _e( 'Zip/Postal Code', 'usces' ); ?></th>
								<td><input id="msa_zip" name="msa_zip" type="text"><?php if ( isset( $usces->options['address_search'] ) && 'activate' == $usces->options['address_search'] ) { echo "<input type='button' id='search_zipcode' class='search-zipcode button' value='住所検索' onclick=\"AjaxZip3.zip2addr('msa_zip', '', 'msa_pref', 'msa_address1');\">"; } ?><span id="zip_message" class="msa_message"></span></td>
							</tr>
							<tr>
								<th scope="row"><em><?php _e( '*', 'usces' ); ?></em><?php _e( 'Province', 'usces' ); ?></th>
								<td>
									<select name="msa_pref" id="msa_pref" class="pref">
										<option value="0">--選択--</option>
										<option value="北海道">北海道</option>
										<option value="青森県">青森県</option>
										<option value="岩手県">岩手県</option>
										<option value="宮城県">宮城県</option>
										<option value="秋田県">秋田県</option>
										<option value="山形県">山形県</option>
										<option value="福島県">福島県</option>
										<option value="茨城県">茨城県</option>
										<option value="栃木県">栃木県</option>
										<option value="群馬県">群馬県</option>
										<option value="埼玉県">埼玉県</option>
										<option value="千葉県">千葉県</option>
										<option value="東京都">東京都</option>
										<option value="神奈川県">神奈川県</option>
										<option value="新潟県">新潟県</option>
										<option value="富山県">富山県</option>
										<option value="石川県">石川県</option>
										<option value="福井県">福井県</option>
										<option value="山梨県">山梨県</option>
										<option value="長野県">長野県</option>
										<option value="岐阜県">岐阜県</option>
										<option value="静岡県">静岡県</option>
										<option value="愛知県">愛知県</option>
										<option value="三重県">三重県</option>
										<option value="滋賀県">滋賀県</option>
										<option value="京都府">京都府</option>
										<option value="大阪府">大阪府</option>
										<option value="兵庫県">兵庫県</option>
										<option value="奈良県">奈良県</option>
										<option value="和歌山県">和歌山県</option>
										<option value="鳥取県">鳥取県</option>
										<option value="島根県">島根県</option>
										<option value="岡山県">岡山県</option>
										<option value="広島県">広島県</option>
										<option value="山口県">山口県</option>
										<option value="徳島県">徳島県</option>
										<option value="香川県">香川県</option>
										<option value="愛媛県">愛媛県</option>
										<option value="高知県">高知県</option>
										<option value="福岡県">福岡県</option>
										<option value="佐賀県">佐賀県</option>
										<option value="長崎県">長崎県</option>
										<option value="熊本県">熊本県</option>
										<option value="大分県">大分県</option>
										<option value="宮崎県">宮崎県</option>
										<option value="鹿児島県">鹿児島県</option>
										<option value="沖縄県">沖縄県</option>
									</select><span id="pref_message" class="msa_message"></span>
								</td>
							</tr>
							<tr>
								<th scope="row"><em><?php _e( '*', 'usces' ); ?></em><?php _e( 'city', 'usces' ); ?></th>
								<td><input id="msa_address1" name="msa_address1" type="text"><span id="address1_message" class="msa_message"></span></td>
							</tr>
							<tr>
								<th scope="row"><em><?php _e( '*', 'usces' ); ?></em><?php _e( 'numbers', 'usces' ); ?></th>
								<td><input id="msa_address2" name="msa_address2" type="text"><span id="address2_message" class="msa_message"></span></td>
							</tr>
							<tr>
								<th scope="row"><?php _e( 'ビル名など', 'usces' ); ?></th>
								<td><input id="msa_address3" name="msa_address3" type="text"></td>
							</tr>
							<tr>
								<th scope="row"><em><?php _e( '*', 'usces' ); ?></em><?php _e( 'Phone number', 'usces' ); ?></th>
								<td><input id="msa_tel" name="msa_tel" type="text"><span id="tel_message" class="msa_message"></span></td>
							</tr>
							<tr>
								<th scope="row"><?php _e( 'FAX number', 'usces' ); ?></th>
								<td><input id="msa_fax" name="msa_fax" type="text"><span id="fax_message" class="msa_message"></span></td>
							</tr>
							<tr>
								<th scope="row"><?php _e( 'Notes', 'usces' ); ?></th>
								<td><textarea id="msa_note" name="msa_note"></textarea></td>
							</tr>
						</table>
						<input name="_wcnonce" type="hidden" value="<?php echo wp_create_nonce('msa-nonce'); ?>"/>
						<input name="member_id" type="hidden" value="<?php echo esc_attr($usces_members['ID']) ?>"/>
						<div id="msa_button">
							<input name="add_destination" id="add_destination" type="button" value="<?php _e( 'Add', 'usces' ); ?>">
							<input name="edit_destination" id="edit_destination" type="button" value="<?php _e( 'Update', 'usces' ); ?>">
							<input name="cancel_destination" id="cancel_destination" type="button" value="<?php _e( 'Cancel', 'usces' ); ?>">
							<input id="del_destination" type="button" value="<?php _e( 'Delete', 'usces' ); ?>">
							<div id="msa_loading"></div>
						</div>
					</div>
					<div class="p-wc-footer_explanation"><?php do_action( 'msa_action_memberinfo_page_footer' ); ?></div>
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
