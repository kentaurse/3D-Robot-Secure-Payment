<?php
/*
Template Name: Favorites
*/
$_email = $_SESSION['apo_log_mail'];
global $seconddb;

if (!isset($_SESSION['apo_log_tkn'])) {
	header("Location: /");
}

get_header();

$favorites = $seconddb->get_results("SELECT favorites.company_id, userlist.company, userlist.pref, userlist.jobs FROM favorites INNER JOIN userlist ON favorites.company_id = userlist.userid WHERE seller_id='$_email' AND listflag = 'on'");

?>
<style>
	body {
		font-family: Arial, Helvetica, sans-serif;
	}

	* {
		box-sizing: border-box;
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

	.nav_sec li {
		padding: 10px;
		margin: 5px;
		float: right;
		background-color: white;
	}

	.bg_chip {
		background-color: #f08080;
	}
</style>

<div class="container">
	<div style="padding: 30px">
		<a href="/favorites" class="btn btn-sm btn-primary">お気に入り</a>
		<a href="/appointments" class="btn btn-sm btn-primary">依頼履歴</a>
		<a href="/billing" class="btn btn-sm btn-primary">成立履歴</a><br>
		<p class="text-danger" style="font-size: 12px; margin-top: 1rem;">※掲載企業の都合で掲載が一時的に停止になった場合はお気に入りからも削除されます。<br>掲載があるうちにお早めにオファーをお出しください。</p>
	</div>

	<div style="padding-bottom: 44px;">
		<div class="table-responsive">
			<table class="table table-striped table-warning text-center" style="line-height: 18px">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">会社名</th>
						<th scope="col">都道府県</th>
						<th scope="col">業種</th>
						<th scope="col">オファー</th>
					</tr>
				</thead>
				<tbody>
					<?php
					if (empty($favorites)) {
                        echo "<tr><td colspan='5'>お気に入りに登録されている企業はありません。</td></tr>";
                    }
                    
					$count = 1;
					foreach($favorites as $each_company) {
					?>
					<tr>
						<th scope="row"><?php echo $count++; ?></th>
						<td><?php echo $each_company->company; ?></td>
						<td><?php echo $each_company->pref; ?></td>
						<td><?php echo $each_company->jobs; ?></td>
						<td><a href="/company?userid=<?php echo $each_company->company_id; ?>" class='badge rounded-pill bg-secondary'>詳細</a></td>
					</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>


<?php get_footer(); ?>