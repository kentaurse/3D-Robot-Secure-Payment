<?php
if (!session_id()) {
    session_start();
}
/* 
Template Name: Login 
*/  
   

get_header();   

    function login() {
        global $seconddb;
        $errors = [];

        $email = sanitize_text_field( $_POST['email'] );
        $password = sanitize_text_field( $_POST['psw'] );
        $created_at = date('Y-m-d H:i:s');


        if (empty($email)) array_push($errors, "Email is required");
        if (empty($password)) array_push($errors, "Password is required");

        if (count($errors) == 0) {
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
                    if(isset($_GET['return_to']) && $_GET['return_to'] == 'research'){
                      header("Location: /research?userid=".$_GET['userid']);
                    }elseif(isset($_GET['return_to']) && $_GET['return_to'] == 'company'){
                      header("Location: /company?userid=".$_GET['userid']);
                    }else{
                      header("Location: /products");
                    }
                  }
                 }else{
                    header("Location: /profile");
                 }


            }else{
                echo "
                <div style='position: absolute;
                top: 100px;
                right: 10px;
                padding: 10px;
                background-color: orange;
                font-size: 14px;
                border-radius: 10px;'>メールアドレスまたはパスワードが間違っています。</div>
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


.atend {
  background-color: #FFF2CC;
  text-align: left;
  position: relative;
    padding: 1rem 1rem;
    margin-bottom: 1rem;
    border: 1px solid transparent;
    border-radius: 0.25rem;
  color:#ED7D31;
}

</style>


<?php
  if(isset($_GET['action']) & !empty($_GET['action']) ){
    if($_GET['action'] == 'pass-reset'){ 
        echo '
        <div style="text-align: center;
        margin: 10px 0 10px 0;
        padding-top: 100px;
        font-size: 25px;">
      <p style="padding: 20px 30px 20px 30px;
        line-height: 15px;
        font-weight: 600;
        color: blue;
        font-family: cursive;">パスワードの変更が完了しました。</p>
      <P style="padding: 20px 30px 20px 30px;
        line-height: 15px;
        font-weight: 600;
        color: blue;
        font-family: cursive;">下記よりログインしてください。</P>
    </div>
        ';
       ?>
  <?php  }
  }
?>


<form id="custom_signup_form" method="post" action="https://ec-apo.com/login<?php if($_GET['action'] == 'must_login'){echo '?action=must_login';} ?><?php if($_GET['return_to'] == "research"){echo '&return_to=research';} ?><?php if($_GET['return_to'] == "company"){echo '&return_to=company';} ?><?php if($_GET['userid'] != ""){echo '&userid='.$_GET['userid'];} ?>">
  <div class="container" style="padding-top: 50px">
    <div class="row d-flex justify-content-center">

      <div class="col-sm-12 col-md-8 col-lg-8" style="padding-bottom: 30px">

        <div class="alert alert-danger" role="alert">
          ログインしてお進みください。<br>
未登録で利用希望の営業会社、営業職の方は<a href="https://ec-apo.com/saleslp-e/rea/" target="_blank">こちら</a>よりお問い合わせください。
        </div>

        <div class="atend">
こちらは、営業をする方専用のログインページです。<br>
掲載している経営者の方は<a href="https://ec-apo.com/contact.php" target="_blank">こちら</a>より、お問合せください。
        </div>

      </div>

      <div class="col-sm-12 col-md-8 col-lg-8">
        <label for="email"><b>メール</b></label>
        <input type="email" placeholder="メール" name="email" id="email" required>
<br><br>
        <label for="psw"><b>パスワード</b></label>
        <input type="password" placeholder="パスワード" name="psw" id="psw" required>
<br><br>
        <button type="submit" class="loginBtn">ログイン</button>
        <div style="padding: 20px; float: right">
          <p>パスワードを再設定しますか？<a href="/password-reset" class="hover-deepblue">再設定</a>.</p>
        </div>
      </div>
    </div>

  </div>


</form>
<?php
if($_SERVER['REQUEST_METHOD']=='POST')
{
       login();
} 
?>
<?php get_footer(); ?>