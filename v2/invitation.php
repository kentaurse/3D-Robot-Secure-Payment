<?php
/* 
Template Name: Invitation 
*/  
get_header();


if(isset($_GET['invitation-status']) & !empty($_GET['invitation-status']) & ($_GET['invitation-status'] == 'success')){ ?>
<style>
.hamburger-menu{
  display: none;
}
.p-header__welcart-nav {
  display: none;
}
.p-header__logo{
pointer-events:none;
}

</style>
<div class="container">
  <div class="d-flex justify-content-md-center align-items-center" style="height: 80vh!important">
    <div>
      <div class="card text-center" style="border: 0">
        <div class="card-body">
          <h5 class="card-title" style="font-size: 23px;
            font-weight: 600;">ご回答有難うございました。</h5>
            <h5 class="card-title" style="font-size: 23px;
            font-weight: 600;">また、商談のご依頼を受けて頂き有難うございます！</h5>
            <h5 class="card-title" style="font-size: 23px;
            font-weight: 600;">先方から直接ご連絡が入りますので、ご対応のほどよろしくお願いいたします。</h5>

          <hr>
          <a href="about:blank" target="" class="btn btn-primary">閉じる</a>
        </div>
      </div>
    </div>
  </div>
</div>
<?php 
}else{ ?>
<?php
date_default_timezone_set('Asia/Tokyo');
global $seconddb;
$order_id = $_GET['order'];
$target_company = $_GET['com'];

// link pram valid
if(isset($_GET['access']) & !empty($_GET['access']) & isset($_GET['order']) & !empty($_GET['order']) & isset($_GET['com']) & !empty($_GET['com'])){
    $tkn = $seconddb->get_var("SELECT url_token FROM orders WHERE id='$order_id'");
    $tkn = json_decode($tkn);
    $tokenIsValid = false;
    for ($i = 0; $i < count($tkn); $i++){
        if($tkn[$i]->url_token == $_GET['access'] && $tkn[$i]->company_id == $target_company){
            $curr_date = date('Y-m-d H:i:s', time());
            $exp_date = date('Y-m-d H:i:s', strtotime($tkn[$i]->created_at. ' + 7 days'));     
            if($curr_date <= $exp_date){
                
                $approval = $seconddb->get_var("SELECT vendor_approval FROM orders WHERE id='$order_id'");
                $decode_approval = json_decode($approval);
                foreach($decode_approval as $each_approval){
                    if($each_approval->company_id == $tkn[$i]->company_id && $each_approval->status == 'Pending'){
                        $tokenIsValid = true;
                        break;
                    }
                }
            }
        }
    }

    if(!$tokenIsValid){
        header("Location: /company-invitation-post-handle/?order={$_GET['order']}&com={$_GET['com']}");
    }

    $fetch_order_info_once = $seconddb->get_results( "SELECT * FROM orders WHERE id='$order_id'");
    $json_dcd_vendor = json_decode($fetch_order_info_once[0]->vendors_info);
    $json_dcd_product = json_decode($fetch_order_info_once[0]->product_info);
    $json_dcd_hopes = json_decode($fetch_order_info_once[0]->hopes);

    $seller_id = $fetch_order_info_once[0]->seller_id;

    $company_charge = 0.00;
    $company_name = '';
    $company_addreas = '';
    $company_homepage = '';
    for($i = 0; $i < count($json_dcd_vendor); $i++){
        if($json_dcd_vendor[$i]->company_id == $target_company){
            $company_charge_ = $seconddb->get_var("SELECT paycost FROM userlist WHERE userid = " .$json_dcd_vendor[$i]->company_id);
            $company_charge_ = str_replace( ',', '', $company_charge_);
            $company_charge += $company_charge_;
            $company_name = $json_dcd_vendor[$i]->company_name;
            $company_addreas = $json_dcd_vendor[$i]->address;
            $company_homepage = $json_dcd_vendor[$i]->company_homepage;
        }
    }

    $product_name = '';
    $product_url = '';
    for($i = 0; $i < count($json_dcd_product); $i++){
        // if($json_dcd_vendor[$i]->company_id == $target_company){
            $product_name = $json_dcd_product[$i]->product_name;
            $product_url = $json_dcd_product[$i]->product_page;
        // }
    }

    $contact_method = '';
    $hope1 = '';
    $hope2 = '';
    $hope3 = '';
    for($i = 0; $i < count($json_dcd_hopes); $i++){
        if($json_dcd_hopes[$i]->company_id == $target_company){
            $contact_method = $json_dcd_hopes[$i]->method;
            $hope1 = $json_dcd_hopes[$i]->hope1;
            $hope2 = $json_dcd_hopes[$i]->hope2;
            $hope3 = $json_dcd_hopes[$i]->hope3;
        }
    }

}

?>

<style>
.p-header__welcart-nav {
  display: none;
}
.hamburger-menu{
  display: none;
}
.p-header__logo{
pointer-events:none;
}

@keyframes flash {
  0%,100% {
	opacity: 1;
  }

  50% {
	opacity: 0;
  }
}
</style>

<div class="container">
  <!-- Modal -->
	<form class="wordpress-ajax-form" method="post" action="<?php echo admin_url('admin-ajax.php'); ?>">
		<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="form-floating">
						<div class="row" style="margin: 1rem;">
							<div class="text-center">
								<div class="row text-center" style="padding: 15px; background-color: black; color: white; border: 1px solid; margin:0">
									<h3>この商談で受け取れる報酬額</h3>
								</div>
								<div class="row text-center" style="padding: 15px; background-color: yellow; border: 1px solid; margin:0">
									<h3 style="font-size:2em; font-style:bold;">
										¥<?php echo number_format($company_charge*0.62) ?>
									</h3>
								</div>
							</div>
						</div>
						<h3 style="text-align: center;font-size: 1.4rem; margin-bottom: 2rem;">報酬を破棄してよろしいでしょうか？</h3>
						<ol style="list-style: decimal;list-style-position: outside;margin: 0 3rem 1rem;line-height: 1.8;color: red;">
							<li> 報酬は申込まなくても、話を聞くのみで受け取れます</li>
							<li> 同じ商材を複数社聞いてもOKです</li>
							<li>断り率が上がると、表示順位が下がりオファーが届きにくくなります</li>
							<li> 現在は検討していなくても情報収集目的でもOKです！</li>
						</ol>
						<div style="margin: 2rem;">
							<label for="dis_reason" style="margin-bottom: 1rem;font-size: 1.1rem;">破棄理由</label>
							<select name="dis_reason" id="dis_reason" class="form-control">
								<option value="">--- 選択してください ---</option>
								<option value="オンライン商談ならOK">オンライン商談ならOK</option>
								<option value="忙しくて時間が作れない">忙しくて時間が作れない</option>
								<option value="今は考えていないため">今は考えていないため</option>
								<option value="今回は遠慮しておきます">その他</option>
							</select>
						</div>
						<div class="modal-footer" style="background-color: white; justify-content:center">
							<input type="hidden" name="action" value="custom_action">
							<input type="hidden" name="order" value="<?php echo $_GET['order']; ?>">
							<input type="hidden" name="com" value="<?php echo $_GET['com']; ?>">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">戻る</button>
							<button type="submit" class="btn btn-primary save-btn" disabled>破棄する</button>
						</div>
					</div>
				</div>
				<div class="row visible" style="margin: 22px; padding: 17px; color: red; background: bisque; font-size: 23px; line-height: 31px; font-family: inherit; display: none">
					<p class="error-handle text-center"></p>
				</div>
			</div>
		</div>
	</form>
	<form class="wordpress-ajax-form2" method="post" action="<?php echo admin_url('admin-ajax.php'); ?>">
		<div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div id="date_change_form" style="margin:2rem 2rem 0">
						<div class="form-floating">
							<h3 style="text-align: center;font-size: 1.4rem; margin-bottom: 2rem;">商談可能な日時をご選択ください</h3>
							<h4 class="control-label" style="font-weight: 600; padding-bottom: 3px">希望商談日<span class="red">(翌週以降)</span></h4>
							<input style="height: auto; padding: 0.5rem;" type="date" class="form-control mb-2" id="hope1_date" name="hope1_date" placeholder="yyyy/mm/dd" min="<?php echo date_i18n('Y-m-d', strtotime('+7 day')); ?>" required>
							<div id="hope1_date_error" style="display:none; padding: 0.5rem; color: blue; background: yellow; border-radius: 5px; margin-bottom: 1rem;  animation: flash 1s linear infinite;"><?php echo date_i18n('Y/m/d', strtotime('+7 day')); ?>以降の日付を選んでください。</div>
							<div class="row">
								<div class="col-6">
									<select name="hope1_time_h" id="hope1_time_h" class="form-select" aria-label="Default select example" required>
										<option value="" disabled selected>時</option>
										<option value="01">01</option>
										<option value="02">02</option>
										<option value="03">03</option>
										<option value="04">04</option>
										<option value="05">05</option>
										<option value="06">06</option>
										<option value="07">07</option>
										<option value="08">08</option>
										<option value="09">09</option>
										<option value="10">10</option>
										<option value="11">11</option>
										<option value="12">12</option>
										<option value="13">13</option>
										<option value="14">14</option>
										<option value="15">15</option>
										<option value="16">16</option>
										<option value="17">17</option>
										<option value="18">18</option>
										<option value="19">19</option>
										<option value="20">20</option>
										<option value="21">21</option>
										<option value="22">22</option>
										<option value="23">23</option>
										<option value="24">24</option>
									</select>
								</div>
								<div class="col-6">
									<select name="hope1_time_min" id="hope1_time_min" class="form-select" aria-label="Default select example" required>
										<option value="" disabled selected>分</option>
										<option value="00">00</option>
										<option value="30">30</option>
									</select>
								</div>
							</div>
							<br>
							<h4 class="control-label" style="font-weight: 600; padding-bottom: 3px">第2希望<span class="red">(翌々週以降)</span></h4>
							<p>
								<input type="date" class="form-control mb-2" id="hope2_date" name="hope2_date" placeholder="yyyy/mm/dd" min="<?php echo date_i18n('Y-m-d', strtotime('+14 days')); ?>" required>
							<div id="hope2_date_error" style="display:none; padding: 0.5rem; color: blue; background: yellow; border-radius: 5px; margin-bottom: 1rem;  animation: flash 1s linear infinite;"><?php echo date_i18n('Y/m/d', strtotime('+14 day')); ?>以降の日付を選んでください。</div>
							<div class="row">
								<div class="col-6">
									<select name="hope2_time_h" id="hope2_time_h" class="form-select" aria-label="Default select example" required>
										<option value="" disabled selected>時</option>
										<option value="01">01</option>
										<option value="02">02</option>
										<option value="03">03</option>
										<option value="04">04</option>
										<option value="05">05</option>
										<option value="06">06</option>
										<option value="07">07</option>
										<option value="08">08</option>
										<option value="09">09</option>
										<option value="10">10</option>
										<option value="11">11</option>
										<option value="12">12</option>
										<option value="13">13</option>
										<option value="14">14</option>
										<option value="15">15</option>
										<option value="16">16</option>
										<option value="17">17</option>
										<option value="18">18</option>
										<option value="19">19</option>
										<option value="20">20</option>
										<option value="21">21</option>
										<option value="22">22</option>
										<option value="23">23</option>
										<option value="24">24</option>
									</select>
								</div>
								<div class="col-6">
									<select name="hope2_time_min" id="hope2_time_min" class="form-select" aria-label="select" required>
										<option value="" disabled selected>分</option>
										<option value="00">00</option>
										<option value="30">30</option>
									</select>
								</div>
							</div>
							<div class="modal-footer" style="justify-content:center; border:none;">
							<input type="hidden" name="action" value="reject_for_other_date">
								<input type="hidden" name="order" value="<?php echo $_GET['order']; ?>">
								<input type="hidden" name="com" value="<?php echo $_GET['com']; ?>">
								<input type="hidden" name="hope1" id="hope1" value="">
								<input type="hidden" name="hope2" id="hope2" value="">
								<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">戻る</button>
								<button type="submit" class="btn btn-primary save-btn save-btn2" disabled>送る</button>
							</div>
						</div>
						<div class="row visible" style="0 0 2rem; padding: 17px; color: red; background: bisque; font-size: 23px; line-height: 31px; font-family: inherit; display: none">
							<p class="error-handle text-center"></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>

  <div class="row">
    <div class="text-center">
    <br><br><br><br><br><br><br>
      <div class="row text-center" style="padding: 15px; background-color: black; color: white; border: 1px solid">
        <h3>この商談で受け取れる報酬額</h3>
      </div>
      <div class="row text-center" style="padding: 15px; background-color: yellow; border: 1px solid">
        <h3 style="font-size:2em; font-style:bold;">
          ¥<?php echo number_format($company_charge*0.62) ?>
        </h3>
      </div>
    </div>
  </div>

  <p class="red" style="padding: 20px; text-align: end;"> ※報酬は1回商談するのみで受け取れます！　<br>申し込む申し込まないは関係ありません。</p>
  <br>
  <p class="text-primary" style="padding: 20px; text-align: center;"> <img src="https://ec-apo.com/img/point1.png" width="90%"><br><br><br><img src="https://ec-apo.com/img/point2.png" width="90%"></p>
  <br>
  <p class="text-primary" style="padding: 20px; text-align: center; font-size: 21px;"> 下記会社が商談を希望しています</p>
  <br>

  <div class="side_fo" style="padding: 20px 0 20px 0;position:relative;">
  <img src="<?php $partnerurl = $seconddb->get_var("SELECT partnerurl FROM vendor WHERE email='$seller_id'"); echo $partnerurl; ?>" style="position:absolute;right:-3%;top:-12%;width:20%;">
    <div class="row">
      <div class="col-6" style="padding: 10px; background-color: black; color: white; border: 1px solid">
        <P class="text-center">商談希望会社</P>
      </div>
      <div class="col-6" style="padding: 10px; background-color: ; color: ; border: 1px solid">
      <?php $seller_company = $seconddb->get_var("SELECT company_name FROM vendor WHERE email='$seller_id'"); echo $seller_company; ?>
      </div>
    </div>
    <div class="row">
      <div class="col-6" style="padding: 10px; background-color: black; color: white; border: 1px solid">
        <P class="text-center">住所</P>
      </div>
      <div class="col-6" style="padding: 10px; background-color: ; color: ; border: 1px solid">
      <?php $seller_addr = $seconddb->get_var("SELECT company_address FROM vendor WHERE email='$seller_id'"); echo $seller_addr; ?>
      </div>
    </div>
    <div class="row">
      <div class="col-6" style="padding: 10px; background-color: black; color: white; border: 1px solid">
        <P class="text-center">ホームページ</P>
      </div>
      <div class="col-6" style="padding: 10px; background-color: ; color: ; border: 1px solid">
      <a href="<?php $seller_home_page = $seconddb->get_var("SELECT company_url FROM vendor WHERE email='$seller_id'"); echo $seller_home_page; ?>" target="_blank">
      <?php $seller_home_page = $seconddb->get_var("SELECT company_url FROM vendor WHERE email='$seller_id'"); echo $seller_home_page; ?>
      </a>
      </div>
    </div>
    <div class="row">
      <div class="col-6" style="padding: 10px; background-color: black; color: white; border: 1px solid">
        <P class="text-center">提案したい商材</P>
      </div>
      <div class="col-6" style="padding: 10px; background-color: ; color: ; border: 1px solid">
        <p><?php echo $product_name; ?></p>
      </div>
    </div>
    <div class="row">
      <div class="col-6" style="padding: 10px; background-color: black; color: white; border: 1px solid">
        <P class="text-center">商材URL</P>
      </div>
      <div class="col-6" style="padding: 10px; background-color: ; color: ; border: 1px solid">
        <a href="<?php echo $product_url; ?>" target="_blank"><?php echo $product_url; ?></a>
      </div>
    </div>
    <div class="row">
      <div class="col-6" style="padding: 10px; background-color: black; color: white; border: 1px solid">
        <P class="text-center">担当者名</P>
      </div>
      <div class="col-6" style="padding: 10px; background-color: ; color: ; border: 1px solid">
        <p>
          <?php $seller_name = $seconddb->get_var("SELECT title_name FROM vendor WHERE email='$seller_id'"); echo $seller_name; ?>
        </p>
      </div>
    </div>
  </div>

  <p class="text-primary" style="padding: 20px; text-align: end"> ※弊社では商材の審査は行っておりません。ご自身でご判断ください。</p>

  <div class="side_fo" style="padding: 20px 0 20px 0">
    <div class="row">
      <div class="col-6" style="padding: 10px; background-color: black; color: white; border: 1px solid">
        <P class="text-center" style="padding: 51px">商談方法</P>
      </div>
      <div class="col-6" style="padding: 10px; background-color: ; color: ; border: 1px solid">
        <P class="text-center" style="padding: 20px"><?php echo $contact_method; ?></p>

        <?php
        if($contact_method == 'オンライン商談'){ ?>
            <P class="text-center" style="padding: 2px">※スマホ商談はNGです。</p>
            <P class="text-center" style="padding: 2px"> ※カメラをONにする必要があります</P>
       <?php }
        ?>
        
      </div>
    </div>
    <div class="row">
      <div class="col-6" style="padding: 10px; background-color: black; color: white; border: 1px solid">
        <P class="text-center" style="padding: 20px">候補日</P>
      </div>
      <div class="col-6" style="padding: 10px; background-color: ; color: ; border: 1px solid">
        <P style="padding: 2px">第1希望日時： <?php echo $hope1; ?></P>
        <P style="padding: 2px">第2希望日時： <?php echo $hope2; ?></P>
        <P style="padding: 2px">第3希望日時： <?php echo $hope3; ?></P>
      </div>
    </div>
  </div>

  <p class="text-primary text-end" style="padding: 20px"> ※回答段階で候補日が3つとも過ぎている場合は回答は出来かねます。</p>

  <div class="confirmation" style="padding: 30px">
    <div class="row">
      <div class="col text-center" style="margin-left: auto; margin-right: auto;margin-top:10px; margin-bottom:10px;">
        <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#exampleModal" style="font-size: 13px; height: 3.5rem; padding: 0 1rem;">商談せずに<br>報酬を破棄する</button>
		<button class="btn btn-primary" type="button" style="font-size: 20px;margin-top:10px; margin-bottom:10px; height: 3.5rem; padding: 0 1rem;" data-bs-toggle="modal" data-bs-target="#exampleModal2">別日程で希望</button>
        <button class="btn btn-primary" id="accept-offer-btn" style="font-size: 15px;margin-top:10px; margin-bottom:10px; height: 3.5rem; padding: 0 1rem;">商談して<br>報酬を受け取る</button>
      </div>
    </div>
  </div>
</div>
<style>
a {
  color: blue;
}

a:hover {
  color: black;
}
</style>
<section id="accept_offer" style="display: none; padding-top: 150px; padding-bottom: 150px">
  <div class="container">
    <div class="" style="display: flex;
    justify-content: center;">
      <div class="col-sm-12 col-md-8 col-lg-8">


        <?php
        if($contact_method == 'オンライン商談'){ ?>
        <form class="online_agreement_form" method="post" action="<?php echo admin_url('admin-ajax.php'); ?>">
          <div class="online">
            <div class="radio">
              <P style="padding-bottom: 11px;
    font-weight: 600;">商談日時をお選びください</P>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="hope" id="hope1" value="<?php echo $hope1; ?>"
                  checked>
                <label class="form-check-label" for="flexRadioDefault1">
                  <?php echo $hope1; ?>
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="hope" id="hope1" value="<?php echo $hope2; ?>">
                <label class="form-check-label" for="flexRadioDefault2">
                  <?php echo $hope2; ?>
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="hope" id="hope1" value="<?php echo $hope3; ?>">
                <label class="form-check-label" for="flexRadioDefault2">
                  <?php echo $hope3; ?>
                </label>
              </div>
            </div>
<br>

            <P style="padding-bottom: 11px;
    font-weight: 600;">オンライン商談用URLの受取メールアドレス</P>
            <small>※パソコンでのアクセス必須のため、パソコンで確認できるアドレスをご入力下さい。
              ※先方から直接オンライン商談URLが届きます。</small>
            <div class="input-group mb-3">
              <input type="text" name="contact_url" id="contact_url" class="form-control" aria-label="" required>
            </div>

            <P style="padding-bottom: 11px;
    font-weight: 600;">先方からのご挨拶、当日のご連絡先電話番号</P>
            <div class="input-group mb-3">
              <input type="text" name="contact_tel" id="contact_tel" class="form-control" aria-label="" required>
            </div>

            <P style="padding-bottom: 11px;
    font-weight: 600;">お名前</P>
            <div class="input-group mb-3">
              <input type="text" name="contact_name" id="contact_name" class="form-control" aria-label="" required>
            </div>


            <div class="agreement" style="line-height: 21px;">
              <P style="padding-bottom: 11px;
    font-weight: 600;">ご自身の役職</P>
              <select class="form-select" aria-label="Default select example" name="c_person_position" id="job_position"
                required>
                <option value="選択して下さい">選択して下さい</option>
                <option value="代表取締役(法人格)">代表取締役(法人格)</option>
                <option value="取締役(法人格)">取締役(法人格)</option>
                <option value="代表社員(合同会社)">代表社員(合同会社)</option>
                <option value="代表/オーナー(個人事業主)">代表/オーナー(個人事業主)</option>
                <option value="上記以外(商談できません)">上記以外(商談できません)</option>
              </select>

              <p class="text-primary" style="padding: 20px; text-align: center; font-size: 21px; font-weight: 600"> 下記内容に該当した場合、報酬対象外となります。</p>
              <ul>
		 			<li>1.WEB商談をパソコンではなくスマートフォンで対応した場合</li>
					<li>2.カメラをOFFにしたままで、先方が本人と確認できなかった場合</li>
					<li>3.ご本人様以外が商談に応じた場合(例外なく)</li>
					<li>4.役職が虚偽であった場合</li>
					<li>5.商談を45分以内で終えた場合(商談を実施しなかった場合含む)</li>
					<li>6.サービスに全く興味がなく報酬目的のみと先方に伝えた場合</li>
					<li>7.営業を受けるのではなく、自社サービスの営業提案を行った場合</li>
					<li>8.その他、サイト掲載規約、サイト利用規約内で報酬対象外と定められている行為を行った場合</li>
					<li>9.上記内容で、営業会社から申告が入った場合は、報酬は一旦保留となります</li>
              </ul>
              <br>
              <br>

              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="all_check">
                <label class="form-check-label" for="defaultCheck1">
                  全て確認しました
                </label>
              </div>


              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="privary_check">
                <label class="form-check-label" for="defaultCheck1">
                  <a href="https://ec-apo.com/privacy.php" target="_blank">個人情報保護方針</a>、<a
                    href="https://ec-apo.com/publish.php" target="_blank">サイト掲載規約</a>に同意します。
                </label>
              </div>

              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="terrcheck">
                <label class="form-check-label" for="defaultCheck1">
                  申し込みに関しては自身の責任で判断します。
                </label>
              </div>
              <small>(弊社は商材の審査は行っておりません。) </small>
            </div>

            <div class="confirmation" style="padding: 30px">
              <div class="row">
                <div class="col text-center" style="margin-left: auto; margin-right: auto">
                  <input type="hidden" name="action" value="<?php echo (isset($_GET['p']) && $_GET['p'] == "rp") ? 'online_agreement_submit_rp' : 'online_agreement_submit'?>">
                  <input type="hidden" name="order" value="<?php echo $_GET['order']; ?>">
                  <input type="hidden" name="com" value="<?php echo $_GET['com']; ?>">
                  <button class="btn btn-primary" id="agree_and_preceed" disabled>回答する</button>
                </div>
              </div>
            </div>

          </div>
        </form>
        <?php }else{ ?>
        <form class="online_agreement_form" method="post" action="<?php echo admin_url('admin-ajax.php'); ?>">
          <div class="ofline">
            <div class="radio">
              <P style="padding-bottom: 11px;
    font-weight: 600;">商談日時をお選びください</P>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="hope" id="flexRadioDefault1"
                  value="<?php echo $hope1; ?>" checked>
                <label class="form-check-label" for="flexRadioDefault1">
                  <?php echo $hope1; ?>
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="hope" id="flexRadioDefault2"
                  value="<?php echo $hope2; ?>">
                <label class="form-check-label" for="flexRadioDefault2">
                  <?php echo $hope2; ?>
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="hope" id="flexRadioDefault2"
                  value="<?php echo $hope3; ?>">
                <label class="form-check-label" for="flexRadioDefault2">
                  <?php echo $hope3; ?>
                </label>
              </div>
            </div>
            <br>

            <P style="padding-bottom: 11px;
    font-weight: 600;">対面商談のご住所</P>
            <div class="input-group mb-3">
              <input type="text" name="f2fAddr" class="form-control" aria-label="" required>
            </div>

            <P style="padding-bottom: 11px;
    font-weight: 600;">対面商談の場所がお店の場合、URLがあればご入力ください</P>
            <div class="input-group mb-3">
              <input type="text" name="place_url" class="form-control" aria-label="">
            </div>

            <P style="padding-bottom: 11px;
    font-weight: 600;">先方からのご挨拶、当日のご連絡先電話番号</P>
            <div class="input-group mb-3">
              <input type="text" name="tel" class="form-control" aria-label="" required>
            </div>

			  <P style="padding-bottom: 11px;　font-weight: 600;">メールアドレス</P>
			  <div class="input-group mb-3">
				  <input type="email" name="contact_email" class="form-control" aria-label="" required>
			  </div>

            <P style="padding-bottom: 11px;
    font-weight: 600;">お名前</P>
            <div class="input-group mb-3">
              <input type="text" name="contact_name" class="form-control" aria-label="" required>
            </div>


            <div class="agreement" style="line-height: 21px;">
              <P style="padding-bottom: 11px;
    font-weight: 600;">ご自身の役職</P>
              <select class="form-select" aria-label="Default select example" name="c_person_position"
                id="job_position">
                <option value="選択して下さい">選択して下さい</option>
                <option value="代表取締役(法人格)">代表取締役(法人格)</option>
                <option value="取締役(法人格)">取締役(法人格)</option>
                <option value="代表社員(合同会社)">代表社員(合同会社)</option>
                <option value="代表/オーナー(個人事業主)">代表/オーナー(個人事業主)</option>
                <option value="上記以外(商談できません)">上記以外(商談できません)</option>
              </select>

              <p class="text-primary" style="padding: 20px; text-align: center; font-size: 21px; font-weight: 600"> 下記内容に該当した場合、報酬対象外となります。</p>
              <ul>
                <li>1. 名刺交換を行わなかった場合</li>
                <li>2.ご本人様以外が商談に応じた場合(例外なく)</li>
                <li>3.役職が虚偽であった場合</li>
                <li>4.商談を45分以内で終えた場合(商談を実施しなかった場合含む)</li>
                <li>5.営業を受けるのではなく、自社サービスの営業提案を行った場合</li>
                <li>6.サービスに全く興味がなく報酬目的のみと先方に伝えた場合</li>
                <li>7.その他、サイト掲載規約内で報酬対象外と定められている行為を行った場合</li>
                <li>8.上記内容で、営業会社から申告が入った場合は、報酬は一旦保留となります</li>
              </ul>
              <br>
              <br>

              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="all_check">
                <label class="form-check-label" for="defaultCheck1">
                  全て確認しました
                </label>
              </div>

              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="privary_check">
                <label class="form-check-label" for="defaultCheck1">
                  <a target="_blank" href="https://ec-apo.com/privacy.php" target="_blank"
                    class="text-primary">個人情報保護方針</a>、<a href="https://ec-apo.com/publish.php" target="_blank"
                    class="text-primary">サイト掲載規約</a>に同意します。
                </label>
              </div>

              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="terrcheck">
                <label class="form-check-label" for="defaultCheck1">
                  申し込みに関しては自身の責任で判断します。
                </label>
              </div>
              <small>(弊社は商材の審査は行っておりません。) </small>
            </div>

            <div class="confirmation" style="padding: 30px">
              <div class="row">
                <div class="col text-center" style="margin-left: auto; margin-right: auto">
                  <input type="hidden" name="action" value="<?php echo (isset($_GET['p']) && $_GET['p'] == "rp") ? 'offline_agreement_submit_rp' : 'offline_agreement_submit'?>">
                  <input type="hidden" name="order" value="<?php echo $_GET['order']; ?>">
                  <input type="hidden" name="com" value="<?php echo $_GET['com']; ?>">
                  <button class="btn btn-primary" id="agree_and_preceed" disabled>回答する</button>
                </div>
              </div>
            </div>

          </div>
        </form>
        <?php  }
        ?>

      </div>
    </div>
  </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>
<script>
jQuery(document).ready(function($) {
	$("#hope1_date").change(function() {
		var hope1_date = $("#hope1_date").val();
		var today = new Date();
		var today_plus_7 = new Date(today.getFullYear(), today.getMonth(), today.getDate() + 7);
		var hope1_date = new Date(hope1_date);
		if (hope1_date < today_plus_7) {
			$("#hope1_date_error").show();
		} else {
			$("#hope1_date_error").hide();
		}
	});
	$("#hope2_date").change(function() {
		var hope2_date = $("#hope2_date").val();
		var today = new Date();
		var today_plus_14 = new Date(today.getFullYear(), today.getMonth(), today.getDate() + 14);
		var hope2_date = new Date(hope2_date);
		if (hope2_date < today_plus_14) {
			$("#hope2_date_error").show();
		} else {
			$("#hope2_date_error").hide();
		}
	});

	$("#hope1_time_min").change(function() {
		var hope1_time_min = $("#hope1_time_min").val();
		var hope1_time_hour = $("#hope1_time_h").val();
		var hope1_date = $("#hope1_date").val();
		var hope1 = hope1_date + " " + hope1_time_hour + ":" + hope1_time_min;
		$("#hope1").val(hope1);
	});

	$("#hope2_time_min").change(function() {
		var hope2_time_min = $("#hope2_time_min").val();
		var hope2_time_hour = $("#hope2_time_h").val();
		var hope2_date = $("#hope2_date").val();
		var hope2 = hope2_date + " " + hope2_time_hour + ":" + hope2_time_min;
		$("#hope2").val(hope2);
	});
	

	$(".wordpress-ajax-form2").on('change', function() {
		var hope1_date = $("#hope1_date").val();
		var hope2_date = $("#hope2_date").val();
		var today = new Date();
		var today_plus_7 = new Date(today.getFullYear(), today.getMonth(), today.getDate() + 7);
		var today_plus_14 = new Date(today.getFullYear(), today.getMonth(), today.getDate() + 14);
		var hope1_date = new Date(hope1_date);
		var hope2_date = new Date(hope2_date);

		if($("#hope1_date").val() != "" && $("#hope1_time_h").val() != "" && $("#hope1_time_min").val() != "" && $("#hope2_date").val() != "" && $("#hope2_time_hour").val() != "" && $("#hope2_time_min").val() != "" && hope1_date >= today_plus_7 && hope2_date >= today_plus_14) {
			$(".save-btn2").prop("disabled", false);
		} else {
			$(".save-btn2").prop("disabled", true);
		}
	});

	$(".wordpress-ajax-form").on('change', function() {
		if ($("#dis_reason").val() != "") {
			$(".save-btn").prop("disabled", false);
		} else {
			$(".save-btn").prop("disabled", true);
		}
	});

	$('.wordpress-ajax-form2').on('submit', function(e) {
		$(".save-btn2").prop("disabled", true);
		e.preventDefault();

		var $form = $(this);

		$.post($form.attr('action'), $form.serialize(), function(data) {
			if (data.status == 'Success') {
				$(".visible").fadeIn();
				$(".form-floating").hide();
				$(".error-handle").html(
					"日程のご提案、有難うございました。<br>先方が都合つく様であれば、先ほどの日程でオファーが届きますので、商談成立の手続きをお願い致します。"
				);
				$("#accept-offer-btn").hide();
			} else {
				$(".save-btn2").prop("disabled", false);
				$(".visible").fadeIn();
				$(".error-handle").html("日付を設定してください。");
			}
		}, 'json');
	});

  $('.wordpress-ajax-form').on('submit', function(e) {
    $(".save-btn").prop("disabled", true);
    e.preventDefault();

    var $form = $(this);

    $.post($form.attr('action'), $form.serialize(), function(data) {
      if (data.status == 'Success') {
        $(".visible").fadeIn();
        $(".form-floating").hide();
        $(".error-handle").html(
          "ご回答有難うございました。<br>今回は先方にお断りのご連絡をいれさせて頂きます。<br>また次回、何卒お願い申し上げます。"
        );
        $("#accept-offer-btn").hide();
      } else {
        $(".save-btn").prop("disabled", false);
        $(".visible").fadeIn();
        $(".error-handle").html(
          "商談のお断りの理由を記入して、再度送信してください。");
      }
    }, 'json');
  });

});
</script>

<script>
jQuery(document).ready(function($) {

  $('#accept-offer-btn').click(function(e) {
    $("#accept-offer-btn").prop("disabled", true);
    $("#accept_offer").show();
    $('html, body').animate({
      scrollTop: $("#accept_offer").offset().top
    }, 500);
  });

});
</script>

<script>
jQuery(document).ready(function($) {
  $("#terrcheck,#privary_check,#all_check,#job_position").change(function() {
    if (($('#privary_check').is(':checked') && $('#job_position option:selected') && $('#terrcheck').is(
        ':checked') && $('#all_check').is(':checked')) && $('#job_position option:selected').text() !== '選択して下さい' && $('#job_position option:selected').text() !== '上記以外(商談できません)') {
      $("#agree_and_preceed").prop("disabled", false);
    } else {
      $("#agree_and_preceed").prop("disabled", true);
    }
  });

  $('.online_agreement_form').on('submit', function(e) {
    $("#agree_and_preceed").prop("disabled", true);
    e.preventDefault();

    var $form = $(this);

    $.post($form.attr('action'), $form.serialize(), function(data) {
      if (data.status == 'Success') {
        window.location = '/company-invitation/?invitation-status=success';
      } else {
        alert("Something went wrong!");
      }
    }, 'json');

  });
});
</script>

<?php } ?>