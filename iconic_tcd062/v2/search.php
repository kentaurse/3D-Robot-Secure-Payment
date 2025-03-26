<?php
/* 
Template Name: Search 
*/  
get_header();
global $seconddb;

$rebate_only = $_POST['rebate_only'];

$rebate_status = get_option('custom_dashboard_rebate_status', 'off');
$selected_option = get_option('custom_dashboard_order_option', 'random');	
$selected_agency = get_option('custom_dashboard_agency_option');

if(isset($_POST['company'])){
	$company = $_POST['company'];
}

$sql = "SELECT * FROM userlist WHERE listflag = 'on'";

if (!empty($company)) {
	$sql .= " AND company LIKE '%$company%' AND searchflag IS NULL";
}

if(!empty($rebate_only) && $rebate_only == 'true'){
	$rebate_days = get_option('custom_dashboard_rebate_days', 0);
	$sql .= " AND logday >= DATE_SUB(NOW(), INTERVAL $rebate_days DAY)";
}

if ($selected_option == 'latest') {
	$sql .= " ORDER BY CASE 
	WHEN urlimgcheck <> 2 AND logday >= DATE_SUB(NOW(), INTERVAL 1 MONTH) THEN 0 
	WHEN urlimgcheck <> 2 AND (logday < DATE_SUB(NOW(), INTERVAL 1 MONTH) OR logday IS NULL) THEN 1 
	WHEN urlimgcheck = 2 AND logday >= DATE_SUB(NOW(), INTERVAL 1 MONTH) THEN 2 
	ELSE 3 END, RAND()";
} else if ($selected_option == 'agency' && !empty($selected_agency)) {
	$sql .= " ORDER BY CASE
	WHEN urlimgcheck <> 2 AND FIND_IN_SET(fromwhere, '$selected_agency') > 0 THEN 0
	WHEN urlimgcheck <> 2 AND FIND_IN_SET(fromwhere, '$selected_agency') = 0 THEN 1
	WHEN urlimgcheck = 2 AND FIND_IN_SET(fromwhere, '$selected_agency') > 0 THEN 2
	ELSE 3 END, RAND()";
} else if ($selected_option == 'latest_agency' && !empty($selected_agency)) {
	$sql .= " ORDER BY CASE
	WHEN urlimgcheck <> 2 AND FIND_IN_SET(fromwhere, '$selected_agency') > 0 AND logday >= DATE_SUB(NOW(), INTERVAL 1 MONTH) THEN 0
	WHEN urlimgcheck <> 2 AND FIND_IN_SET(fromwhere, '$selected_agency') = 0 AND logday >= DATE_SUB(NOW(), INTERVAL 1 MONTH) THEN 1
	WHEN urlimgcheck <> 2 AND FIND_IN_SET(fromwhere, '$selected_agency') > 0 AND (logday < DATE_SUB(NOW(), INTERVAL 1 MONTH) OR logday IS NULL) THEN 2
	WHEN urlimgcheck <> 2 AND FIND_IN_SET(fromwhere, '$selected_agency') = 0 AND (logday < DATE_SUB(NOW(), INTERVAL 1 MONTH) OR logday IS NULL) THEN 3
	WHEN urlimgcheck = 2 AND FIND_IN_SET(fromwhere, '$selected_agency') > 0 AND logday >= DATE_SUB(NOW(), INTERVAL 1 MONTH) THEN 4
	WHEN urlimgcheck = 2 AND FIND_IN_SET(fromwhere, '$selected_agency') = 0 AND logday >= DATE_SUB(NOW(), INTERVAL 1 MONTH) THEN 5
	WHEN urlimgcheck = 2 AND FIND_IN_SET(fromwhere, '$selected_agency') > 0 AND (logday < DATE_SUB(NOW(), INTERVAL 1 MONTH) OR logday IS NULL) THEN 6
	ELSE 7 END, RAND()";
} else if ($selected_option == "rebated"){
	$rebate_days = get_option('custom_dashboard_rebate_days', 0);
	if ($rebate_days > 0){
		$sql .= " ORDER BY CASE WHEN urlimgcheck <> 2 AND logday >= DATE_SUB(NOW(), INTERVAL $rebate_days DAY) THEN 0
		WHEN urlimgcheck <> 2 AND (logday < DATE_SUB(NOW(), INTERVAL $rebate_days DAY) OR logday IS NULL) THEN 1
		WHEN urlimgcheck = 2 THEN 2
		ELSE 3 END, RAND()";
	} else {
		$sql .= " ORDER BY CASE WHEN urlimgcheck <> 2 THEN 0
		WHEN urlimgcheck = 2 THEN 1
		ELSE 2 END, RAND()";
	}
} else if ($selected_option == "os"){
	$sql .= " ORDER BY CASE WHEN urlimgcheck <> 2 AND os_customer = 'on' THEN 0
	WHEN urlimgcheck <> 2 THEN 1
	WHEN urlimgcheck = 2 AND os_customer = 'on' THEN 2
	ELSE 3 END, RAND()";
} else if ($selected_option == "rebated_os"){
	$rebate_days = get_option('custom_dashboard_rebate_days', 0);
	if ($rebate_days > 0){
		$sql .= " ORDER BY CASE WHEN urlimgcheck <> 2 AND os_customer = 'on' AND logday >= DATE_SUB(NOW(), INTERVAL $rebate_days DAY) THEN 0
		WHEN urlimgcheck <> 2 AND logday >= DATE_SUB(NOW(), INTERVAL $rebate_days DAY) THEN 1
 		WHEN urlimgcheck <> 2 AND os_customer = 'on' THEN 2
 		WHEN urlimgcheck <> 2 THEN 3
		WHEN urlimgcheck = 2 AND os_customer = 'on' AND logday >= DATE_SUB(NOW(), INTERVAL $rebate_days DAY) THEN 4
		WHEN urlimgcheck = 2 AND logday >= DATE_SUB(NOW(), INTERVAL $rebate_days DAY) THEN 5
		WHEN urlimgcheck = 2 AND os_customer = 'on' THEN 6
		ELSE 7 END, RAND()";
	} else {
		$sql .= " ORDER BY CASE WHEN urlimgcheck <> 2 AND os_customer = 'on' THEN 0
		WHEN urlimgcheck <> 2 THEN 1
		WHEN urlimgcheck = 2 AND os_customer = 'on' THEN 2
		ELSE 3 END, RAND()";
	}

} else {
	$sql .= " ORDER BY CASE WHEN urlimgcheck <> 2 THEN 0 ELSE 1 END, RAND()";
}

$rows = $seconddb->get_results($sql);

?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
	integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>
<style>
	body {
		font-family: Arial, Helvetica, sans-serif;
	}

	* {
		box-sizing: border-box;
	}



	input[type=text],
	input[type=password],
	input[type=email] {
		width: 100%;
		padding: 15px;
		margin: 5px 0 22px 0;
		display: inline-block;
		border: none;
		background: #f1f1f1;
	}

	input[type=text]:focus,
	input[type=password]:focus {
		background-color: #ddd;
		outline: none;
	}


	hr {
		border: 1px solid #f1f1f1;
		margin-bottom: 25px;
	}


	.registerbtn,
	.loginBtn {
		background-color: #383aff;
		color: white;
		padding: 16px 20px;
		margin: 8px 0;
		border: none;
		cursor: pointer;
		width: 100%;
		opacity: 0.9;
	}

	.registerbtn:hover,
	.loginBtn:hover {
		opacity: 1;
	}

	a {
		color: dodgerblue;
	}

	.signin {
		background-color: #f1f1f1;
		text-align: center;
		padding: 30px;
	}

	.p-blog-archive__item {
		padding: 2%;
	}

	div.linktext {
		line-height: 2em;
		color: black;
	}

	div.linktext:hover {
		color: #e47911;
	}

	.p-hover-effect--type1:hover {
		color: #e47911;
	}

	.star {
		color: #FFA41C;
		-webkit-text-stroke: 1px #FF0000;
		text-stroke: 1px #FF0000;
	}

	.p-blog-archive__item {
		box-shadow: rgb(17 17 26 / 10%) 0px 0px 16px;
		padding: 20px;
	}

	label {
		padding-top: 5px;
		padding-bottom: 5px;
	}

	.advance-search {
		padding: 10px;
		border: 3px solid #DEEBF7;
		border-radius: 28px;
		background-color: #DEEBF7;
	}

	@media only screen and (max-width: 600px) {
		.large-advance-search {
			display: none;
		}
	}

	@media only screen and (min-width: 600px) {
		#search_toggle {
			display: none;
		}
	}
</style>

<main class="l-main">
	<header class="p-page-header">
		<div class="p-page-header__inner l-inner">
			<h1 class="p-page-header__title"><?php echo $company; ?></h1>
		</div>
	</header>
	<div class="p-breadcrumb c-breadcrumb">
		<ul class="p-breadcrumb__inner c-breadcrumb__inner l-inner" itemscope
			itemtype="http://schema.org/BreadcrumbList">
			<li class="p-breadcrumb__item c-breadcrumb__item p-breadcrumb__item--home c-breadcrumb__item--home"
				itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<a href="https://ec-apo.com/" itemprop="item"><span itemprop="name">HOME</span></a>
				<meta itemprop="position" content="1" />
			</li>
			<li class="p-breadcrumb__item c-breadcrumb__item">
				<span itemprop="name"><?php echo $company; ?></span>
			</li>
		</ul>
	</div>

	<div class="row">
		<div class="col-sm-12 col-md-3 col-lg-3" style="padding: 30px">

		<button class="btn btn-primary" id="search_toggle" style="width: 100%" type="button" data-bs-toggle="collapse"
						data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
						条件を絞り込む
		</button>

		<div class="large-advance-search">
				<form class="advance-search" method="post" action="<?php echo admin_url('admin-ajax.php'); ?>">
					<?php if($rebate_status == 'on') { ?>
					<div class="form-group">
						<input type="checkbox" name="rebate_only" id="rebate_only" value="rebate_only">
						<label for="rebate_only">割引中のみ表示</label>
					</div><br>
					<?php } ?>

					<div class="form-group">
						<label for="formGroupExampleInput"><strong>種別</strong></label><br>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" name="co_type" id="co_type" value="法人">
							<label class="form-check-label" for="exampleRadios1">
								法人
							</label>
						</div>

						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" name="co_type" id="co_type" value="個人事業主">
							<label class="form-check-label" for="exampleRadios1">
								個人事業主
							</label>
						</div>
					</div>
					<br>
					<div class="form-group">
						<label for="formGroupExampleInput"><strong>商談相手の役職</strong></label><br>
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="co_title" id="co_title"
								value="代表取締役(法人格)">
							<label class="form-check-label" for="exampleRadios1">
								代表取締役(法人格)
							</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="co_title" id="co_title"
								value="取締役(法人格)">
							<label class="form-check-label" for="exampleRadios1">
								取締役(法人格)
							</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="co_title" id="co_title"
								value="代表社員(合同会社)">
							<label class="form-check-label" for="exampleRadios1">
								代表社員(合同会社)
							</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="co_title" id="co_title"
								value="代表、オーナー(個人事業主)">
							<label class="form-check-label" for="exampleRadios1">
								代表、オーナー(個人事業主)
							</label>
						</div>
					</div>
					<br>
					<div class="form-group">
						<label for="formGroupExampleInput"><strong>商談したい相手のエリア</strong></label><br>
						<div class="">
							<select class="form-select" aria-label="Default select example" name="talkpref" id="talkpref">
								<option>選択してください。</option>
								<option value="北海道" <?php if($talkpref == '北海道') echo 'selected'; ?>>北海道</option>
								<option value="青森県" <?php if($talkpref == '青森県') echo 'selected'; ?>>青森県</option>
								<option value="岩手県" <?php if($talkpref == '岩手県') echo 'selected'; ?>>岩手県</option>
								<option value="宮城県" <?php if($talkpref == '宮城県') echo 'selected'; ?>>宮城県</option>
								<option value="秋田県" <?php if($talkpref == '秋田県') echo 'selected'; ?>>秋田県</option>
								<option value="山形県" <?php if($talkpref == '山形県') echo 'selected'; ?>>山形県</option>
								<option value="福島県" <?php if($talkpref == '福島県') echo 'selected'; ?>>福島県</option>
								<option value="茨城県" <?php if($talkpref == '茨城県') echo 'selected'; ?>>茨城県</option>
								<option value="栃木県" <?php if($talkpref == '栃木県') echo 'selected'; ?>>栃木県</option>
								<option value="群馬県" <?php if($talkpref == '群馬県') echo 'selected'; ?>>群馬県</option>
								<option value="埼玉県" <?php if($talkpref == '埼玉県') echo 'selected'; ?>>埼玉県</option>
								<option value="千葉県" <?php if($talkpref == '千葉県') echo 'selected'; ?>>千葉県</option>
								<option value="東京都" <?php if($talkpref == '東京都') echo 'selected'; ?>>東京都</option>
								<option value="神奈川県" <?php if($talkpref == '神奈川県') echo 'selected'; ?>>神奈川県</option>
								<option value="新潟県" <?php if($talkpref == '新潟県') echo 'selected'; ?>>新潟県</option>
								<option value="富山県" <?php if($talkpref == '富山県') echo 'selected'; ?>>富山県</option>
								<option value="石川県" <?php if($talkpref == '石川県') echo 'selected'; ?>>石川県</option>
								<option value="福井県" <?php if($talkpref == '福井県') echo 'selected'; ?>>福井県</option>
								<option value="山梨県" <?php if($talkpref == '山梨県') echo 'selected'; ?>>山梨県</option>
								<option value="長野県" <?php if($talkpref == '長野県') echo 'selected'; ?>>長野県</option>
								<option value="岐阜県" <?php if($talkpref == '岐阜県') echo 'selected'; ?>>岐阜県</option>
								<option value="静岡県" <?php if($talkpref == '静岡県') echo 'selected'; ?>>静岡県</option>
								<option value="愛知県" <?php if($talkpref == '愛知県') echo 'selected'; ?>>愛知県</option>
								<option value="三重県" <?php if($talkpref == '三重県') echo 'selected'; ?>>三重県</option>
								<option value="滋賀県" <?php if($talkpref == '滋賀県') echo 'selected'; ?>>滋賀県</option>
								<option value="京都府" <?php if($talkpref == '京都府') echo 'selected'; ?>>京都府</option>
								<option value="大阪府" <?php if($talkpref == '大阪府') echo 'selected'; ?>>大阪府</option>
								<option value="兵庫県" <?php if($talkpref == '兵庫県') echo 'selected'; ?>>兵庫県</option>
								<option value="奈良県" <?php if($talkpref == '奈良県') echo 'selected'; ?>>奈良県</option>
								<option value="和歌山県" <?php if($talkpref == '和歌山県') echo 'selected'; ?>>和歌山県</option>
								<option value="鳥取県" <?php if($talkpref == '鳥取県') echo 'selected'; ?>>鳥取県</option>
								<option value="島根県" <?php if($talkpref == '島根県') echo 'selected'; ?>>島根県</option>
								<option value="岡山県" <?php if($talkpref == '岡山県') echo 'selected'; ?>>岡山県</option>
								<option value="広島県" <?php if($talkpref == '広島県') echo 'selected'; ?>>広島県</option>
								<option value="山口県" <?php if($talkpref == '山口県') echo 'selected'; ?>>山口県</option>
								<option value="徳島県" <?php if($talkpref == '徳島県') echo 'selected'; ?>>徳島県</option>
								<option value="香川県" <?php if($talkpref == '香川県') echo 'selected'; ?>>香川県</option>
								<option value="愛媛県" <?php if($talkpref == '愛媛県') echo 'selected'; ?>>愛媛県</option>
								<option value="高知県" <?php if($talkpref == '高知県') echo 'selected'; ?>>高知県</option>
								<option value="福岡県" <?php if($talkpref == '福岡県') echo 'selected'; ?>>福岡県</option>
								<option value="佐賀県" <?php if($talkpref == '佐賀県') echo 'selected'; ?>>佐賀県</option>
								<option value="長崎県" <?php if($talkpref == '長崎県') echo 'selected'; ?>>長崎県</option>
								<option value="熊本県" <?php if($talkpref == '熊本県') echo 'selected'; ?>>熊本県</option>
								<option value="大分県" <?php if($talkpref == '大分県') echo 'selected'; ?>>大分県</option>
								<option value="宮崎県" <?php if($talkpref == '宮崎県') echo 'selected'; ?>>宮崎県</option>
								<option value="鹿児島県" <?php if($talkpref == '鹿児島県') echo 'selected'; ?>>鹿児島県</option>
								<option value="沖縄県" <?php if($talkpref == '沖縄県') echo 'selected'; ?>>沖縄県</option>
							</select>
						</div>
					</div>
					<br>
					<!-- <div class="form-group">
						<label for="formGroupExampleInput"><strong>正社員人数</strong></label><br>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" name="employees" id="employees"
								value="0人(代表(+役員)のみ)">
							<label class="form-check-label" for="exampleRadios1">
								0人(代表(+役員)のみ)
							</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" name="employees" id="employees"
								value="1-10人">
							<label class="form-check-label" for="exampleRadios1">
								1-10人
							</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" name="employees" id="employees"
								value="11-30人">
							<label class="form-check-label" for="exampleRadios1">
								11-30人
							</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" name="employees" id="employees"
								value="31-50人">
							<label class="form-check-label" for="exampleRadios1">
								31-50人
							</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" name="employees" id="employees"
								value="51-100人">
							<label class="form-check-label" for="exampleRadios1">
								51-100人
							</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" name="employees" id="employees"
								value="101-200人">
							<label class="form-check-label" for="exampleRadios1">
								101-200人
							</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" name="employees" id="employees"
								value="201-300人">
							<label class="form-check-label" for="exampleRadios1">
								201-300人
							</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" name="employees" id="employees"
								value="301-400人">
							<label class="form-check-label" for="exampleRadios1">
								301-400人
							</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" name="employees" id="employees"
								value="401-500人">
							<label class="form-check-label" for="exampleRadios1">
								401-500人
							</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" name="employees" id="employees"
								value="500人以上">
							<label class="form-check-label" for="exampleRadios1">
								500人以上
							</label>
						</div>
					</div> -->
					<div class="row text-center">
						<div class="col">
							<?php
							if(isset($_POST['company'])){ ?>
								<input type="hidden" name="company" id="company" value="<?php echo $_POST['company']; ?>">
							<?php }
							?>
							<input type="hidden" name="advance_search" id="advance_search" value="advance_search">
							<button type="submit" class="btn btn-primary adv-search-btn">条件を絞り込む</button>
						</div>
					</div>
				</form>
			</div>

		</div>
		<div class="col-sm-12 col-md-9 col-lg-9">
			<div class="row callback-msg text-center" style="padding: 25px; display: none">
				<h1 class="text-center">該当企業がありません。<br>登録企業は順次増えておりますのでお待ちくださいませ。</h1>
			</div>
			<div class="row search-content" style="padding: 25px"></div>
			<div class="row initial-content" style="padding: 25px">
	<?php 
	foreach($rows as $row){
	?>
					<div class="col-sm-12 col-md-4 col-lg-4" style="padding: 20px">
						<article class="p-blog-archive__item" style="width: 100%">
							<a class="p-hover-effect--type1"
								href="/company?userid=<?php echo htmlspecialchars($row->userid,ENT_QUOTES,'UTF-8'); ?>"
								target="_blank">
								<div class="p-blog-archive__item-thumbnail p-hover-effect__image js-object-fit-cover">
									<?php if ($row->urlimgcheck == '3'): ?>
									<img src="https://s.wordpress.com/mshots/v1/<?php echo htmlspecialchars($row->homepage,ENT_QUOTES,'UTF-8'); ?>"
										alt="" width="740" height="460" class="attachment-size3 size-size3 wp-post-image" />
									<?php elseif($row->urlimgcheck == '1') : ?>
									<img src="https://ec-apo.com/url/<?php echo htmlspecialchars($row->userid,ENT_QUOTES,'UTF-8'); ?>.png"
										width="740" height="460" class="attachment-size3 size-size3 wp-post-image" />
									<?php else : ?>
									<img src="https://ec-apo.com/img/nowprinting.png" width="740" height="460"
										class="attachment-size3 size-size3 wp-post-image" />
									<?php endif; ?>
								</div>
								<div class="linktext">
									<?php echo htmlspecialchars($row->company,ENT_QUOTES,'UTF-8'); ?><br>
									<?php echo htmlspecialchars($row->pref,ENT_QUOTES,'UTF-8'); ?><?php echo htmlspecialchars($row->city,ENT_QUOTES,'UTF-8'); ?><?php echo htmlspecialchars($row->addr,ENT_QUOTES,'UTF-8'); ?><br>
									商談相手：<?php echo htmlspecialchars($row->position,ENT_QUOTES,'UTF-8'); ?><br>
									項目充実度：<span
										class="star"><?php echo htmlspecialchars($row->star,ENT_QUOTES,'UTF-8'); ?></span><br>
									業種：<?php echo htmlspecialchars($row->jobs,ENT_QUOTES,'UTF-8'); ?>　<?php echo htmlspecialchars($row->jobs2,ENT_QUOTES,'UTF-8'); ?>　<?php echo htmlspecialchars($row->jobs3,ENT_QUOTES,'UTF-8'); ?>　<?php echo htmlspecialchars($row->jobs4,ENT_QUOTES,'UTF-8'); ?><br>
									商談設定金額：
									<?php $rebate_rate = getRebateForCompany(htmlspecialchars($row->userid,ENT_QUOTES,'UTF-8')); ?>
									<?php if($rebate_rate > 0) {?>
              <?php $old_price = htmlspecialchars($row->paycost,ENT_QUOTES,'UTF-8'); ?>
              <?php $new_price = number_format(ceil(str_replace(",","",$old_price) * (1 - $rebate_rate / 100)), 0, '.', ',') ?>
              <span style="text-decoration: line-through;">
              ¥<?php echo $old_price ?></span>
              <span class="red">¥<?php echo $new_price ?><br>
            (期間限定 <?php echo $rebate_rate ?>%OFF)</span>
          <?php } else { ?>
            <span class="red">¥<?php echo htmlspecialchars($row->paycost,ENT_QUOTES,'UTF-8') ?></span>
          <?php } ?><br>
								</div>
							</a>
						</article>
					</div>
					<?php 
	} 
	?>
				
			</div>
		</div>
	</div>

</main>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
	integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
	crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
	$(document).ready(function () {
		$('.adv-search-btn').on('click', function (event) {
			event.preventDefault();

			var co_type = [];
			var co_title = [];
			var co_capital = [];
			var employees = [];
			var workers = [];

			$('input[name="co_type"]:checked').each(function (index, elem) {
				co_type.push($(elem).val());
			});
			$('input[name="co_title"]:checked').each(function (index, elem) {
				co_title.push($(elem).val());
			});
			$('input[name="co_capital"]:checked').each(function (index, elem) {
				co_capital.push($(elem).val());
			});
			$('input[name="employees"]:checked').each(function (index, elem) {
				employees.push($(elem).val());
			});
			$('input[name="workers"]:checked').each(function (index, elem) {
				workers.push($(elem).val());
			});

			var co_type = co_type.join(',');
			var co_title = co_title.join(',');
			var co_capital = co_capital.join(',');
			var employees = employees.join(',');
			var workers = workers.join(',');
			var talkpref = $("#talkpref").val();

			var data = {
				'rebate_only': $('#rebate_only').prop("checked"),
				'company': $('#company').val(),
				'co_type': co_type,
				'co_title': co_title,
				'co_capital': co_capital,
				'employees': employees,
				'workers': workers,
				'talkpref': talkpref,
			};

		


			jQuery.ajax({
				url: '<?php echo admin_url('admin-ajax.php'); ?>',
				type: 'post',
				data: {
					action: 'advance_search',
					datas: data,
				},
				success: function (data) {
					$('html, body').animate({
						scrollTop: $(".search-content").offset().top
					}, 500);
					$('.search-content').html("");
					$('.initial-content').hide();
					$('.search-content').append(data);
					if (data === '') {
						$('.callback-msg').show();
					} else {
						$('.callback-msg').hide();
					}
				}
			});


		});
	});
</script>
<script>
$(document).ready(function() {
    $('#search_toggle').on('click', function(event) {
		event.preventDefault();
		$('.large-advance-search').slideToggle();
    });
});
</script>
<?php get_footer(); ?>