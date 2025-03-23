<?php
/* 
Template Name: Checkout 
*/  

$_email = $_SESSION['apo_log_mail'];
global $seconddb;


get_header();

if(!isset($_SESSION['apo_log_tkn'])){

    header("Location: /login/?action=must_login");

}

if(isset($_SESSION['ec_apo_payment_success']) && $_SESSION['ec_apo_payment_success'] == true){
  header("Location: /checkout/?status=success");
}

if(isset($_GET['remove-item']) & !empty($_GET['remove-item']) ){
    foreach($_SESSION['ec_apo_cart'] as $k => $v) {
        if($v['id'] == $_GET['remove-item'])
          unset($_SESSION['ec_apo_cart'][$k]);

          header("Location: /checkout");
      }
}

if(isset($_GET['edit-item-update']) & !empty($_GET['edit-item-update']) ){
    foreach($_SESSION['ec_apo_cart'] as $k => $v) {
        if($v['id'] == $_GET['edit-item-update']){
            $_SESSION['ec_apo_cart'][$k]['method'] = $_GET['method_update'];
            $_SESSION['ec_apo_cart'][$k]['day1'] = $_GET['hope1_update'];
            $_SESSION['ec_apo_cart'][$k]['day2'] = $_GET['hope2_update'];
            $_SESSION['ec_apo_cart'][$k]['day3'] = $_GET['hope3_update'];
            $_SESSION['ec_apo_cart'][$k]['day1_time'] = $_GET['hope1_h_update'].":".$_GET['hope1_m_update'];
            $_SESSION['ec_apo_cart'][$k]['day2_time'] = $_GET['hope2_h_update'].":".$_GET['hope2_m_update'];
            $_SESSION['ec_apo_cart'][$k]['day3_time'] = $_GET['hope3_h_update'].":".$_GET['hope3_m_update'];
        }
    }
}

  $order_within_3_month = $seconddb->get_var("SELECT order_id FROM orders WHERE seller_id = '$_email' AND created_at >= DATE_SUB(NOW(), INTERVAL 3 MONTH) AND created_at >= '2022-10-25'");
  $has_order_within_3_month = $order_within_3_month ? empty(json_decode($seconddb->get_var("SELECT payee_info FROM billing WHERE billing_order_id = '$order_within_3_month'"))): false;

?>
  
<style>
input {
  border: 0;
  color: inherit;
  font: inherit;
}

input[type="radio"] {
  accent-color: #fc8080;
  accent-color: var(--color-primary);
}

.form__radios {
  display: grid;
  grid-gap: 1em;
  gap: 1em;
}

.form__radio {
  -webkit-box-align: center;
  -ms-flex-align: center;
  align-items: center;
  background-color: #fefdfe;
  border-radius: 1em;
  -webkit-box-shadow: 0 0 1em rgba(0, 0, 0, 0.0625);
  box-shadow: 0 0 1em rgba(0, 0, 0, 0.0625);
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  padding: 1em;
}

.form__radioo {
  -webkit-box-align: center;
  -ms-flex-align: center;
  align-items: center;
  background-color: #fefdfe;
  border-radius: 1em;
  display: -webkit-box;
  display: -ms-flexbox;
  display: block;
  padding: 1em;
}

.form__radio label {
  -webkit-box-align: center;
  -ms-flex-align: center;
  align-items: center;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-flex: 1;
  -ms-flex: 1;
  flex: 1;
  grid-gap: 1em;
  gap: 1em;
}

.icon {
  height: 1em;
  display: inline-block;
  fill: currentColor;
  width: 1em;
  vertical-align: middle;
}
div.linktext{
color: black;
line-height:2em;
}

div.linktext:hover{
color:#e47911;
}

#rp-button-container input[type='button']{
  color: white;
    background: #383aff;
    width: 100%;
    padding: 1rem;
    font-weight: bold;
    border-radius: 10px;
}

#rp-button-container input[type='button']:hover{
  opacity: 0.8;
}

.p-blog-archive{
text-align:center;
}

img{
padding:20px;
}

</style>

<?php
if(isset($_GET['status']) & !empty($_GET['status']) ){
  if($_GET['status'] == 'success'){ ?>
    <div class="container">
    <div class="d-flex justify-content-md-center align-items-center" style="height: 40vh!important">
      <div>
      <div class="card text-center" style="border: 0; font-size: 21px">
      <div class="card-body">
        <h5 class="card-title" style="font-size: 23px;
    font-weight: 600;">商談のご依頼、有難うございました。</h5>
    <h4>先方からの「成立」「非成立」のお返事があるまでお待ち下さい。</h4>
        <p class="card-text" style="line-height: 20px;
    font-weight: 500;
    font-family: sans-serif;">先方から「成立」のお返事があった段階で、ご登録のクレジットカードより自動課金となります。</p>
        <hr>
        <a href="https://ec-apo.com/" class="btn btn-primary" style="font-size: 20px;
    border-radius: 20px;">他の決裁者アポを探す</a>
      </div>
      
      
    </div>
      </div>
      
      
    </div>
    
    </div>
    
  <main class="l-main">
    <div class="l-inner">
      <div class="p-blog-archive">

        

        <center>

<a href="https://lin.ee/2lGhyqq" target="_blank">
	<script type="text/javascript">
		var imglist = new Array(
			"https://ec-apo.com/img/ecv/1.png",
			"https://ec-apo.com/img/ecv/2.png",
			"https://ec-apo.com/img/ecv/3.png",
			"https://ec-apo.com/img/ecv/4.png",
			"https://ec-apo.com/img/ecv/5.png",
			"https://ec-apo.com/img/ecv/6.png",
			"https://ec-apo.com/img/ecv/7.png",
			"https://ec-apo.com/img/ecv/8.png",
			"https://ec-apo.com/img/ecv/9.png",
			"https://ec-apo.com/img/ecv/10.png" );
		var selectnum = Math.floor(Math.random() * imglist.length);
		var output = "<img src=" + imglist[selectnum] + ">";
		document.write(output);
	</script>
</a>



        
    
        </center>

        
      </div>
    </div>
  </main>
    
    
  <?php }
  unset($_SESSION['ec_apo_payment_success']);
}else{ ?>
<div class="container">

  

<div id="post_payment_laoding" style="display: none">
<div class="justify-content-md-center align-items-center vh-50" style="font-size: 40px;
    text-align: center;
    color: #383aff;
    padding-top: 135px;
    padding-bottom: 134px;">
    <img src="https://i.gifer.com/ZZ5H.gif" alt="" width="100" height="100">
    <p>現在決済をしています。<br>そのままお待ちください。</p>
</div>
</div>



  <div class="row">

  <?php if(isset($_SESSION['ec_apo_payment_error'])){ ?>
    <div class="alert alert-danger col-lg-5 col-md-5" role="alert" style="margin: 20px">
      <?php echo $_SESSION['ec_apo_payment_error']; ?>
    </div>
    <?php unset($_SESSION['ec_apo_payment_error']); ?>
  <?php } ?>

    <div class="col-sm-12 col-md-7 col-lg-7">

      <h2 style="padding: 30px 0 30px 0;
    font-size: 19px;color: blue;
    font-weight: 600;">依頼内容をご確認下さい</h2>


      <?php
if(isset($_GET['edit-item']) & !empty($_GET['edit-item']) ){
    foreach($_SESSION['ec_apo_cart'] as $k => $v) {
        if($v['id'] == $_GET['edit-item']){
            ?>
      <div class="container mt-5 mb-5">
        <div class="d-flex justify-content-center row">
          <div class="col-md-6" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;">
            <div style="padding: 10px">
              <form id="cart_edit_update" method="get"
                action="/checkout/?edit-item-update=<?php echo $_GET['edit-item']; ?>">
                
                <div id="price_setting_dialogue">
              <h4 class="control-label">希方法望商談</h4>
              <p>
                <select class="form-control form-control-inline" name="method_update" id="_update">
                  <option value="オンライン商談" <?php if($_SESSION['ec_apo_cart'][$k]['method'] == 'オンライン商談') echo "selected" ?>>オンライン商談</option>
                  <option value="対面商談" <?php if($_SESSION['ec_apo_cart'][$k]['method'] == '対面商談') echo "selected" ?>>対面商談</option>
                </select>
              </p>
              <br>
              <h4 class="control-label">希望商談日第1希望</h4>
              <p>
                <input type="date" class="form-control mb-2" id="inlineFormInput" name="hope1_update" placeholder="yyyy/mm/dd" 
                value="<?php echo $_SESSION['ec_apo_cart'][$k]['day1'] ?>"
                min="<?php
                date_default_timezone_set("Asia/Tokyo");
                $now = time();
                $enc_minutes = $now + (48* 60 * 60);
                $day = date('Y-m-d', $enc_minutes);
                echo $day;
                ?>"
                value="<?php
                date_default_timezone_set("Asia/Tokyo");
                $now = time();
                $enc_minutes = $now + (48* 60 * 60);
                $day = date('Y-m-d', $enc_minutes);
                echo $day;
                ?>" required>
                <div class="row">
                            <?php
                            $h1 = substr($_SESSION['ec_apo_cart'][$k]['day1_time'], 0, 2);
                            $m1 = substr($_SESSION['ec_apo_cart'][$k]['day1_time'], -2);

                            $h2 = substr($_SESSION['ec_apo_cart'][$k]['day2_time'], 0, 2);
                            $m2 = substr($_SESSION['ec_apo_cart'][$k]['day2_time'], -2);

                            $h3 = substr($_SESSION['ec_apo_cart'][$k]['day3_time'], 0, 2);
                            $m3 = substr($_SESSION['ec_apo_cart'][$k]['day3_time'], -2);
                            ?>
                            <div class="col-6">
                              <select name="hope1_h_update" id="hope1_h_update" class="form-select" aria-label="Default select example" required>
                                <option value="">時</option>
                                <option value="01" <?php if($h1 == '01') echo "selected"; ?> >01</option>
                                <option value="02" <?php if($h1 == '02') echo "selected"; ?>>02</option>
                                <option value="03" <?php if($h1 == '03') echo "selected"; ?>>03</option>
                                <option value="04" <?php if($h1 == '04') echo "selected"; ?>>04</option>
                                <option value="05" <?php if($h1 == '05') echo "selected"; ?>>05</option>
                                <option value="06" <?php if($h1 == '06') echo "selected"; ?>>06</option>
                                <option value="07" <?php if($h1 == '07') echo "selected"; ?>>07</option>
                                <option value="08" <?php if($h1 == '08') echo "selected"; ?>>08</option>
                                <option value="09" <?php if($h1 == '09') echo "selected"; ?>>09</option>
                                <option value="10" <?php if($h1 == '10') echo "selected"; ?>>10</option>
                                <option value="11" <?php if($h1 == '11') echo "selected"; ?>>11</option>
                                <option value="12" <?php if($h1 == '12') echo "selected"; ?>>12</option>
                                <option value="13" <?php if($h1 == '13') echo "selected"; ?>>13</option>
                                <option value="14" <?php if($h1 == '14') echo "selected"; ?>>14</option>
                                <option value="15" <?php if($h1 == '15') echo "selected"; ?>>15</option>
                                <option value="16" <?php if($h1 == '16') echo "selected"; ?>>16</option>
                                <option value="17" <?php if($h1 == '17') echo "selected"; ?>>17</option>
                                <option value="18" <?php if($h1 == '18') echo "selected"; ?>>18</option>
                                <option value="19" <?php if($h1 == '19') echo "selected"; ?>>19</option>
                                <option value="20" <?php if($h1 == '20') echo "selected"; ?>>20</option>
                                <option value="21" <?php if($h1 == '21') echo "selected"; ?>>21</option>
                                <option value="22" <?php if($h1 == '22') echo "selected"; ?>>22</option>
                                <option value="23" <?php if($h1 == '23') echo "selected"; ?>>23</option>
                                <option value="24" <?php if($h1 == '24') echo "selected"; ?>>24</option>
                              </select>
                            </div>
                            <div class="col-6">
                              <select name="hope1_m_update" id="hope1_m_update" class="form-select" aria-label="Default select example" required>
                                <option value="">分</option>
                                <option value="00" <?php if($m1 == '00') echo "selected"; ?>>00</option>
                                <option value="30" <?php if($m1 == '30') echo "selected"; ?>>30</option>
                              </select>
                            </div>
                          </div>
                          </p>
                          <br>
                          <h4 class="control-label">第2希望</h4>
                          <p>
                          <input type="date" class="form-control mb-2" id="inlineFormInput" name="hope2_update" placeholder="yyyy/mm/dd"
                value="<?php echo $_SESSION['ec_apo_cart'][$k]['day2'] ?>"
                min="<?php
                date_default_timezone_set("Asia/Tokyo");
                $now = time();
                $enc_minutes = $now + (48* 60 * 60);
                $day = date('Y-m-d', $enc_minutes);
                echo $day;
                ?>"
                >
                <div class="row">
                  <div class="col-6">
                  <select name="hope2_h_update" id="hope2_h_update" class="form-select" aria-label="Default select example">
                    <option value="">時</option>
                    <option value="01" <?php if($h2 == '01') echo "selected"; ?> >01</option>
                                <option value="02" <?php if($h2 == '02') echo "selected"; ?>>02</option>
                                <option value="03" <?php if($h2 == '03') echo "selected"; ?>>03</option>
                                <option value="04" <?php if($h2 == '04') echo "selected"; ?>>04</option>
                                <option value="05" <?php if($h2 == '05') echo "selected"; ?>>05</option>
                                <option value="06" <?php if($h2 == '06') echo "selected"; ?>>06</option>
                                <option value="07" <?php if($h2 == '07') echo "selected"; ?>>07</option>
                                <option value="08" <?php if($h2 == '08') echo "selected"; ?>>08</option>
                                <option value="09" <?php if($h2 == '09') echo "selected"; ?>>09</option>
                                <option value="10" <?php if($h2 == '10') echo "selected"; ?>>10</option>
                                <option value="11" <?php if($h2 == '11') echo "selected"; ?>>11</option>
                                <option value="12" <?php if($h2 == '12') echo "selected"; ?>>12</option>
                                <option value="13" <?php if($h2 == '13') echo "selected"; ?>>13</option>
                                <option value="14" <?php if($h2 == '14') echo "selected"; ?>>14</option>
                                <option value="15" <?php if($h2 == '15') echo "selected"; ?>>15</option>
                                <option value="16" <?php if($h2 == '16') echo "selected"; ?>>16</option>
                                <option value="17" <?php if($h2 == '17') echo "selected"; ?>>17</option>
                                <option value="18" <?php if($h2 == '18') echo "selected"; ?>>18</option>
                                <option value="19" <?php if($h2 == '19') echo "selected"; ?>>19</option>
                                <option value="20" <?php if($h2 == '20') echo "selected"; ?>>20</option>
                                <option value="21" <?php if($h2 == '21') echo "selected"; ?>>21</option>
                                <option value="22" <?php if($h2 == '22') echo "selected"; ?>>22</option>
                                <option value="23" <?php if($h2 == '23') echo "selected"; ?>>23</option>
                                <option value="24" <?php if($h2 == '24') echo "selected"; ?>>24</option>
                              </select>
                            </div>
                            <div class="col-6">
                              <select name="hope2_m_update" id="hope2_m_update" class="form-select" aria-label="select">
                                <option value="">分</option>
                                <option value="00" <?php if($m2 == '00') echo "selected"; ?>>00</option>
                                <option value="30" <?php if($m2 == '30') echo "selected"; ?>>30</option>
                              </select>
                            </div>
                          </div>
                          </p>
                          <br>
                          <h4 class="control-label">第3希望</h4>
                          <p>
                          <input type="date" class="form-control mb-2" id="inlineFormInput" name="hope3_update" placeholder="yyyy/mm/dd"
                value="<?php echo $_SESSION['ec_apo_cart'][$k]['day3'] ?>"
                min="<?php
                date_default_timezone_set("Asia/Tokyo");
                $now = time();
                $enc_minutes = $now + (48* 60 * 60);
                $day = date('Y-m-d', $enc_minutes);
                echo $day;
                ?>"
                >
                          <div class="row">
                            <div class="col-6">
                              <select name="hope3_h_update" id="hope3_h_update" class="form-select" aria-label="select">
                                <option value="">時</option>
                                <option value="01" <?php if($h3 == '01') echo "selected"; ?> >01</option>
                                <option value="02" <?php if($h3 == '02') echo "selected"; ?>>02</option>
                                <option value="03" <?php if($h3 == '03') echo "selected"; ?>>03</option>
                                <option value="04" <?php if($h3 == '04') echo "selected"; ?>>04</option>
                                <option value="05" <?php if($h3 == '05') echo "selected"; ?>>05</option>
                                <option value="06" <?php if($h3 == '06') echo "selected"; ?>>06</option>
                                <option value="07" <?php if($h3 == '07') echo "selected"; ?>>07</option>
                                <option value="08" <?php if($h3 == '08') echo "selected"; ?>>08</option>
                                <option value="09" <?php if($h3 == '09') echo "selected"; ?>>09</option>
                                <option value="10" <?php if($h3 == '10') echo "selected"; ?>>10</option>
                                <option value="11" <?php if($h3 == '11') echo "selected"; ?>>11</option>
                                <option value="12" <?php if($h3 == '12') echo "selected"; ?>>12</option>
                                <option value="13" <?php if($h3 == '13') echo "selected"; ?>>13</option>
                                <option value="14" <?php if($h3 == '14') echo "selected"; ?>>14</option>
                                <option value="15" <?php if($h3 == '15') echo "selected"; ?>>15</option>
                                <option value="16" <?php if($h3 == '16') echo "selected"; ?>>16</option>
                                <option value="17" <?php if($h3 == '17') echo "selected"; ?>>17</option>
                                <option value="18" <?php if($h3 == '18') echo "selected"; ?>>18</option>
                                <option value="19" <?php if($h3 == '19') echo "selected"; ?>>19</option>
                                <option value="20" <?php if($h3 == '20') echo "selected"; ?>>20</option>
                                <option value="21" <?php if($h3 == '21') echo "selected"; ?>>21</option>
                                <option value="22" <?php if($h3 == '22') echo "selected"; ?>>22</option>
                                <option value="23" <?php if($h3 == '23') echo "selected"; ?>>23</option>
                                <option value="24" <?php if($h3 == '24') echo "selected"; ?>>24</option>
                              </select>
                            </div>
                            <div class="col-6">
                              <select name="hope3_m_update" id="hope3_m_update" class="form-select" aria-label="select">
                                <option value="">分</option>
                                <option value="00" <?php if($m3 == '00') echo "selected"; ?>>00</option>
                                <option value="30" <?php if($m3 == '30') echo "selected"; ?>>30</option>
                              </select>
                            </div>
                          </div>
                          </p><br>
                          <input type="hidden" name="edit-item-update" value="<?php echo $_GET['edit-item']; ?>">
                          <button style="
					font-size: 20px;
					border-radius: 20px;
					width: 100%;
				" type="submit" class="btn btn-primary text-center">カートに入れる
                          </button>
                        </div>

                      </form>
                    </div>
                  </div>
                </div>
              </div>
        <?php }
          }
        }
        ?>

        <?php
    if(isset($_SESSION['ec_apo_cart']) && !empty($_SESSION['ec_apo_cart'])){
      foreach($_SESSION['ec_apo_cart'] as $key => $val){ ?>
            <div class="container mt-5 mb-5">
              <div class="d-flex justify-content-center row">
                <div class="col" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;">
                  <div class="d-flex flex-row justify-content-between align-items-center p-2 bg-white mt-4 px-3 rounded">
                    <div class=""><strong class="font-weight-bold"><?php echo $val['company'] ?></strong>
                      <div class="" style="padding-top: 10px">
                      <div class="size mr-1"><span class="text-grey">住所:</span><span
                      class="font-weight-bold">&nbsp;<?php echo $val['address'] ?></span></div><br>
                  <div class="color"><span class="text-grey">商談相手:</span><span
                      class="font-weight-bold">&nbsp;<?php echo $val['negotiation_partner'] ?></span></div>
                  <hr>
                  <div class="color"><span class="text-grey">商談方法:</span><span
                      class="font-weight-bold">&nbsp;<?php echo $val['method'] ?></span></div>
                  <hr>
                  <div class="color"><span class="text-grey">希望商談日:</span><span
                      class="font-weight-bold">&nbsp;<?php echo $val['day1'] . "  " . $val['day1_time'] . " , " . $val['day2'] . "  " . $val['day2_time']  . " , " . $val['day3'] . "  " . $val['day3_time'] ;?></span>
                        </div>
                      </div>
                    </div>
                    <div>
                      <h5 class="text-grey" style="color: red">¥ <?php echo $val['amount'] ?></h5>
                    </div>
                    <div class="d-flex align-items-center">
                    <a href="/checkout/?remove-item=<?php echo $val['id']; ?>" style="font-size: 25px"><i
                    class="fa fa-trash mb-1 text-danger"></i></a>
                    </div>
                    <div class="d-flex align-items-center">
                      <a href="/checkout/?edit-item=<?php echo $val['id']; ?>">編集</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php }
        }else{ ?>
          <div class="alert alert-warning" style="margin: 30px" role="alert">
            カートが空です
          </div>
        <?php }
        ?>
      </div>
      <div class="col-sm-12 col-md-4 col-lg-4" style="padding-top: 70px;">

        <div>
          <div class="form-check" style="line-height: 18px;
    padding: 20px;">
            <input class="form-check-input" type="checkbox" name="exampleRadios1" id="exampleRadios1" value="">
            <label class="form-check-label" for="exampleRadios1">
              下記ボタンを押しても、先方から商談依頼の成立の返事がくるまでは課金されません。
            </label>
          </div>

          <div class="form-check" style="line-height: 18px;
    padding: 20px;">
            <input class="form-check-input" type="checkbox" name="exampleRadios2" id="exampleRadios2" value="">
            <label class="form-check-label" for="exampleRadios2">
              商談相手が、依頼を受諾し、日程が確定した段階でご登録のクレジットカードより課金となります。
            </label>
          </div>
        </div>

        <div class="form__radio">
          <label for="rp">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 222 54" height="30" ><linearGradient id="a" x1="-.681%" x2="100.814%" y1="50.014%" y2="50.014%"><stop offset="0" stop-color="#00437c"/><stop offset=".4" stop-color="#008ccf"/><stop offset="1" stop-color="#00b9ef"/></linearGradient><g fill="none"><path d="m97.21 34.337c1.862-.263 3.74-.39 5.62-.38 2.837 0 4.98.507 6.374 1.52 1.34.969 2.118 2.533 2.082 4.186 0 4.712-4.469 6.333-8.614 6.333-.656.014-1.312-.029-1.96-.126v7.6h-3.476zm3.476 9.202c.646.126 1.304.177 1.961.152 3.202 0 5.133-1.394 5.133-3.876 0-2.362-1.93-3.547-4.738-3.547-.789-.005-1.577.054-2.356.177zm27.94 9.961h-3.684l-2.088-5.705h-7.094l-1.99 5.706h-3.593l7.088-19.392h4.292l7.069 19.392zm-6.344-7.96-1.814-5.067c-.42-1.266-.816-2.64-1.145-3.83h-.061c-.335 1.19-.694 2.614-1.09 3.805l-1.839 5.067zm21.899-11.43-7.16 11.202v8.189h-3.5v-8.108l-6.796-11.284h3.958l2.716 5.067c.755 1.419 1.418 2.635 2.026 4.003h.056c.578-1.292 1.272-2.584 2.027-4.028l2.746-5.067 3.927.025zm23.835 19.39h-3.384l-.507-8.162c-.152-2.635-.335-5.625-.304-8.037h-.086c-.7 2.286-1.601 4.768-2.57 7.226l-3.445 8.796h-2.625l-3.171-8.614c-.913-2.422-1.69-4.893-2.326-7.403h-.091c-.061 2.412-.244 5.478-.426 8.189l-.507 8.01h-3.263l1.57-19.416h4.353l3.259 8.543c.846 2.381 1.52 4.56 2.118 6.668h.09c.573-2.082 1.298-4.287 2.205-6.693l3.35-8.518h4.382l1.378 19.412zm16.042.001h-12.596v-19.392h12.085v2.458h-8.579v5.604h8.107v2.427h-8.107v6.44h9.09zm19.362-.001h-3.548l-6.08-9.074c-1.422-2.11-2.703-4.31-3.836-6.587l-.121.03c.177 2.457.238 4.966.238 8.36v7.251h-3.233v-19.37h3.81l6.066 8.968c1.4 2.046 2.65 4.19 3.744 6.415h.091c-.266-2.73-.386-5.472-.36-8.214v-7.17h3.228v19.392zm18.58-16.883h-6.253v16.884h-3.506v-16.884h-6.222v-2.533h15.981z" fill="#15305a"/><path d="m0 34.14h6.344c3.836 0 6.4 2.482 6.4 6.014 0 2.893-1.52 5.103-4.302 5.792l4.828 7.504h-3.86l-4.56-7.286h-1.522v7.286h-3.328zm9.379 6.014c0-1.905-1.322-2.873-3.45-2.873h-2.62v5.741h2.62c2.128 0 3.45-.958 3.45-2.868zm29.049-6.014h6.263c3.146 0 6.151 1.459 6.151 5.513.03 1.465-.75 2.828-2.027 3.546.274.056 3.005 1.05 3.005 4.525 0 3.39-2.812 5.71-6.455 5.71h-6.937zm6.162 7.889c1.849 0 2.898-.69 2.898-2.376 0-1.688-1.277-2.372-2.898-2.372h-2.838v4.748zm3.88 5.71c0-1.824-1.377-2.569-3.196-2.569h-3.547v5.133h3.547c1.819 0 3.197-.745 3.197-2.564zm32.734-10.458h-5.326v-3.141h13.96v3.141h-5.326v16.169h-3.308zm-45.517 6.334c0 6.744-4.322 10.164-9.937 10.164-5.892 0-9.667-4.003-9.667-9.86 0-6.08 4.053-10.134 9.966-10.134 6.131.02 9.638 4.256 9.638 9.83zm-15.926.228c0 3.927 2.113 7.53 6.08 7.53 3.968 0 6.137-3.547 6.137-7.657 0-3.699-1.936-7.504-6.08-7.504-4.226 0-6.137 3.826-6.137 7.63zm54.425-.228c0 6.744-4.322 10.164-9.942 10.164-5.887 0-9.662-4.003-9.662-9.86 0-6.08 4.053-10.134 9.966-10.134 6.131.02 9.638 4.256 9.638 9.83zm-15.916.228c0 3.927 2.113 7.53 6.08 7.53 3.968 0 6.137-3.547 6.137-7.657 0-3.699-1.936-7.504-6.08-7.504-4.237 0-6.137 3.826-6.137 7.63z" fill="#2092d1"/><path d="m135.025 17.15c.069-.409.104-.822.107-1.236.003-3.166-1.911-6.019-4.842-7.217-2.93-1.198-6.295-.502-8.51 1.76-2.956-7.402-10.75-11.662-18.576-10.157-7.826 1.507-13.481 8.357-13.478 16.327 0 .304 0 .603.036.902-6.182.091-11.146 5.127-11.148 11.31v.1h2.574v-.1c.009-4.827 3.924-8.736 8.751-8.736.364.002.728.026 1.09.071.399.049.798-.092 1.078-.38.28-.289.41-.692.35-1.09-1.165-7.525 3.878-14.609 11.371-15.97 7.493-1.36 14.706 3.499 16.26 10.954.116.552.578.963 1.14 1.015.56.053 1.09-.266 1.307-.787.961-2.294 3.409-3.591 5.847-3.099 2.439.493 4.19 2.638 4.186 5.126-.003.594-.106 1.183-.304 1.743-.131.352-.1.743.086 1.07.202.322.535.54.912.597 4.367.79 7.544 4.591 7.545 9.03 0 .182 0 .364-.03.547h2.588v-.547c-.001-5.174-3.389-9.736-8.34-11.234z" fill="url(#a)"/></g></svg>
          </label>
          <input id="rp" name="payment-method" type="radio" checked />
        </div><br>
        <div class="form__radioo" style="display: block !important">
          <?php
          $total = 0;
          if(isset($_SESSION['ec_apo_cart'])){
            foreach($_SESSION['ec_apo_cart'] as $key => $val){
                $each_amount = str_replace(',', '', $val['amount']);
                 $total+=$each_amount ;
          ?>
              <li><?php echo $val['company'] ?> - <span style="color: red"> ¥ <?php echo $val['amount']; ?> </span> </li>
              <hr>

          <?php }
          }
          ?>
          <div class="row" style="padding: 10px;
                background-color: aliceblue;">
            <div class="col-6">合計</div>
            <div class="col-6" style="text-align: end; color: red">¥ <strong> <?php echo number_format($total); ?></strong></div>
          </div>

                  <P style="text-align: center;
                    padding-top: 20px;
                    line-height: 19px;
                    width: 100%;
                    color: #ff0009c9;
                    font-weight: 600;">上記のチェックボックスにチェックを入れてください</P>
                    
          <div class="row" style="padding: 30px">
            <?php
          if(isset($_SESSION['ec_apo_cart']) && !empty($_SESSION['ec_apo_cart'])){ ?>
            <div class="wrapper" style="position: relative">
                <div id="rp-button-container">
                  <form id="mainform">
                    <input id="tkn" name="tkn" type="hidden" value="">
                    <?php
                      $amounts = [];
                      if (isset($_SESSION['ec_apo_cart'])) {
                          foreach ($_SESSION['ec_apo_cart'] as $key => $val) {
                              $amounts[] =  str_replace(',', '', $val['amount']);  
                            }
                            echo "<input name='amounts' type='hidden' value='" . json_encode($amounts) . "'>";
                          } ?>
                      <div id="CARD_INPUT_FORM"></div>

                      <?php if ($has_order_within_3_month) { ?>
                        <!--<input type="button" value="ワンクリックで購入する" style="margin-bottom: 16px" onclick="doPurchase(true)">-->
                      <?php } ?>

                      <input type="button" value="購入する" onclick="doPurchase()" />
                  </form>

                  <P style="text-align: center;
                    padding-top: 20px;
                    line-height: 19px;
                    width: 100%;
                    color: #ff0009c9;
                    font-weight: 600;">先方から商談実施の成立の返事がくるまで決済されません</P>
                </div>
              </div>
            <?php }else{ ?>
              <button type="button" class="btn btn-primary btn-sm btn-block" disabled>商談を依頼する</button>
            <?php  }
            ?>
          </div>

        </div>
      </div>
    </div>
  </div>
<?php }
?>
<script>
  jQuery(document).ready(function($) {
    $(".registerbtn").prop("disabled", true);
    $('#rp-button-container').css("pointer-events","none");
    $('.wrapper').css("cursor","not-allowed");

    $("#exampleRadios1,#exampleRadios2").change(function() {
      if ($('#exampleRadios1').is(':checked') && $('#exampleRadios2').is(':checked')) {
        $('#rp-button-container').css("pointer-events","auto");
        $('.wrapper').css("cursor","auto");
      } else {
        $('#rp-button-container').css("pointer-events","none");
        $('.wrapper').css("cursor","not-allowed");
      }
    });
  });
</script>
<script src="https://credit.j-payment.co.jp/gateway/js/jquery.js"></script>
<script src="https://credit.j-payment.co.jp/gateway/js/CPToken.js"></script>
<script>
    // 3Dセキュア認証処理を行う関数
    function perform3DSecureAuth(token, callback) {
      // 3Dセキュア認証用のフォームを作成
      var form = document.createElement('form');
      form.setAttribute('method', 'post');
      form.setAttribute('action', 'https://credit.j-payment.co.jp/gateway/3dsecure/auth.aspx');
      form.setAttribute('target', '3dsecure_iframe');
      
      // 必要なパラメータを追加
      var aidInput = document.createElement('input');
      aidInput.setAttribute('type', 'hidden');
      aidInput.setAttribute('name', 'aid');
      aidInput.setAttribute('value', '123747'); // 加盟店ID
      form.appendChild(aidInput);
      
      var tknInput = document.createElement('input');
      tknInput.setAttribute('type', 'hidden');
      tknInput.setAttribute('name', 'tkn');
      tknInput.setAttribute('value', token);
      form.appendChild(tknInput);
      
      var rtInput = document.createElement('input');
      rtInput.setAttribute('type', 'hidden');
      rtInput.setAttribute('name', 'rt');
      rtInput.setAttribute('value', '1'); // 戻り値タイプ
      form.appendChild(rtInput);
      
      // 3Dセキュア認証用のiframeを作成
      var iframe = document.createElement('iframe');
      iframe.setAttribute('name', '3dsecure_iframe');
      iframe.setAttribute('id', '3dsecure_iframe');
      iframe.style.width = '100%';
      iframe.style.height = '400px';
      iframe.style.border = 'none';
      
      // 3Dセキュア認証用のモーダルを作成
      var modal = document.createElement('div');
      modal.setAttribute('id', '3dsecure_modal');
      modal.style.position = 'fixed';
      modal.style.top = '0';
      modal.style.left = '0';
      modal.style.width = '100%';
      modal.style.height = '100%';
      modal.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
      modal.style.zIndex = '9999';
      modal.style.display = 'flex';
      modal.style.justifyContent = 'center';
      modal.style.alignItems = 'center';
      
      var modalContent = document.createElement('div');
      modalContent.style.backgroundColor = '#fff';
      modalContent.style.padding = '20px';
      modalContent.style.borderRadius = '5px';
      modalContent.style.width = '80%';
      modalContent.style.maxWidth = '600px';
      
      var modalTitle = document.createElement('h3');
      modalTitle.textContent = '3Dセキュア認証';
      modalContent.appendChild(modalTitle);
      
      var modalDescription = document.createElement('p');
      modalDescription.textContent = 'カード発行会社の認証画面が表示されます。認証を完了してください。';
      modalContent.appendChild(modalDescription);
      
      modalContent.appendChild(iframe);
      modal.appendChild(modalContent);
      document.body.appendChild(modal);
      
      // フォームをbodyに追加して送信
      document.body.appendChild(form);
      form.submit();
      
      // メッセージイベントリスナーを追加
      window.addEventListener('message', function(event) {
        if (event.origin === 'https://credit.j-payment.co.jp') {
          var result = event.data;
          // モーダルを閉じる
          document.body.removeChild(modal);
          // フォームを削除
          document.body.removeChild(form);
          // コールバックを呼び出す
          callback(result);
        }
      }, false);
    }

    function execPurchase(resultCode, errMsg) {
      if (resultCode != "Success") {
        console.log(errMsg);
        window.alert('決済に失敗しました。最初からやり直してください。');
      } else {
        // トークンを取得
        var token = document.getElementById('tkn').value;
        
        // 3Dセキュア認証を実行
        perform3DSecureAuth(token, function(result) {
          if (result.status === 'success') {
            // 3Dセキュア認証成功時の処理
            var formData = new FormData(document.getElementById('mainform'));
            formData.append('onetouch', false);
            formData.append('threeDSecureResult', JSON.stringify(result));
            
            return fetch('/paypal-validate-payment', {
              method: 'post',
              credentials: 'same-origin',
              headers: {
                'content-type': 'application/json'
              },
              body: JSON.stringify(Object.fromEntries(formData))
            }).then(function(response) {
              if (response.status == 200) {
                window.location = '/checkout';
              } else {
                window.alert('決済に失敗しました。最初からやり直してください。');
              }
            });
          } else {
            // 3Dセキュア認証失敗時の処理
            window.alert('3Dセキュア認証に失敗しました。最初からやり直してください。');
          }
        });
      }
    };

    function execOneTouchPurchase() {
      var formData = new FormData(document.getElementById('mainform'))
      formData.append('onetouch', true)
      return fetch('/paypal-validate-payment', {
        method: 'post',
        credentials: 'same-origin',
        headers: {
          'content-type': 'application/json'
        },
        body: JSON.stringify(Object.fromEntries(formData))
      }).then(function(response) {
        if(response.status == 200){
          window.location = '/checkout';
        } else {
          window.alert('決済に失敗しました。最初からやり直してください。');
        }
      })
    }

    function doPurchase(onetouch = false) {
      const aid = '123747';
      if (onetouch) {
        execOneTouchPurchase()
      } else {
        CPToken.CardInfo({
          aid,
          // 3Dセキュア必須フラグを追加
          secure3d: '1'
        }, execPurchase);
      }
    }
</script>