<?php
/* 
Template Name: Cart 
*/  

get_header();

if(isset($_GET['remove-item']) & !empty($_GET['remove-item']) ){
    foreach($_SESSION['ec_apo_cart'] as $k => $v) {
        if($v['id'] == $_GET['remove-item'])
          unset($_SESSION['ec_apo_cart'][$k]);

          header("Location: /cart");
      }
}

if(isset($_GET['edit-item-update']) & !empty($_GET['edit-item-update']) ){
    foreach($_SESSION['ec_apo_cart'] as $k => $v) {
        if($v['id'] == $_GET['edit-item-update']){
            $_SESSION['ec_apo_cart'][$k]['method'] = $_GET['method_update'];
            $_SESSION['ec_apo_cart'][$k]['day1'] = $_GET['hope1_update'];
            $_SESSION['ec_apo_cart'][$k]['day2'] = $_GET['hope2_update'];
            $_SESSION['ec_apo_cart'][$k]['day3'] = $_GET['hope3_update'];
            $_SESSION['ec_apo_cart'][$k]['day1_time'] = $_GET['hope1_time_update'];
            $_SESSION['ec_apo_cart'][$k]['day2_time'] = $_GET['hope2_time_update'];
            $_SESSION['ec_apo_cart'][$k]['day3_time'] = $_GET['hope3_time_update'];
        }
    }
}



if(isset($_GET['edit-item']) & !empty($_GET['edit-item']) ){
    foreach($_SESSION['ec_apo_cart'] as $k => $v) {
        if($v['id'] == $_GET['edit-item']){
            ?>
<div class="container mt-5 mb-5">
  <div class="d-flex justify-content-center row">
    <div class="col-md-6" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;">
      <div class="d-flex flex-row justify-content-between align-items-center p-2 bg-white mt-4 px-3 rounded">
        <form id="cart_edit_update" method="get" action="/cart/?edit-item-update=<?php echo $_GET['edit-item']; ?>">
          <h4 class="control-label">Hope to discuss the method</h4>
          <p>
            <select class="form-control form-control-inline" name="method_update" id="_update">
              <option value="Online business negotiation"
                <?php if($_SESSION['ec_apo_cart'][$k]['method'] == 'Online business negotiation') echo "selected" ?>>
                Online business negotiation</option>
              <option value="Face-to-face business negotiation"
                <?php if($_SESSION['ec_apo_cart'][$k]['method'] == 'Face-to-face business negotiation') echo "selected" ?>>
                Face-to-face business negotiation</option>
            </select>
          </p>
          <br>
          <h4 class="control-label">Hope consultation day first hope</h4>
          <p>
            <input type="text" class="form-control mb-2" id="inlineFormInput" name="hope1_update"
              placeholder="yyyy/mm/dd" value="<?php echo $_SESSION['ec_apo_cart'][$k]['day1'] ?>">
            <input type="text" class="form-control mb-2" id="inlineFormInput" name="hope1_time_update"
              placeholder="00:00" value="<?php echo $_SESSION['ec_apo_cart'][$k]['day1_time'] ?>">
          </p>
          <br>
          <h4 class="control-label">2nd hope</h4>
          <p>
            <input type="text" class="form-control mb-2" id="inlineFormInput" name="hope2_update"
              placeholder="yyyy/mm/dd" value="<?php echo $_SESSION['ec_apo_cart'][$k]['day2'] ?>">
            <input type="text" class="form-control mb-2" id="inlineFormInput" name="hope2_time_update"
              placeholder="00:00" value="<?php echo $_SESSION['ec_apo_cart'][$k]['day1_time'] ?>">
          </p>
          <br>
          <h4 class="control-label">3rd Hope</h4>
          <p>
            <input type="text" class="form-control mb-2" id="inlineFormInput" name="hope3_update"
              placeholder="yyyy/mm/dd" value="<?php echo $_SESSION['ec_apo_cart'][$k]['day3'] ?>">
            <input type="text" class="form-control mb-2" id="inlineFormInput" name="hope3_time_update"
              placeholder="00:00" value="<?php echo $_SESSION['ec_apo_cart'][$k]['day1_time'] ?>">
          </p>
          <input type="hidden" name="edit-item-update" value="<?php echo $_GET['edit-item']; ?>">
          <button class="btn btn-danger btn-sm" type="submit" type="submit">Update</button>

        </form>
      </div>
    </div>
  </div>
</div>
<?php }
      }
}

if(isset($_SESSION['ec_apo_cart'])){ ?>
<div class="container mt-5 mb-5">
  <div class="row">
    <div class="col-md-8">
      <?php 
    foreach($_SESSION['ec_apo_cart'] as $key => $val){ ?>
      <div class="container mt-5 mb-5">
        <div class="row">
          <div class="col" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;">
            <?php
                    if(isset($_GET['action']) & !empty($_GET['action']) ){
                        if($_GET['action'] == "added"){ ?>
            <div class="alert alert-success col-lg-5 col-md-5" role="alert" style="margin: 20px">
              ✅ 追加されました。
            </div>
            <?php  }
                    }
                ?>
            <div class="d-flex flex-row justify-content-between align-items-center p-2 bg-white mt-4 px-3 rounded">
              <div class="mr-1"><img class="rounded" src="https://s.wordpress.com/mshots/v1/http://www.realideal.jp"
                  width="70"></div>
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
                <h5 class="text-grey">¥<?php echo $val['amount'] ?></h5>
              </div>
              <div class="d-flex align-items-center">
                <a href="/cart/?remove-item=<?php echo $val['id']; ?>" style="font-size: 25px"><i
                    class="fa fa-trash mb-1 text-danger"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php } ?>
      <div class="d-flex justify-content-center row">
        <div class="col-md-6">
          <div class="">
            <?php
        $count = 0;
        if(isset($_SESSION['ec_apo_cart'])){
            foreach($_SESSION['ec_apo_cart'] as $key => $val){
                $count++;
            }
            if($count > 0){ ?>

            <?php }else{ ?>
            <div class="alert alert-warning" style="margin: 30px" role="alert">
              カートが空です
            </div>
            <hr>
            <a href="/search" class="btn btn-danger btn-sm" style="width: 100%;margin-bottom: 30px;">アポ依頼する会社を探す</a>
            <?php }
        }
        ?>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-4" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;">
      <?php
            $total = 0;
            $count = 0;
            if(isset($_SESSION['ec_apo_cart'])){
                foreach($_SESSION['ec_apo_cart'] as $key => $val){
                    $count++;
                    $each_amount = str_replace(',', '', $val['amount']);
                     $total+=$each_amount ;
                     ?>
      <?php } ?>
      <h3 style="padding-top: 30px; padding-bottom: 15px; color: blue"><?php echo $count . " 社へ依頼" ;  ?></h3>
      <h2 style="padding: 20px 0; color: red; font-size: 20px"><?php echo "合計: ¥" .  number_format($total); ?></h2>
      <center>
      <p style="color:#383aff;font-weight:bold;">商材は後程入力</p>
      <center>
      <div class="row" style="padding-top: 20px">
        <div class="col text-center">
          <a href="/products" style="font-size: 20px;
                  border-radius: 20px;" class="btn btn-sm btn-primary">アポ依頼へ進む<?php echo "(" . $count . "社)" ;  ?></a>
        </div>
      </div>
      <?php } ?>
    </div>

  </div>
</div>
<?php } else{ ?>
<div class="container">
  <div class="alert alert-warning" style="margin: 30px" role="alert">
    カートが空です
  </div>
  <hr>
  <a href="/search.php" class="btn btn-danger btn-sm" style="width: 100%;margin-bottom: 30px;">アポ依頼する会社を探す</a>
</div>
<?php } ?>

<hr><br>
<style>
div.linktext {
  color: black;
  line-height: 2em;
}

div.linktext:hover {
  color: #e47911;
}

span.star {
  color: #FFA41C;
  -webkit-text-stroke: 1px #FF0000;
  text-stroke: 1px #FF0000;
}
</style>
<div class="container" style="padding-bottom: 80px;">
  <h4 style="padding: 40px">他の方は下記会社とも商談しています</h4>
  <main class="l-main">

    <?php

//データベース接続
$server = "mysql14.onamae.ne.jp";  
$userName = "2m5l9_ecapo"; 
$password = "sh0-s19y^1Sa"; 
$dbName = "2m5l9_ecapo";
 
$mysqli = new mysqli($server, $userName, $password,$dbName);
 
if ($mysqli->connect_error){
	exit();
}else{
	$mysqli->set_charset("utf-8");
}

$sql = "SELECT * FROM userlist WHERE listflag = 'on' ORDER BY RAND() LIMIT 3";

$result = $mysqli -> query($sql);

if(!$result) {
	exit();
}
 

$row_count = $result->num_rows;
 

while($row = $result->fetch_array(MYSQLI_ASSOC)){
	$rows[] = $row;
}
 

$result->free();
$mysqli->close();

?>


    <div class="l-inner">
      <div class="p-blog-archive">

        <?php 
foreach((array)$rows as $row){
?>

        <article class="p-blog-archive__item">
          <a class="p-hover-effect--type1"
            href="/company?userid=<?php echo htmlspecialchars($row['userid'],ENT_QUOTES,'UTF-8'); ?>" target="_blank">
            <div class="p-blog-archive__item-thumbnail p-hover-effect__image js-object-fit-cover">
          <?php if ($row['urlimgcheck'] == '3'): ?>
          <img
            src="https://s.wordpress.com/mshots/v1/<?php echo htmlspecialchars($row['homepage'],ENT_QUOTES,'UTF-8'); ?>"
            alt="" width="740" height="460" class="attachment-size3 size-size3 wp-post-image" />
          <?php elseif($row['urlimgcheck'] == '1') : ?>
          <img src="https://ec-apo.com/url/<?php echo htmlspecialchars($row['userid'],ENT_QUOTES,'UTF-8'); ?>.png" width="740" height="460"
            class="attachment-size3 size-size3 wp-post-image" />
          <?php else : ?>
          <img src="https://ec-apo.com/img/nowprinting.png" width="740" height="460"
            class="attachment-size3 size-size3 wp-post-image" />
          <?php endif; ?>
            </div>
            <div class="linktext">
              <?php echo htmlspecialchars($row['company'],ENT_QUOTES,'UTF-8'); ?><br>
              <?php echo htmlspecialchars($row['pref'],ENT_QUOTES,'UTF-8'); ?><?php echo htmlspecialchars($row['city'],ENT_QUOTES,'UTF-8'); ?><?php echo htmlspecialchars($row['addr'],ENT_QUOTES,'UTF-8'); ?><br>
              商談相手：<?php echo htmlspecialchars($row['position'],ENT_QUOTES,'UTF-8'); ?><br>
              項目充実度：<span class="star"><?php echo htmlspecialchars($row['star'],ENT_QUOTES,'UTF-8'); ?></span><br>
              業種：<?php echo htmlspecialchars($row['jobs'],ENT_QUOTES,'UTF-8'); ?>　<?php echo htmlspecialchars($row['jobs2'],ENT_QUOTES,'UTF-8'); ?>　<?php echo htmlspecialchars($row['jobs3'],ENT_QUOTES,'UTF-8'); ?>　<?php echo htmlspecialchars($row['jobs4'],ENT_QUOTES,'UTF-8'); ?><br>
              商談設定金額：<span class="red">¥<?php echo htmlspecialchars($row['paycost'],ENT_QUOTES,'UTF-8'); ?></span><br>
            </div>
          </a>
        </article>

        <?php 
} 
?>

      </div>
    </div>
  </main>
</div>