<?php
/* 
Template Name: Profile 
*/  
$_email = $_SESSION['apo_log_mail'];
global $seconddb;

if ( !isset($_SESSION['apo_log_tkn']) ){
    header("Location: /");
}

get_header();   

function update() {
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
        $created_at = date('Y-m-d H:i:s');

        
        $seconddb->update("vendor", array(
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
         ), array('email'=>$email));

         echo "
            <div style='position: absolute;
            top: 100px;
            right: 10px;
            padding: 10px;
            background-color: orange;
            font-size: 14px;
            border-radius: 10px;'>Update Successful!</div>
        ";

        header("Location: /profile");

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

.nav_sec li {
  padding: 10px;
  margin: 5px;
  float: right;
  background-color: white;
}
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>

<script>
$(document).ready(function() {
  $('#custom_update_form').validate({
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
        minlength: 20
      },
      product_2: {
        minlength: 20
      },
      product_3: {
        minlength: 20
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
      }
    },
    messages: {
      contact_name: 'お名前(フリガナ)を入力してください。',
      company_name: '会社名を入力してください。',
      company_address: '会社住所を入力してください。',
      company_url: 'ホームページURLを入力してください。',
      contact_cell: 'SMSが受け取れる携帯番号を入力してください。',
      email: {
        required: 'メールアドレスを入力してください。',
        email: '正確なメールアドレスを入力してください。',
      },
      title_name: {
        required: 'お名前を入力してください。',
      },
      product_1: {
        required: '提案したい商材1を入力してください。',
        minlength: '全角20字以内は入力不可にする',
      },
      product_2: {
        minlength: '全角20字以内は入力不可にする',
      },
      product_3: {
        minlength: '全角20字以内は入力不可にする',
      },
      psw: {
        required: 'パスワードを入力してください。',
        minlength: '半角英数8文字以上でご設定下さい',
      },
      pswrepeat: {
        required: '確認パスワードを入力してください。',
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
    margin: 10px 0 10px 0;
    background-color: azure;
    font-size: 25px;">
  <p style="padding: 20px 30px 20px 30px;
    line-height: 15px;
    font-weight: 600;
    color: blue;
    font-family: cursive;">ご登録ありがとうございます。</p>
  <P style="padding: 20px 30px 20px 30px;
    line-height: 15px;
    font-weight: 600;
    color: blue;
    font-family: cursive;">自動返信メールが届いていますのでご確認ください。</P>
</div>
<? }
  }
?>


<div style="padding-bottom: 44px;">
  <ul class="nav_sec" style="text-align: center">
    <li><a href="/billing" class="btn btn-danger">購入履歴</a></li>
    <li><a href="/appointments" class="btn btn-danger">アポイント予定</a></li>
  </ul>
</div>
<div class="container">

  <form id="custom_update_form" method="post">
    <div class="row d-flex justify-content-center">
      <div class="col-sm-12 col-md-8 col-lg-8">

        <label class="input-lable" for="company_name"><b>会社名</b></label>
        <input type="text" name="company_name" id="company_name"
          value="<?php $company_name = $seconddb->get_var("SELECT company_name FROM vendor WHERE email='$_email'"); echo $company_name; ?>">

        <label class="input-lable" for="company_address"><b>会社住所</b></label>
        <input type="text" name="company_address" id="company_address"
          value="<?php $company_address = $seconddb->get_var("SELECT company_address FROM vendor WHERE email='$_email'"); echo $company_address; ?>">

        <label class="input-lable" for="company_url"><b>ホームページURL</b></label>
        <input type="text" name="company_url" id="company_url"
          value="<?php $company_url = $seconddb->get_var("SELECT company_url FROM vendor WHERE email='$_email'"); echo $company_url; ?>">

        <label class="input-lable" for="title_name"><b>お名前</b></label>
        <input type="text" name="title_name" id="title_name"
          value="<?php $title_name = $seconddb->get_var("SELECT title_name FROM vendor WHERE email='$_email'"); echo $title_name; ?>">

        <label class="input-lable" for="contact_name"><b>お名前(フリガナ)</b></label>
        <input type="text" name="contact_name" id="contact_name"
          value="<?php $contact_name = $seconddb->get_var("SELECT contact_name FROM vendor WHERE email='$_email'"); echo $contact_name; ?>">

        <label class="input-lable" for="contact_address"><b>メールアドレス</b></label>
        <input type="email" name="email" id="email"
          value="<?php $contact_address = $seconddb->get_var("SELECT contact_address FROM vendor WHERE email='$_email'"); echo $_email; ?>">

        <label class="input-lable" for="contact_cell"><b>SMSが受け取れる携帯番号</b></label>
        <input type="text" name="contact_cell" id="contact_cell"
          value="<?php $contact_cell = $seconddb->get_var("SELECT contact_cell FROM vendor WHERE email='$_email'"); echo $contact_cell; ?>">

        <label class="input-lable" for="product_1"><b>提案したい商材1</b></label>
        <input type="text" name="product_1" id="product_1"
          value="<?php $product_1 = $seconddb->get_var("SELECT product_1 FROM vendor WHERE email='$_email'"); echo $product_1; ?>">

        <label class="input-lable" for="product_url_1"><b>上記商材のURLがある場合</b></label>
        <input type="text" name="product_url_1" id="product_url_1"
          value="<?php $product_url_1 = $seconddb->get_var("SELECT product_url_1 FROM vendor WHERE email='$_email'"); echo $product_url_1; ?>">

        <label class="input-lable" for="product_2"><b>提案したい商材2</b></label>
        <input type="text" name="product_2" id="product_2"
          value="<?php $product_2 = $seconddb->get_var("SELECT product_2 FROM vendor WHERE email='$_email'"); echo $product_2; ?>">

        <label class="input-lable" for="product_url_2"><b>上記商材のURLがある場合</b></label>
        <input type="text" name="product_url_2" id="product_url_2"
          value="<?php $product_url_2 = $seconddb->get_var("SELECT product_url_2 FROM vendor WHERE email='$_email'"); echo $product_url_2; ?>">

        <label class="input-lable" for="product_3"><b>提案したい商材3</b></label>
        <input type="text" name="product_3" id="product_3"
          value="<?php $product_3 = $seconddb->get_var("SELECT product_3 FROM vendor WHERE email='$_email'"); echo $product_3; ?>">

        <label class="input-lable" for="product_url_3"><b>上記商材のURLがある場合</b></label>
        <input type="text" name="product_url_3" id="product_url_3"
          value="<?php $product_url_3 = $seconddb->get_var("SELECT product_url_3 FROM vendor WHERE email='$_email'"); echo $product_url_3; ?>">

        <label class="input-lable" for="psw"><b>ログインパスワード</b></label>
        <input type="password" name="psw" id="psw"
          value="<?php $password = $seconddb->get_var("SELECT password FROM vendor WHERE email='$_email'"); echo $password; ?>">

        <hr>

        <button type="submit" class="updateBtn btn btn-primary">更新</button>
      </div>
    </div>

</div>
</form>
<?php
if($_SERVER['REQUEST_METHOD']=='POST')
{
       update();
} 
?>
<?php get_footer(); ?>