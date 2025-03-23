<?php  
/* 
Template Name: ResetPassForm 
*/  
   
get_header();   

    function pass_reset() {
        global $seconddb;
        $errors = [];

        if(isset($_GET['token'])){
            $get_token = $_GET['token'];
            $email = sanitize_text_field( $_POST['email'] );
            $password = sanitize_text_field( $_POST['psw'] );
            $re_password = sanitize_text_field( $_POST['psw-repeat'] );
            $created_at = date('Y-m-d H:i:s');

            if($password === $re_password){
                $check_reset_access_token = $seconddb->get_var("SELECT COUNT(*) FROM password_reset WHERE email='$email' AND token='$get_token' ");

                if ($check_reset_access_token == 1) {

                    $update_pass = $seconddb->update('vendor', array('password'=>md5($password), 'created_at'=>$created_at), array('email'=>$email));

                    echo "
                <div style='position: absolute;
                top: 100px;
                left: 200px;
                padding: 10px;
                background-color: orange;
                font-size: 14px;
                border-radius: 10px;'>パスワードの変更が完了しました。
                <P>下記よりログインしてください。</P>
                </div>
            ";
                    
                header("Location: /login?action=pass-reset");

                }else{
                echo "
                <div style='position: absolute;
                top: 100px;
                right: 10px;
                padding: 10px;
                background-color: orange;
                font-size: 14px;
                border-radius: 10px;'>入力内容に誤りがあります</div>
            ";
                }
            }else{
                echo "
                <div style='position: absolute;
                top: 100px;
                right: 10px;
                padding: 10px;
                background-color: orange;
                font-size: 14px;
                border-radius: 10px;'>パスワードが一致しません。</div>
            ";
            }

        }else{
            echo "
            <div style='position: absolute;
            top: 100px;
            right: 10px;
            padding: 10px;
            background-color: orange;
            font-size: 14px;
            border-radius: 10px;'>トークンは空白のままにすることはできません。</div>
        ";
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
        <label for="email"><b>メールアドレス</b></label>
        <input type="email" placeholder="登録時のメールアドレスを入力" name="email" id="email" required>

        <label for="psw"><b>新しいパスワード</b></label>
        <input type="password" placeholder="8文字以上入力してください" name="psw" id="psw" required>

        <label for="psw-repeat"><b>パスワード再入力</b></label>
        <input type="password" placeholder="" name="psw-repeat" id="psw-repeat" required>

        <button type="submit" class="loginBtn">送信する</button>
      </div>
    </div>

  </div>

  <div class="container signin">
    <p>既に登録済みですか？<a href="/login" class="hover-deepblue">ログイン</a></p>
  </div>

</form>
<?php
if($_SERVER['REQUEST_METHOD']=='POST')
{
    pass_reset();
} 
?>
<?php get_footer(); ?>