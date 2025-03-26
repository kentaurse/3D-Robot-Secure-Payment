<?php  
/* 
Template Name: Register 
*/  
get_header();   

    function register() {
        $errors = [];
        global $seconddb;

        $email = isset( $_POST['email'] ) ? sanitize_text_field( $_POST['email'] ) : '';
        $company_name = isset( $_POST['company_name'] ) ? sanitize_text_field( $_POST['company_name'] ) : '';
        $company_address = isset( $_POST['company_address'] ) ? sanitize_text_field( $_POST['company_address'] ) : '';
        $company_url = isset( $_POST['company_url'] ) ? sanitize_text_field( $_POST['company_url'] ) : '';
        $title_name = isset( $_POST['title_name'] ) ? sanitize_text_field( $_POST['title_name'] ) : '';
        $contact_name = isset( $_POST['contact_name'] ) ? sanitize_text_field( $_POST['contact_name'] ) : '';
        $contact_cell = isset( $_POST['contact_cell'] ) ? sanitize_text_field( $_POST['contact_cell'] ) : '';
        $product_1 = isset( $_POST['product_1'] ) ? sanitize_text_field( $_POST['product_1'] ) : '';
        $product_2 = isset( $_POST['product_2'] ) ? sanitize_text_field( $_POST['product_2'] ) : '';
        $product_3 = isset( $_POST['product_3'] ) ? sanitize_text_field( $_POST['product_3'] ) : '';
        $product_url_1 = isset( $_POST['product_url_1'] ) ? sanitize_text_field( $_POST['product_url_1'] ) : '';
        $product_url_2 = isset( $_POST['product_url_2'] ) ? sanitize_text_field( $_POST['product_url_2'] ) : '';
        $product_url_3 = isset( $_POST['product_url_3'] ) ? sanitize_text_field( $_POST['product_url_3'] ) : '';
        $password = sanitize_text_field( $_POST['psw'] );
        $re_password = sanitize_text_field( $_POST['psw-repeat'] );
        $created_at = date('Y-m-d H:i:s');

 
        if(!empty($_POST)){

          $reg_check = $seconddb->get_var("SELECT COUNT(*) FROM vendor WHERE email='$email'");

          if ($reg_check == 1) {
            echo "
            <div style='position: absolute;
            top: 100px;
            right: 10px;
            padding: 10px;
            background-color: orange;
            font-size: 14px;
            border-radius: 10px;'>同じメールアドレスのユーザーが見つかりました</div>
        ";
          }else{
            $regis = $seconddb->insert("vendor", array(
            	"email" => $email,
                "company_name" => $company_name,
                "company_address" => $company_address,
                "company_url" => $company_url,
                "title_name" => $title_name,
                "contact_name" => $contact_name,
                "contact_address" => '',
                "contact_cell" => $contact_cell ,
                "product_1" => $product_1 ,
                "product_2" => $product_2 ,
                "product_3" => $product_3 ,
                "product_url_1" => $product_url_1 ,
                "product_url_2" => $product_url_2 ,
                "product_url_3" => $product_url_3 ,
                "password" => md5($password) ,
                "created_at" => $created_at ,
             ));


                ini_set( 'display_errors', 1 );
                error_reporting( E_ALL );
                $from = "sales-offer@ec-apo.com";
                $to = $email;
                $subject = "【{$title_name} 様へ】 EC Apoへの登録が完了しました。";
                $bcc = "contact9-1@ec-apo.com";
                $message = "
                    <p> $title_name 様</p>
                    <h4>この度はEC Apoへのご登録を頂き、有難うございました。</h4>
                    <h5>今後は本アドレス( sales-offer@ec-apo.com )にて、商談依頼の結果が届きますので、見落としがないように迷惑メールフォルダに届かないように設定をお願い致します。</h5>
                    <h5>ご登録内容は下記になります</h5>
                    <P>会社名：$company_name</P>
                    <P>会社住所：$company_address</P>
                    <P>ホームページURL：$company_url</P>                    
                    <P>お名前：$title_name</P>
                    <P>お名前(フリガナ)： $contact_name</P>
                    <P>メールアドレス： $email</P>
                    <P>SMSが受け取れる携帯番号：$contact_cell</P>
                    <P>提案したい商材1：$product_1</P>
                    <P>上記商材のURLがある場合：$product_url_1</P>
                    <P>提案したい商材2：$product_2</P>
                    <P>上記商材のURLがある場合：$product_url_2</P>
                    <P>提案したい商材3：$product_3</P>
                    <P>上記商材のURLがある場合：$product_url_3</P>
                    <p>本サービスは決裁者へのアポイントを即獲得ができますので、ぜひ有効活用下さいませ。</p>
                    <code>https://ec-apo.com/</code><br><br>
                    <h3>引き続き、よろしくお願い申し上げます。</h3>
                    <hr>
                    <div>
                    **************************** <br>
                    EC Apo 運営事務局 <br>
                    株式会社リアリディール <br>
                    東京都渋谷区恵比寿4-20-3 <br>
                    恵比寿ガーデンプレイスタワー18階 <br>
                    sales-offer@ec-apo.com <br>
                    ****************************
                    </div>
                ";
                
                $headers = "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                $headers .= "From:" . $from . "\r\n";
                $headers .= "Bcc:" . $bcc . "\r\n";
                mail($to,$subject,$message, $headers);


              if($regis){
                $password = md5($password);
                $login_check = $seconddb->get_var("SELECT COUNT(*) FROM vendor WHERE email='$email' AND password='$password'");
    
                if ($login_check == 1) {
                    $apo_log_tkn = bin2hex(random_bytes(40));
                    $_SESSION['apo_log_mail'] = $email;
                    $_SESSION['apo_log_tkn'] = $apo_log_tkn;
                    $_SESSION['apo_log_expired'] = time() + (24*60*60); 
    
                    $seconddb->insert("login", array(
                        "email" => $_SESSION['apo_log_mail'],
                        "token" => $_SESSION['apo_log_tkn'],
                        "expired_at" => $_SESSION['apo_log_expired'],
                        "created_at" => $created_at
                     ));


                     if(isset($_GET['action']) && !empty($_GET['action']) ){
                      if($_GET['action'] == 'must_login'){
                        if(isset($_GET['return_to']) && isset($_GET['userid']) && $_GET['return_to'] === 'research' && $_GET['userid'] != ''){
                          header("Location: /research?userid=".$_GET['userid']);
                        }else{
                          header("Location: /products");
                        }                      
                      }
                     }else{
                      header("Location: /profile/?msg=reg-success");
                     }
    
                }
              }

                
          }  
      }

}


?>
<style>
body {
  font-family: Arial, Helvetica, sans-serif;
}

* {
  box-sizing: border-box;
}

.error {
  display: block;
  color: red;
  font-weight: 600
}

.input-lable {
  padding-top: 25px;
}

input[type=text],
input[type=number],
input[type=password],
input[type=email] {
  width: 100%;
  padding: 15px;
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

.registerbtn:hover {
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
	
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>

<script>
$(document).ready(function() {
  $('#custom_signup_form').validate({
    rules: {
      contact_name: {
        required: true
      },
      company_name: {
        required: true
      },
      contact_cell: {
        required: true
      },
      company_address: {
        required: true
      },
      company_url: {
        required: true
      },
      product_1: {
        required: true,
        maxlength: 40
      },
      product_2: {
        maxlength: 40
      },
      product_3: {
        maxlength: 40
      },
      email: {
        required: true,
        email: true
      },
      title_name: {
        required: true,
      },
      psw: {
        required: true,
        minlength: 8
      },
      pswrepeat: {
        required: true,
        equalTo: "#psw"
      }
    },
    messages: {
      contact_name: 'お名前(フリガナ)を入力してください。',
      company_name: '会社名を入力してください。',
      company_address: '会社住所を入力してください。',
      company_url: 'ホームページURLを入力してください。',
      contact_cell: '半角数字のみでご入力ください。',
      email: {
        required: 'メールアドレスを入力してください。',
        email: '正確なメールアドレスを入力してください。',
      },
      title_name: {
        required: 'お名前を入力してください。',
      },
      product_1: {
        required: '40文字以内で入力してください',
        maxlength: '40文字以内で入力して下さい',
      },
      product_2: {
        maxlength: '40文字以内で入力して下さい',
      },
      product_3: {
        maxlength: '40文字以内で入力して下さい',
      },
      psw: {
        required: 'パスワードを入力してください。',
        minlength: '半角英数8文字以上でご設定下さい',
      },
      pswrepeat: {
        required: '確認パスワードを入力してください。',
        equalTo: '同じパスワードを入力してください。',
      }
    },
    submitHandler: function(form) {
      form.submit();
    }
  });
});
</script>

<?php
  if(isset($_GET['msg']) & !empty($_GET['msg']) ){
    if($_GET['msg'] == 'reg-success'){ ?>
<div style="text-align: center;
    margin: 100px 0 100px 0;
    background-color: azure;
    font-size: 25px;">
  <p style="padding: 40px 30px 40px 30px;
    line-height: 30px;
    font-weight: 600;
    color: blue;
    font-family: cursive;">ご登録ありがとうございます。</p>
  <P style="padding: 40px 30px 40px 30px;
    line-height: 30px;
    font-weight: 600;
    color: blue;
    font-family: cursive;">自動返信メールが届いていますのでご確認ください。</P><br>
  <a href="/login" class="btn btn-sm btn-primary">ログイン</a>
</div>
<? }
  }else{ ?>
<form id="custom_signup_form" method="post">
  <div class="container" style="padding-top: 20px">
    <div class="row d-flex justify-content-center">
      <div class="col-sm-12 col-md-8 col-lg-8">
        <label class="input-lable"><b>種別</b></label>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1"
            checked>
          <label class="form-check-label" for="inlineRadio1">個人</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
          <label class="form-check-label" for="inlineRadio2">法人</label>
        </div><br>


        <label class="input-lable" for="company_name"><b>会社名</b></label>
        <input type="text" name="company_name" id="company_name">

        <label class="input-lable" for="company_address"><b>会社住所</b></label>
        <input type="text" name="company_address" id="company_address">

        <label class="input-lable" for="company_url"><b>ホームページURL</b></label>
        <input type="text" placeholder="ホームページURL" name="company_url" id="company_url">

        <label class="input-lable" for="title_name"><b>お名前</b></label>
        <input type="text" name="title_name" id="title_name">

        <label class="input-lable" for="contact_name"><b>お名前(フリガナ)</b></label>
        <input type="text" name="contact_name" id="contact_name">

        <label class="input-lable" for="contact_address"><b>メールアドレス</b></label>
        <input type="email" name="email" id="email">

        <label class="input-lable" for="contact_cell"><b>SMSが受け取れる携帯番号</b></label>
        <input type="number" name="contact_cell" id="contact_cell" placeholder="ハイフンなし">

        <label class="input-lable" for="product_1"><b>提案したい商材1</b></label>
        <input type="text" name="product_1" id="product_1" placeholder="40文字以内で入力して下さい">

        <label class="input-lable" for="product_url_1"><b>上記商材のURLがある場合</b></label>
        <input class="input-lable" type="text" name="product_url_1" id="product_url_1">

        <label class="input-lable" for="product_2"><b>提案したい商材2(ない場合は入力不要)</b></label>
        <input type="text" name="product_2" id="product_2">

        <label class="input-lable" for="product_url_2"><b>上記商材のURLがある場合</b></label>
        <input type="text" name="product_url_2" id="product_url_2">

        <label class="input-lable" for="product_3"><b>提案したい商材3(ない場合は入力不要)</b></label>
        <input type="text" name="product_3" id="product_3">

        <label class="input-lable" for="product_url_3"><b>上記商材のURLがある場合</b></label>
        <input type="text" name="product_url_3" id="product_url_3">

        <label class="input-lable" for="psw"><b>ログインパスワード</b></label>
        <input type="password" name="psw" id="psw">


        <label class="input-lable" for="pswrepeat"><b>パスワード確認</b></label>
        <input type="password" name="pswrepeat" id="pswrepeat">
        <hr>
        <div class="form-check">
        <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
        <label class="form-check-label" for="defaultCheck1" style="padding: 4px">
        <a target="_blank" href="https://ec-apo.com/rule.php" class="hover-deepblue">サイト利用規約</a>に同意します
        </label>
      </div>

        <button type="submit" class="registerbtn">登録</button>
      </div>
    </div>

  </div>

  <div class="container signin">
    <p>既に登録済みですか <a href="/login" class="hover-deepblue">ログイン</a>.</p>
  </div>

</form>
<script>
jQuery(document).ready(function($) {
  $(".registerbtn").prop("disabled", true);
  $(".registerbtn").css("opacity", "50%");

  $(".form-check-input").click(function() {
    if ($('#defaultCheck1').is(':checked')) {
      $(".registerbtn").prop("disabled", false);
      $(".registerbtn").css("opacity", "100%");
    } else {
      $(".registerbtn").prop("disabled", true);
      $(".registerbtn").css("opacity", "50%");
    }
  });
});
	
	const input = document.getElementById('contact_cell');
	input.addEventListener('keydown', rejectMinus);

	function rejectMinus(event) {
		if (event.key === '-') {
			event.preventDefault();
		}
	}

</script>
<?php }
  ?>
<?php
if($_SERVER['REQUEST_METHOD']=='POST')
{
       register();      
} 
?>
<?php get_footer(); ?>