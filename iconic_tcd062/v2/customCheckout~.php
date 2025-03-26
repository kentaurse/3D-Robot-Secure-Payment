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
</style>

<?php
if(isset($_GET['status']) & !empty($_GET['status']) ){
  if($_GET['status'] == 'success'){ ?>
    <div class="container">
    <div class="d-flex justify-content-md-center align-items-center" style="height: 80vh!important">
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
  <?php }
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
        <label for="paypal">
          <img src="https://ec-apo.com/paypal.png" height="30" alt="paypal">
        </label>
        <input id="paypal" name="payment-method" type="radio" checked />
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

        <div class="row" style="padding: 30px">
          <?php
          if(isset($_SESSION['ec_apo_cart']) && !empty($_SESSION['ec_apo_cart'])){ ?>
          <div class="wrapper" style="position: relative">
          <div id="paypal-button-container">
          <P style="padding-bottom: 16px;
            text-align: justify;
            line-height: 19px;
            width: 100%;
            color: #001bff;
            font-weight: 600;">Paypalアカウントをお持ちの方は黄色、ない方は黒色のボタンからお進みください。</P>

          <P style="padding-bottom: 16px;
    text-align: center;
    line-height: 19px;
    width: 100%;
    color: #ff0009c9;
    position: absolute;
    font-weight: 600;
    bottom: -43px;
    left: 0;
    right: 0;">先方から商談実施の成立の返事がくるまで決済されません</P>
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
  $('#paypal-button-container').css("pointer-events","none");
  $('.wrapper').css("cursor","not-allowed");

  $("#exampleRadios1,#exampleRadios2").change(function() {
    if ($('#exampleRadios1').is(':checked') && $('#exampleRadios2').is(':checked')) {
      $('#paypal-button-container').css("pointer-events","auto");
      $('.wrapper').css("cursor","auto");
    } else {
      $('#paypal-button-container').css("pointer-events","none");
      $('.wrapper').css("cursor","not-allowed");
    }
  });
});
</script>
<script src="https://www.paypal.com/sdk/js?client-id=AR5jRe8vQwJcDR721nns0Rzbj3H5KuCXXqWGtm1FVypr0nCAyB3UDsxD5Nou8ffiP3WhwiczM6f_cWU-&intent=authorize&currency=JPY" data-namespace="paypal_sdk"></script>
<script>
  paypal_sdk.Buttons({
    createOrder: function(data, actions) {
      return actions.order.create({
        purchase_units: [{
          amount: {
            value: '<?php echo $total; ?>'
          }
        }]
      });
    },

  onApprove: function(data, actions) {
    window.scrollTo({ top: 0, behavior: 'smooth' });
    document.getElementById("post_payment_laoding").style.display="block";

  // Authorize the transaction
  actions.order.authorize().then(function(authorization) {
    // Get the authorization id
    var authorizationID = authorization.purchase_units[0].payments.authorizations[0].id;
   
    // Call your server to validate and capture the transaction
    return fetch('/paypal-validate-payment', {
      method: 'post',
      credentials: 'same-origin',
      headers: {
        'content-type': 'application/json'
      },
      body: JSON.stringify({
        orderID: data.orderID,
        authorizationID: authorizationID
      })
    }).then(function (response) {
      if(response.status == 200){
        window.location = '/checkout/?status=success';
      }
});
  });
}
  }).render('#paypal-button-container');
</script>