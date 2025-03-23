<?php  
/* 
Template Name: ResetPass 
*/  
   
get_header();   

    function check_reset() {
        global $seconddb;
        $errors = [];

        $email = sanitize_text_field( $_POST['email'] );
        $created_at = date('Y-m-d H:i:s');


        if (empty($email)) array_push($errors, "メールアドレスを入力してください。");

        if (count($errors) == 0) {
            $mail_check = $seconddb->get_var("SELECT COUNT(*) FROM vendor WHERE email='$email'");

            if ($mail_check == 1) {
                $apo_log_tkn = bin2hex(random_bytes(40));

                $seconddb->insert("password_reset", array(
                    "email" => $email,
                    "token" => $apo_log_tkn,
                    "expired_at" => time() + (24*60*60),
                    "created_at" => $created_at
                 ));

                

                 echo "
                    <div style='position: absolute;
                    top: 100px;
                    right: 10px;
                    padding: 30px;
                    background-color: orange;
                    font-size: 14px;
                    border-radius: 10px;'>入力されたアドレスにメールを送信しました</div>
                ";

                ini_set( 'display_errors', 1 );
                error_reporting( E_ALL );
                $from = "sales-offer@ec-apo.com";
                $to = $email;
                $subject = "【EC Apo】パスワード再設定のお知らせ";
                $message = "
                    <p>お世話になっております。</p>                    
                    <h5>次のURLをクリックしてパスワードを再設定してください。</h5>

                    <p>Email: <strong>{$email}</strong></p>
                    <a href='https://ec-apo.com/reset-now/?token={$apo_log_tkn}'>https://ec-apo.com/reset-now/?token={$apo_log_tkn}</a>
                    <br><br>

                    <h3>引き続き、よろしくお願い申し上げます。</h3>
                    <hr>
                    <p>
                    ****************************<br>
                    EC Apo 運営事務局<br>
                    株式会社リアリディール<br>
                    東京都渋谷区恵比寿4-20-3<br>
                    恵比寿ガーデンプレイスタワー18階<br>
                    sales-offer@ec-apo.com<br>
                    ****************************<br>
                    </p>
                ";
                
                $headers = "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                $headers .= "From:" . $from . "\r\n";

                mail($to,$subject,$message, $headers);

            }else{
                echo "
                <div style='position: absolute;
                top: 100px;
                right: 10px;
                padding: 10px;
                background-color: orange;
                font-size: 14px;
                border-radius: 10px;'>登録されたユーザーが見つかりません!</div>
            ";
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
</style>

<form id="password_check_form" method="post">

  <div class="container" style="padding-top: 50px">

    <div class="row d-flex justify-content-center">
      <div class="col-sm-12 col-md-8 col-lg-8">
        <label for="email"><b>メール</b></label>
        <input type="email" placeholder="メール" name="email" id="email" required>

        <button type="submit" class="loginBtn">再設定</button>
      </div>
    </div>

  </div>

  <div class="container signin">
    <p>既に登録済みですか <a href="/login" class="hover-deepblue">ログイン</a>.</p>
  </div>

</form>
<?php
if($_SERVER['REQUEST_METHOD']=='POST')
{
       check_reset();
} 
?>
<?php get_footer(); ?>