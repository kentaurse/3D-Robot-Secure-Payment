<?php
/* 
Template Name: Products 
*/  

$_email = $_SESSION['apo_log_mail'];
global $seconddb;


get_header();

if(!isset($_SESSION['apo_log_tkn'])){

    header("Location: /login/?action=must_login");

}

if(isset($_GET['product-update']) & !empty($_GET['product-update']) ){
    if($_GET['product-update'] == 1){
        $seconddb->update("vendor", array(
            "product_1" => $_GET['product_name_u'] ,
            "product_url_1" => $_GET['product_page_u'] ,
        ), array('email'=>$_email));
    }else if($_GET['product-update'] == 2){
        $seconddb->update("vendor", array(
            "product_2" => $_GET['product_name_u'] ,
            "product_url_2" => $_GET['product_page_u'] ,
        ), array('email'=>$_email));
    }else{
        $seconddb->update("vendor", array(
            "product_3" => $_GET['product_name_u'] ,
            "product_url_3" => $_GET['product_page_u'] ,
        ), array('email'=>$_email));
    }

    header("Location: /products");

}

if(isset($_GET['remove-item']) & !empty($_GET['remove-item']) ){
    foreach($_SESSION['ec_apo_cart'] as $k => $v) {
        if($v['id'] == $_GET['remove-item'])
          unset($_SESSION['ec_apo_cart'][$k]);

          header("Location: /cart");
      }
}

if($_SERVER['REQUEST_METHOD']=='POST')
{
	add_product_to_card();
}

function add_product_to_card(){

    $_SESSION['ec_apo_product'][0] = array(
		'id' => rand(),
		'product_name'=>$_POST['product_name'],
		'product_page'=>$_POST['product_page'],
	   );

       echo "
       <div style='position: absolute;
                top: 100px;
                left: 10px;
                padding: 10px;
                background-color: orange;
                font-size: 14px;
                border-radius: 10px;'>{$_POST['product_name']} - has added to the cart!</div>
       ";

       header("Location: /checkout");

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

  .error {
    display: block;
    color: red;
    font-weight: 600
  }
</style>
<div class="container">
  <h4 style="padding: 30px;">提案したい商材の選択</h4>
  <div class="row">
    <?php
    if(isset($_SESSION['ec_apo_cart']) && !empty($_SESSION['ec_apo_cart'])){ ?>

    <div class="col-sm-12 col-md-4 col-lg-4" style="margin: 40px 0 40px 0;">
      <form id="cart_adjust" method="post">
        <div class="card text-center" style="box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;">
          <div class="card-body" style="min-height: 153px;">
            <h5 class="card-title">
              <?php $p1 = $seconddb->get_var("SELECT product_1 FROM vendor WHERE email='$_email'"); echo $p1; ?></h5>
            <hr>
            <p class="card-text text-primary">
              <u><?php $p1_h = $seconddb->get_var("SELECT product_url_1 FROM vendor WHERE email='$_email'"); echo $p1_h; ?></u>
            </p>
          </div>
          <div class="card-footer text-muted">
            <input type="hidden" id="product_name" name="product_name"
              value="<?php $p1 = $seconddb->get_var("SELECT product_1 FROM vendor WHERE email='$_email'"); echo $p1; ?>">
            <input type="hidden" id="product_page" name="product_page"
              value="<?php $p1_h = $seconddb->get_var("SELECT product_url_1 FROM vendor WHERE email='$_email'"); echo $p1_h; ?>">
            <button type="submit" class="btn btn-sm btn-primary">この商材を提案希望</button>
            <a class="btn btn-sm btn-danger" href="/products/?product-edit=1">編集</a>
          </div>
        </div>
      </form>

      <div class="edit-product" style="padding-top: 33px;
    line-height: 37px;">
        <?php
                        if(isset($_GET['product-edit']) & !empty($_GET['product-edit']) ){
                            if($_GET['product-edit'] == 1){ ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>

        <script>
          $(document).ready(function () {
            $('#product-edit-from-product-page').validate({
              rules: {
                product_name_u: {
                  required: true,
                  maxlength: 40
                }
              },
              messages: {
                product_name_u: {
                  required: '提案したい商材1を入力してください。',
                  maxlength: '40文字以内で入力して下さい',
                }
              },
              submitHandler: function (form) {
                form.submit();
              }
            });
          });
        </script>
        <form action="/products/?product-update=1" method="get" id="product-edit-from-product-page">
          <div class="form-group">
            <label for="exampleInputEmail1">提案したい商材1</label>
            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
              id="product_name_u" name="product_name_u"
              value="<?php $p1 = $seconddb->get_var("SELECT product_1 FROM vendor WHERE email='$_email'"); echo $p1; ?>">
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">上記商材のURL</label>
            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
              id="product_page_u" name="product_page_u"
              value="<?php $p1_h = $seconddb->get_var("SELECT product_url_1 FROM vendor WHERE email='$_email'"); echo $p1_h; ?>">
          </div><br>
          <input type="hidden" name="product-update" value="1">
          <button type="submit" class="btn btn-primary btn-block">更新</button>
        </form>
        <?php }
                        }
                        ?>
      </div>
    </div>


    <?php $p2 = $seconddb->get_var("SELECT product_2 FROM vendor WHERE email='$_email'");

    if($p2){ ?>
          <div class="col-sm-12 col-md-4 col-lg-4" style="margin: 40px 0 40px 0;">
      <form id="cart_adjust" method="post">
        <div class="card text-center" style="box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;">
          <div class="card-body" style="min-height: 153px;">
            <h5 class="card-title">
              <?php $p2 = $seconddb->get_var("SELECT product_2 FROM vendor WHERE email='$_email'"); echo $p2; ?></h5>
            <hr>
            <p class="card-text text-primary">
              <u><?php $p2_h = $seconddb->get_var("SELECT product_url_2 FROM vendor WHERE email='$_email'"); echo $p2_h; ?></u>
            </p>
          </div>
          <div class="card-footer text-muted">
            <input type="hidden" id="product_name" name="product_name"
              value="<?php $p2 = $seconddb->get_var("SELECT product_2 FROM vendor WHERE email='$_email'"); echo $p2; ?>">
            <input type="hidden" id="product_page" name="product_page"
              value="<?php $p2_h = $seconddb->get_var("SELECT product_url_2 FROM vendor WHERE email='$_email'"); echo $p2_h; ?>">
            <button type="submit" class="btn btn-sm btn-primary">この商材を提案希望</button>
            <a href="/products/?product-edit=2" class="btn btn-sm btn-danger">編集</a>
          </div>
        </div>
      </form>
      <div class="edit-product" style="padding-top: 33px;
    line-height: 37px;">
        <?php
                        if(isset($_GET['product-edit']) & !empty($_GET['product-edit']) ){
                            if($_GET['product-edit'] == 2){ ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>

        <script>
          $(document).ready(function () {
            $('#product-edit-from-product-page').validate({
              rules: {
                product_name_u: {
                  required: true,
                  maxlength: 40
                }
              },
              messages: {
                product_name_u: {
                  required: '提案したい商材1を入力してください。',
                  maxlength: '40文字以内で入力して下さい',
                }
              },
              submitHandler: function (form) {
                form.submit();
              }
            });
          });
        </script>
        <form action="/products/?product-update=2" method="get" id="product-edit-from-product-page">
          <div class="form-group">
            <label for="exampleInputEmail1">提案したい商材2</label>
            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
              id="product_name_u" name="product_name_u"
              value="<?php $p2 = $seconddb->get_var("SELECT product_2 FROM vendor WHERE email='$_email'"); echo $p2; ?>">
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">上記商材のURL</label>
            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
              id="product_page_u" name="product_page_u"
              value="<?php $p2_h = $seconddb->get_var("SELECT product_url_2 FROM vendor WHERE email='$_email'"); echo $p2_h; ?>">
          </div><br>
          <input type="hidden" name="product-update" value="2">
          <button type="submit" class="btn btn-primary btn-block">更新</button>
        </form>
        <?php }
                        }
                        ?>
      </div>
    </div>
    <?php }
    
    ?>


<?php $p3 = $seconddb->get_var("SELECT product_3 FROM vendor WHERE email='$_email'");
if($p3){ ?>
    <div class="col-sm-12 col-md-4 col-lg-4" style="margin: 40px 0 40px 0;">
      <form id="cart_adjust" method="post">
        <div class="card text-center" style="box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;">
          <div class="card-body" style="min-height: 153px;">
            <h5 class="card-title">
              <?php $p3 = $seconddb->get_var("SELECT product_3 FROM vendor WHERE email='$_email'"); echo $p3; ?></h5>
            <hr>
            <p class="card-text text-primary">
              <u><?php $p3_h = $seconddb->get_var("SELECT product_url_3 FROM vendor WHERE email='$_email'"); echo $p3_h; ?></u>
            </p>
          </div>
          <div class="card-footer text-muted">
            <input type="hidden" id="product_name" name="product_name"
              value="<?php $p3 = $seconddb->get_var("SELECT product_3 FROM vendor WHERE email='$_email'"); echo $p3; ?>">
            <input type="hidden" id="product_page" name="product_page"
              value="<?php $p3_h = $seconddb->get_var("SELECT product_url_3 FROM vendor WHERE email='$_email'"); echo $p3_h; ?>">
            <button type="submit" class="btn btn-sm btn-primary">この商材を提案希望</button>
            <a href="/products/?product-edit=3" class="btn btn-sm btn-danger">編集</a>
          </div>
        </div>
      </form>

      <div class="edit-product" style="padding-top: 33px;
    line-height: 37px;">
        <?php
        if(isset($_GET['product-edit']) & !empty($_GET['product-edit']) ){
        if($_GET['product-edit'] == 3){ ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>

        <script>
          $(document).ready(function () {
            $('#product-edit-from-product-page').validate({
              rules: {
                product_name_u: {
                  required: true,
                  maxlength: 40
                }
              },
              messages: {
                product_name_u: {
                  required: '提案したい商材1を入力してください。',
                  maxlength: '40文字以内で入力して下さい',
                }
              },
              submitHandler: function (form) {
                form.submit();
              }
            });
          });
        </script>
        <form action="/products/?product-update=3" method="get" id="product-edit-from-product-page">
          <div class="form-group">
            <label for="exampleInputEmail1">提案したい商材3</label>
            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
              id="product_name_u" name="product_name_u"
              value="<?php $p3 = $seconddb->get_var("SELECT product_3 FROM vendor WHERE email='$_email'"); echo $p3; ?>">
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">上記商材のURL</label>
            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
              id="product_page_u" name="product_page_u"
              value="<?php $p3_h = $seconddb->get_var("SELECT product_url_3 FROM vendor WHERE email='$_email'"); echo $p3_h; ?>">
          </div><br>
          <input type="hidden" name="product-update" value="3">
          <button type="submit" class="btn btn-primary btn-block">更新</button>
        </form>
        <?php }
                        }
                        ?>
      </div>


    </div>
<?php }
?>
    <?php }else{ ?>
    <div class="alert alert-warning" style="margin: 30px" role="alert">
      Please select a company first to choose product.
    </div>
    <?php } ?>
  </div>
</div>