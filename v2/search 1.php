<?php
/*
Template Name: Search
 */
get_header();
$talkpref = $_POST['talkpref'];
$position = $_POST['position'];
$company = $_POST['company'];
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
		.mobile-advance-search {
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

	<?php

//データベース接続
$server = "mysql14.onamae.ne.jp";
$userName = "2m5l9_ecapo";
$password = "sh0-s19y^1Sa";
$dbName = "2m5l9_ecapo";

$mysqli = new mysqli($server, $userName, $password, $dbName);

if ($mysqli->connect_error) {
    exit();
} else {
    $mysqli->set_charset("utf-8");
}

$sql = "SELECT * FROM userlist WHERE company LIKE '%$company%' AND listflag = 'on' AND urlimgcheck = '3' ORDER BY RAND()";

$result = $mysqli->query($sql);

//クエリー失敗
if (!$result) {
    exit();
}

//レコード件数
$row_count = $result->num_rows;

//連想配列で取得
while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
    $rows[] = $row;
}

//結果セットを解放
$result->free();

// データベース切断
$mysqli->close();

?>

	<div class="row">
		<div class="col-sm-12 col-md-3 col-lg-3" style="padding: 30px">

			<div class="large-advance-search">
				<form class="advance-search" method="post" action="<?php echo admin_url('admin-ajax.php'); ?>">
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
					</div>
					<div class="row text-center">
						<div class="col">
							<input type="hidden" name="company" id="company" value="<?php echo $company; ?>">
							<input type="hidden" name="advance_search" id="advance_search" value="advance_search">
							<button type="submit" class="btn btn-primary adv-search-btn">条件を絞り込む</button>
						</div>
					</div>
				</form>
			</div>

			<div class="mobile-advance-search">

				<p>
					<button class="btn btn-primary" style="width: 100%" type="button" data-bs-toggle="collapse"
						data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
						条件を絞り込む
					</button>
				</p>
				<div class="collapse" id="collapseExample">
					<div class="card card-body">
						<form class="advance-search" method="post" action="<?php echo admin_url('admin-ajax.php'); ?>">
							<div class="form-group">
								<label for="formGroupExampleInput"><strong>種別</strong></label><br>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="checkbox" name="co_type" id="co_type"
										value="法人">
									<label class="form-check-label" for="exampleRadios1">
										法人
									</label>
								</div>

								<div class="form-check form-check-inline">
									<input class="form-check-input" type="checkbox" name="co_type" id="co_type"
										value="個人事業主">
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
							</div>
							<div class="row text-center">
								<div class="col">
									<input type="hidden" name="company" id="company" value="<?php echo $company; ?>">
									<input type="hidden" name="advance_search" id="advance_search"
										value="advance_search">
									<button type="submit" class="btn btn-primary adv-search-btn">条件を絞り込む</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>

		</div>
		<div class="col-sm-12 col-md-9 col-lg-9">
			<div class="row callback-msg text-center" style="padding: 25px; display: none">
				<h1 class="text-center">該当企業がありません。<br>登録企業は順次増えておりますのでお待ちくださいませ。</h1>
			</div>
			<div class="row search-content" style="padding: 25px"></div>
			<div class="row initial-content" style="padding: 25px">

				<?php
foreach ((array) $rows as $row) {
    ?>
				<div class="col-sm-12 col-md-4 col-lg-4" style="padding: 20px">
					<article class="p-blog-archive__item" style="width: 100%">
						<a class="p-hover-effect--type1"
							href="/company?userid=<?php echo htmlspecialchars($row['userid'], ENT_QUOTES, 'UTF-8'); ?>"
							target="_blank">
							<div class="p-blog-archive__item-thumbnail p-hover-effect__image js-object-fit-cover">
								<?php if ($row['urlimgcheck'] == '3'): ?>
								<img src="https://s.wordpress.com/mshots/v1/<?php echo htmlspecialchars($row['homepage'], ENT_QUOTES, 'UTF-8'); ?>"
									alt="" width="740" height="460" class="attachment-size3 size-size3 wp-post-image" />
								<?php elseif ($row['urlimgcheck'] == '1'): ?>
								<img src="https://ec-apo.com/url/<?php echo htmlspecialchars($row['userid'], ENT_QUOTES, 'UTF-8'); ?>.png"
									width="740" height="460" class="attachment-size3 size-size3 wp-post-image" />
								<?php else: ?>
								<img src="https://ec-apo.com/img/nowprinting.png" width="740" height="460"
									class="attachment-size3 size-size3 wp-post-image" />
								<?php endif;?>
							</div>
							<div class="linktext">
								<?php echo htmlspecialchars($row['company'], ENT_QUOTES, 'UTF-8'); ?><br>
								<?php echo htmlspecialchars($row['pref'], ENT_QUOTES, 'UTF-8'); ?><?php echo htmlspecialchars($row['city'], ENT_QUOTES, 'UTF-8'); ?><?php echo htmlspecialchars($row['addr'], ENT_QUOTES, 'UTF-8'); ?><br>
								商談相手：<?php echo htmlspecialchars($row['position'], ENT_QUOTES, 'UTF-8'); ?><br>
								項目充実度：<span
									class="star"><?php echo htmlspecialchars($row['star'], ENT_QUOTES, 'UTF-8'); ?></span><br>
								業種：<?php echo htmlspecialchars($row['jobs'], ENT_QUOTES, 'UTF-8'); ?>　<?php echo htmlspecialchars($row['jobs2'], ENT_QUOTES, 'UTF-8'); ?>　<?php echo htmlspecialchars($row['jobs3'], ENT_QUOTES, 'UTF-8'); ?>　<?php echo htmlspecialchars($row['jobs4'], ENT_QUOTES, 'UTF-8'); ?><br>
								商談設定金額：<span
									class="red">¥<?php echo htmlspecialchars($row['paycost'], ENT_QUOTES, 'UTF-8'); ?></span><br>
							</div>
						</a>
					</article>
				</div>
				<?php
}
?>




<?php
$server = "mysql14.onamae.ne.jp";
$userName = "2m5l9_ecapo";
$password = "sh0-s19y^1Sa";
$dbName = "2m5l9_ecapo";

$mysqli = new mysqli($server, $userName, $password, $dbName);

if ($mysqli->connect_error) {
    exit();
} else {
    $mysqli->set_charset("utf-8");
}

$sql2 = "SELECT * FROM userlist WHERE company LIKE '%$company%' AND listflag = 'on' AND urlimgcheck = '1' ORDER BY RAND()";

$result2 = $mysqli->query($sql2);

if (!$result2) {
    exit();
}

$row_count = $result2->num_rows;

while ($row2 = $result2->fetch_array(MYSQLI_ASSOC)) {
    $rows2[] = $row2;
}

$result2->free();
$mysqli->close();

?>


				<?php
foreach ((array) $rows2 as $row2) {
    ?>
				<div class="col-sm-12 col-md-4 col-lg-4" style="padding: 20px">
					<article class="p-blog-archive__item" style="width: 100%">
						<a class="p-hover-effect--type1"
							href="/company?userid=<?php echo htmlspecialchars($row2['userid'], ENT_QUOTES, 'UTF-8'); ?>"
							target="_blank">
							<div class="p-blog-archive__item-thumbnail p-hover-effect__image js-object-fit-cover">
								<?php if ($row2['urlimgcheck'] == '3'): ?>
								<img src="https://s.wordpress.com/mshots/v1/<?php echo htmlspecialchars($row2['homepage'], ENT_QUOTES, 'UTF-8'); ?>"
									alt="" width="740" height="460" class="attachment-size3 size-size3 wp-post-image" />
								<?php elseif ($row2['urlimgcheck'] == '1'): ?>
								<img src="https://ec-apo.com/url/<?php echo htmlspecialchars($row2['userid'], ENT_QUOTES, 'UTF-8'); ?>.png"
									width="740" height="460" class="attachment-size3 size-size3 wp-post-image" />
								<?php else: ?>
								<img src="https://ec-apo.com/img/nowprinting.png" width="740" height="460"
									class="attachment-size3 size-size3 wp-post-image" />
								<?php endif;?>
							</div>
							<div class="linktext">
								<?php echo htmlspecialchars($row2['company'], ENT_QUOTES, 'UTF-8'); ?><br>
								<?php echo htmlspecialchars($row2['pref'], ENT_QUOTES, 'UTF-8'); ?><?php echo htmlspecialchars($row2['city'], ENT_QUOTES, 'UTF-8'); ?><?php echo htmlspecialchars($row2['addr'], ENT_QUOTES, 'UTF-8'); ?><br>
								商談相手：<?php echo htmlspecialchars($row2['position'], ENT_QUOTES, 'UTF-8'); ?><br>
								項目充実度：<span
									class="star"><?php echo htmlspecialchars($row2['star'], ENT_QUOTES, 'UTF-8'); ?></span><br>
								業種：<?php echo htmlspecialchars($row2['jobs'], ENT_QUOTES, 'UTF-8'); ?>　<?php echo htmlspecialchars($row2['jobs2'], ENT_QUOTES, 'UTF-8'); ?>　<?php echo htmlspecialchars($row2['jobs3'], ENT_QUOTES, 'UTF-8'); ?>　<?php echo htmlspecialchars($row2['jobs4'], ENT_QUOTES, 'UTF-8'); ?><br>
								商談設定金額：<span
									class="red">¥<?php echo htmlspecialchars($row2['paycost'], ENT_QUOTES, 'UTF-8'); ?></span><br>
							</div>
						</a>
					</article>
				</div>
				<?php
}
?>



<?php
$server = "mysql14.onamae.ne.jp";
$userName = "2m5l9_ecapo";
$password = "sh0-s19y^1Sa";
$dbName = "2m5l9_ecapo";

$mysqli = new mysqli($server, $userName, $password, $dbName);

if ($mysqli->connect_error) {
    exit();
} else {
    $mysqli->set_charset("utf-8");
}

$sql3 = "SELECT * FROM userlist WHERE company LIKE '%$company%' AND listflag = 'on' AND urlimgcheck = '2' ORDER BY RAND()";

$result3 = $mysqli->query($sql3);

if (!$result3) {
    exit();
}

$row_count = $result3->num_rows;

while ($row3 = $result2->fetch_array(MYSQLI_ASSOC)) {
    $rows3[] = $row3;
}

$result3->free();
$mysqli->close();

?>


				<?php
foreach ((array) $row3 as $row3) {
    ?>
				<div class="col-sm-12 col-md-4 col-lg-4" style="padding: 20px">
					<article class="p-blog-archive__item" style="width: 100%">
						<a class="p-hover-effect--type1"
							href="/company?userid=<?php echo htmlspecialchars($row3['userid'], ENT_QUOTES, 'UTF-8'); ?>"
							target="_blank">
							<div class="p-blog-archive__item-thumbnail p-hover-effect__image js-object-fit-cover">
								<?php if ($row3['urlimgcheck'] == '3'): ?>
								<img src="https://s.wordpress.com/mshots/v1/<?php echo htmlspecialchars($row2['homepage'], ENT_QUOTES, 'UTF-8'); ?>"
									alt="" width="740" height="460" class="attachment-size3 size-size3 wp-post-image" />
								<?php elseif ($row3['urlimgcheck'] == '1'): ?>
								<img src="https://ec-apo.com/url/<?php echo htmlspecialchars($row2['userid'], ENT_QUOTES, 'UTF-8'); ?>.png"
									width="740" height="460" class="attachment-size3 size-size3 wp-post-image" />
								<?php else: ?>
								<img src="https://ec-apo.com/img/nowprinting.png" width="740" height="460"
									class="attachment-size3 size-size3 wp-post-image" />
								<?php endif;?>
							</div>
							<div class="linktext">
								<?php echo htmlspecialchars($row3['company'], ENT_QUOTES, 'UTF-8'); ?><br>
								<?php echo htmlspecialchars($row3['pref'], ENT_QUOTES, 'UTF-8'); ?><?php echo htmlspecialchars($row3['city'], ENT_QUOTES, 'UTF-8'); ?><?php echo htmlspecialchars($row3['addr'], ENT_QUOTES, 'UTF-8'); ?><br>
								商談相手：<?php echo htmlspecialchars($row2['position'], ENT_QUOTES, 'UTF-8'); ?><br>
								項目充実度：<span
									class="star"><?php echo htmlspecialchars($row2['star'], ENT_QUOTES, 'UTF-8'); ?></span><br>
								業種：<?php echo htmlspecialchars($row3['jobs'], ENT_QUOTES, 'UTF-8'); ?>　<?php echo htmlspecialchars($row3['jobs2'], ENT_QUOTES, 'UTF-8'); ?>　<?php echo htmlspecialchars($row3['jobs3'], ENT_QUOTES, 'UTF-8'); ?>　<?php echo htmlspecialchars($row3['jobs4'], ENT_QUOTES, 'UTF-8'); ?><br>
								商談設定金額：<span
									class="red">¥<?php echo htmlspecialchars($row3['paycost'], ENT_QUOTES, 'UTF-8'); ?></span><br>
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

			var data = {
				'company': $('#company').val(),
				'co_type': co_type,
				'co_title': co_title,
				'co_capital': co_capital,
				'employees': employees,
				'workers': workers,
			};


			jQuery.ajax({
				url: '<?php echo admin_url('
				admin - ajax.php '); ?>',
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
<?php get_footer();?>