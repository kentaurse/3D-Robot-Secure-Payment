<?php
/* 
Template Name: Company 
*/  
get_header();   
$userid = $_GET['userid'];
$_email = $_SESSION['apo_log_mail'];

$rebate_rate = getRebateForCompany($userid);

global $seconddb;
$is_favorite = $seconddb->get_var($seconddb->prepare("SELECT id FROM favorites WHERE seller_id = %s AND company_id = %d", $_email, $userid));

function cart_adjuct(){
	$userid = $_GET['userid'];
	$status="";
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

	$sql = "SELECT * FROM userlist WHERE userid = '$userid' AND searchflag IS NULL";
	$result = $mysqli -> query($sql);
	
	if(!$result) {
		exit();
	}
	
	$row = mysqli_fetch_assoc($result);
	$rebate_rate = getRebateForCompany($userid);

	$company = $row['company'];
	$address = $row['pref'].$row['city'].$row['addr'];
	$negotiation_partner = $row['position'];
  $email = $row['mail'];
  $tel = $row['tel'];
  $homepage = $row['homepage'];
	$amount = $row['paycost'];
	if ($rebate_rate > 0) {
		$amount = str_replace(",", "", $amount);
		$amount = ceil($amount * (1 - $rebate_rate / 100));
		$amount = number_format($amount, 0, '.', ',');
	}
	$method = $_POST['method'];
	$day1 = $_POST['hope1'];
	$day2 = $_POST['hope2'];
	$day3 = $_POST['hope3'];
	$day1_time = '-';
	$day2_time = '-';
	$day3_time = '-';
	
  if($_POST['hope1_time_min'] != ''){
    $day1_time = $_POST['hope1_time_h'].":".$_POST['hope1_time_min'];
  };

  if($_POST['hope2_time_min'] != ''){
    $day2_time = $_POST['hope2_time_h'].":".$_POST['hope2_time_min'];
  };

  if($_POST['hope3_time_min'] != ''){
    $day3_time = $_POST['hope3_time_h'].":".$_POST['hope3_time_min'];
  };
	
	$result->free();
	$mysqli->close();



	$_SESSION['ec_apo_cart'][] = array(
		'id' => rand(),
    'company_id' => $_GET['userid'],
		'company'=>$company,
    'email' =>  $email,
    'tel' => $tel,
    'homepage' => $homepage,
		'address'=>$address,
		'negotiation_partner'=>$negotiation_partner,
		'amount'=>$amount,
		'method'=>$method,
		'day1'=>$day1,
		'day2'=>$day2,
		'day3'=>$day3,
		'day1_time'=>$day1_time,
		'day2_time'=>$day2_time,
		'day3_time'=>$day3_time,
	   );
	   
	   header("Location: /cart/?action=added");

}

?>
<style>
.p-article-news__date,
.p-wc-headline,
#wdgctToCart a {
  color: #383aff;
}

.p-button,
.p-global-nav .sub-menu .current-menu-item>a,
.p-page-links>span,
.p-pager__item .current,
.p-headline,
.p-widget-sidebar .p-widget__title,
.c-comment__form-submit:hover,
c-comment__password-protected,
.c-pw__btn--register,
.c-pw__btn,
.slick-arrow,
.slick-dots li.slick-active button,
.widget_welcart_login input#member_loginw,
.widget_welcart_login input#member_login,
#wdgctToCheckout a {
  background-color: #383aff;
}

.p-page-links>span,
.p-pager__item .current,
.slick-dots li.slick-active button,
.p-cb__item-header,
.p-entry-item__cart dl.item-sku dd input[type="radio"]:checked+label,
.p-entry-item__cart dl.item-sku dd label:hover {
  border-color: #383aff;
}

.c-comment__tab-item.is-active a,
.c-comment__tab-item a:hover,
.c-comment__tab-item.is-active p {
  background-color: #383aff;
  border-color: #383aff;
}

.c-comment__tab-item.is-active a:after,
.c-comment__tab-item.is-active p:after {
  border-top-color: #383aff;
}

.p-widget-categories .current-cat-item>a {
  background-color: rgba(56, 58, 255, 0.15);
}

a:hover,
.p-header__welcart-nav li a:hover,
.p-widget-categories .toggle-children:hover,
#wdgctToCart a:hover {
  color: #1e73be;
}

.p-button:hover,
.p-page-links a:hover,
.p-pager__item a:hover,
.p-search-button:hover,
.p-pagetop a:hover,
.p-footer-search__submit:hover,
.p-widget .searchform #searchsubmit:hover,
.p-widget-search .p-widget-search__submit:hover,
a.p-cb__item-archive-button:hover,
.slick-arrow:hover,
.slick-dots li:hover button,
.widget_welcart_search #searchsubmit:hover,
.widget_welcart_login input#member_loginw:hover,
.widget_welcart_login input#member_login:hover,
#wdgctToCheckout a:hover {
  background-color: #1e73be;
}

.p-page-links a:hover,
.p-pager__item a:hover,
.slick-dots li:hover button {
  border-color: #1e73be;
}

.p-entry__body a,
.custom-html-widget a {
  color: #383aff;
}

.p-entry__body a:hover,
.custom-html-widget a:hover {
  color: #1e73be;
}

body,
input,
textarea,
.p-entry-item__title .p-article__soldout {
  font-family: Verdana, "Hiragino Kaku Gothic ProN", "ヒラギノ角ゴ ProN W3", "メイリオ", Meiryo, sans-serif;
}

.p-logo,
.p-entry__title,
.p-page-header__title,
.p-index-slider__item-catch,
.p-cb__item-headline,
.p-index-banner__headline,
.p-index-boxes__item-headline {
  font-family: "Times New Roman", "游明朝", "Yu Mincho", "游明朝体", "YuMincho", "ヒラギノ明朝 Pro W3", "Hiragino Mincho Pro", "HiraMinProN-W3", "HGS明朝E", "ＭＳ Ｐ明朝", "MS PMincho", serif;
  font-weight: 500;
}

.c-load--type1 {
  border: 3px solid rgba(153, 153, 153, 0.2);
  border-top-color: #000000;
}

.p-hover-effect--type1:hover img {
  -webkit-transform: scale(1.2) rotate(2deg);
  transform: scale(1.2) rotate(2deg);
}

.p-hover-effect--type2 img {
  margin-left: -8px;
}

.p-hover-effect--type2:hover img {
  margin-left: 8px;
}

.p-hover-effect--type2:hover .p-hover-effect__image {
  background: #000000;
}

.p-hover-effect--type2:hover img {
  opacity: 0.5
}

.p-hover-effect--type3:hover .p-hover-effect__image {
  background: #000000;
}

.p-hover-effect--type3:hover img {
  opacity: 0.5;
}

.p-entry__title {
  font-size: 32px;
}

.p-entry__title,
.p-article__title {
  color: #000000
}

.p-entry__body {
  font-size: 14px;
}

.p-entry__body {
  color: #000000;
}

body.page .p-entry__body {
  font-size: 14px;
}

.p-entry-news__title {
  font-size: 28px;
}

.p-entry-news__title,
.p-article-news__title {
  color: #000000
}

.p-entry-news__body {
  color: #000000;
  font-size: 14px;
}

.p-entry-item__title {
  font-size: 28px;
}

.p-entry-item__title,
.p-article-item__title,
.p-article__price {
  color: #000000;
}

.p-entry-item__body,
p-wc__body {
  color: #000000;
  font-size: 14px;
}

.p-price {
  color: #d80000;
}

.p-entry-item__price {
  font-size: 22px;
}

body.l-header__fix .is-header-fixed .l-header__bar {
  background: rgba(56, 58, 255, 1);
}

.l-header {
  background: rgba(56, 58, 255, 1);
}

.l-header a,
.p-global-nav a {
  color: #ffffff;
}

.p-header__logo--text {
  font-size: 36px;
}

.p-header__welcart-nav__member a,
.p-header__welcart-nav__cart a,
.p-cart-button .p-header__welcart-nav__badge {
  background-color: #0097cc;
}

.p-header__welcart-nav__member a:hover,
.p-header__welcart-nav__cart a:hover,
.p-cart-button:hover .p-header__welcart-nav__badge {
  background-color: #006689;
}

.p-global-nav>li>a::after,
.p-global-nav>li.current-menu-item>a::after {
  background-color: #000000;
}

.p-megamenu__bg,
.p-global-nav .sub-menu {
  background-color: #f7f7f7;
}

.p-megamenu a,
.p-global-nav .sub-menu a {
  color: #000000;
}

.p-megamenu a:hover,
.p-megamenu li.is-active>a,
.p-global-nav .sub-menu a:hover {
  background-color: #006689;
  color: #ffffff;
}

.p-page-header {
  background-color: #f7f7f7;
}

.p-page-header__title {
  color: #0097cc;
}

.p-page-header__desc {
  color: #000000;
}

.p-footer-widget-area {
  background-color: #383aff;
  color: #ffffff;
}

.p-footer-widget-area .p-widget__title {
  color: #000000;
}

.p-footer-widget-area a,
.p-footer-widget-area .toggle-children {
  color: #ffffff;
}

.p-footer-widget-area a:hover {
  color: #006689;
}

@media only screen and (max-width: 991px) {
  .l-header__bar {
    background-color: rgba(56, 58, 255, 1);
  }

  .p-header__logo--text {
    font-size: 26px;
  }

  .p-global-nav {
    background-color: rgba(247, 247, 247, 1);
  }

  .p-global-nav a {
    color: #000000;
  }

  .p-global-nav a:hover {
    background-color: rgba(0, 102, 137, 1);
    color: #ffffff;
  }

  .p-header-view-cart {
    background-color: rgba(255, 255, 255, 1);
  }

  .p-entry__title {
    font-size: 20px;
  }

  .p-entry__body {
    font-size: 14px;
  }

  .p-entry-news__title {
    font-size: 20px;
  }

  .p-entry-news__body {
    font-size: 14px;
  }

  body.page .p-entry__body {
    font-size: 14px;
  }

  .p-entry-item__title {
    font-size: 20px;
  }

  .p-entry-item__body,
  p-wc__body {
    font-size: 14px;
  }

  .p-entry-item__price {
    font-size: 20px;
  }
}

h1.p-logo a img {
  width: 200px;
  padding: 2% 0% 0% 0%;
}


div.p-logo a img {
  width: 200px;
  padding: 2% 0% 0% 0%;
}

div#child2 a:link {
  text-decoration: underline;
}

div#child2 {
  text-align: center;
}

div#child2 select {
  height: 40px;
  width: 80%;
  border-radius: 5px;
  border: 1px solid #ccc;
  padding: 0 10px;
  color: #000;
}

div.topform {
  border-radius: 6%;
  background-color: #383aff;
  padding: 1%;
  color: #fff;
  font-size: 1.5em;
}

input.submit {
  height: 40px;
  width: 80%;
  border-radius: 5px;
  border: 1px solid #ccc;
  padding: 0 10px;
  background: #fff;
  color: #383aff;
  font-weight: bold;
}


input.submit:hover {
  height: 40px;
  width: 80%;
  border-radius: 5px;
  border: 2px solid #fff;
  padding: 0 10px;
  background: #383aff;
  color: #fff;
  font-weight: bold;
}
</style>
<style type="text/css">
:root {
  --gothic: "Hiragino Kaku Gothic ProN", "ヒラギノ角ゴ ProN W3", "游ゴシック", "Yu Gothic", sans-serif
}

dd,
dl,
dt,
h1,
h2,
h3,
h4,
h5,
h6,
header,
html,
img,
li,
ol,
p,
ul {
  background: 0 0;
  border: 0;
  box-sizing: border-box;
  font-size: 100%;
  font-weight: 400;
  margin: 0;
  outline: 0;
  padding: 0;
  vertical-align: baseline;
  word-break: break-all;
  word-wrap: break-word
}

body {
  line-height: 1
}

body * {
  box-sizing: border-box
}

footer,
header {
  display: block
}

ol,
ul {
  list-style: none
}

table {
  border-collapse: collapse
}

button,
input[type=button],
input[type=email],
input[type=submit],
input[type=tel],
input[type=text],
textarea {
  -moz-appearance: none;
  -webkit-appearance: none;
  appearance: none;
  background: 0 0;
  border: none;
  border-radius: 0;
  cursor: pointer;
  font-family: var(--gothic), sans-serif;
  font-size: 16px;
  font-size: 1.6rem;
  margin: 0;
  outline: 0;
  padding: 0;
  vertical-align: middle
}

button,
input[type=button],
input[type=submit] {
  cursor: pointer
}

img {
  display: block;
  height: auto;
  margin: 0 auto;
  max-width: 100%
}

@media screen and (min-width:599px) {
  a[href*="tel:"] {
    color: #000;
    cursor: default;
    pointer-events: none;
    text-decoration: none
  }
}

body,
html {
  background: #fff;
  height: 100%
}

html {
  font-family: var(--gothic);
  font-size: 62.5%
}

b,
strong {
  font-weight: 700
}

.inner {
  max-width: 800px;
  margin: 0 auto;
  position: relative
}

.cnt-qa {
  padding: 0 0 40px
}

.cnt-qa dl {
  margin: 60px auto 20px
}

.cnt-qa dd,
.cnt-qa dt {
  font-size: 20px;
  font-size: 2rem;
  font-weight: 700;
  line-height: 1.6;
  padding: 20px 20px 20px 80px;
  position: relative;
  text-align: justify
}

.cnt-qa dd::before,
.cnt-qa dt::before {
  font-size: 32px;
  font-size: 3.2rem
}

.cnt-qa dt::before {
  align-items: center;
  background: #012c8b;
  border-radius: 50%;
  color: #fff;
  content: "Q";
  display: flex;
  height: 40px;
  justify-content: center;
  left: 20px;
  position: absolute;
  top: 15px;
  width: 40px
}

.cnt-qa dt::after {
  border-right: 3px solid #012c8b;
  border-top: 3px solid #012c8b;
  content: "";
  display: block;
  height: 10px;
  margin-top: -10px;
  position: absolute;
  right: 20px;
  top: 50%;
  transform: rotate(135deg);
  transition: .4s;
  width: 10px
}

.cnt-qa dd::before {
  color: #e6241d;
  content: "A";
  left: 27px;
  position: absolute;
  top: 8px
}

.cnt-qa dt {
  background: #fff;
  border-radius: 10px;
  cursor: pointer;
  margin-top: 10px
}

.cnt-qa dt.open {
  border-radius: 10px 10px 0 0
}

.cnt-qa dt.open::after {
  margin-top: -5px;
  transform: rotate(-45deg)
}

.cnt-qa dd {
  background: #f0f0f0;
  border-radius: 0 0 10px 10px;
  display: none;
  font-size: 18px;
  font-size: 1.8rem;
  font-weight: 400
}


.p-blog-archive__item {
  padding: 2%;
}

.star {
  color: #FFA41C;
  -webkit-text-stroke: 1px #FF0000;
  text-stroke: 1px #FF0000;
}


#parent1 {
  padding: 3%;
}

#child11 {
  width: 40%;
  padding: 2%;
}

#child12 {
  width: 30%;
  padding: 2%;
}

#child13 {
  width: 30%;
  padding: 2%;
  -webkit-box-shadow: rgb(17 17 26 / 10%) 0px 0px 16px;
  box-shadow: rgb(17 17 26 / 10%) 0px 0px 16px;
  position: relative;
  height: fit-content;
}

#child12 img {
  margin: 0;
}


@media (min-width: 600px) {
  #parent1 {
    display: flex;
  }

  #child11 {
    flex-grow: 1;
  }

  #child12 {
    flex-grow: 1;
  }

  #child13 {
    flex-grow: 1;
  }
}

@media (max-width: 599px) {
  #child11 {
    width: 100%;
  }

  #child12 {
    width: 100%;
  }

  #child13 {
    width: 100%;
    -webkit-box-shadow: -1px 0px 5px 0px #000000;
    box-shadow: -1px 0px 5px 0px #000000;
  }
}



#parent2 {
  max-width: 1000px;
  padding: 1%;
}

#child21 {
  width: 50%;
}

#child22 {
  width: 50%;
}



@media (min-width: 600px) {
  #parent2 {
    display: flex;
  }

  #child21 {
    flex-grow: 1;
  }

  #child22 {
    flex-grow: 1;
  }
}

@media (max-width: 599px) {
  #child21 {
    width: 100%;
    padding: 1% 0%;
  }

  #child22 {
    width: 100%;
    padding: 1% 0%;
  }
}

table.status {
  width: 100%;
  table-layout: fixed;
}



th.statusth {
  width: 50%;
  vertical-align: middle;
  text-align: center;
  background-color: #F3F3F3;
  padding: 3%;
  border-collapse: collapse;
  border-top: 1px solid #E6E6E6;
  border-right: 0px solid #E6E6E6;
  border-bottom: 1px solid #E6E6E6;
  border-left: 1px solid #E6E6E6;
}

td.statustd {
  width: 50%;
  vertical-align: middle;
  text-align: center;
  padding: 3%;
  border-collapse: collapse;
  border-top: 1px solid #E6E6E6;
  border-right: 1px solid #E6E6E6;
  border-bottom: 1px solid #E6E6E6;
  border-left: 0px solid #E6E6E6;
}

.yellowbacktext {
  width: 100%;
  padding: 1%;
  background-color: #FFF2CC;
}


div.aboutbox {
  width: 100%;
  padding: 1%;
  max-width: 1000px;
}

table.about {
  width: 100%;
  table-layout: fixed;
}

th.aboutth {
  width: 25%;
  vertical-align: middle;
  text-align: center;
  background-color: #F3F3F3;
  padding: 3%;
  border-collapse: collapse;
  border-top: 1px solid #E6E6E6;
  border-right: 0px solid #E6E6E6;
  border-bottom: 1px solid #E6E6E6;
  border-left: 1px solid #E6E6E6;
}

td.abouttd {
  width: 75%;
  vertical-align: middle;
  text-align: center;
  padding: 3%;
  border-collapse: collapse;
  border-top: 1px solid #E6E6E6;
  border-right: 1px solid #E6E6E6;
  border-bottom: 1px solid #E6E6E6;
  border-left: 0px solid #E6E6E6;
}

.p-breadcrumb {
  margin-bottom: 0px;
}
	
.favorites-button {
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    border: 2px solid #ccc;
    padding: 1rem 1rem;
    font-size: 1.4rem;
    font-weight: bold;
    line-height: 0;
    margin: 0 auto 2rem;
    width: 25rem;
	cursor: pointer;
}

.favorites-button svg{
    width: 2.5rem;
    height: 2rem;
    margin-right: 1rem;
    fill: #0d6efd;
}

.is-active.favorites-button {
    color: #ccc;
}

.is-active.favorites-button svg {
    fill: #ccc;
}
</style>
<main class="l-main" style="font-size: 13px">
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
 
$sql = "SELECT * FROM userlist WHERE userid = '$userid' AND searchflag IS NULL";
 
$result = $mysqli -> query($sql);
 
//クエリー失敗
if(!$result) {
	exit();
}
 
//レコード件数
$row_count = $result->num_rows;
 
//連想配列で取得
while($row = $result->fetch_array(MYSQLI_ASSOC)){
	$rows[] = $row;
}
 
//結果セットを解放
$result->free();
 
// データベース切断
$mysqli->close();

?>


  <?php 
foreach((array)$rows as $row){
?>


  <header class="p-page-header">
    <div class="p-page-header__inner l-inner">
      <h1 class="p-page-header__title"><?php echo htmlspecialchars($row['company'],ENT_QUOTES,'UTF-8'); ?></h1>
    </div>
  </header>
  <div class="p-breadcrumb c-breadcrumb">
    <ul class="p-breadcrumb__inner c-breadcrumb__inner l-inner" itemscope itemtype="http://schema.org/BreadcrumbList">
      <li class="p-breadcrumb__item c-breadcrumb__item p-breadcrumb__item--home c-breadcrumb__item--home"
        itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
        <a href="https://ec-apo.com/" itemprop="item"><span itemprop="name">HOME</span></a>
        <meta itemprop="position" content="1" />
      </li>
      <li class="p-breadcrumb__item c-breadcrumb__item">
        <span itemprop="name"><?php echo htmlspecialchars($row['talkpref'],ENT_QUOTES,'UTF-8'); ?></span>
      </li>
      <li class="p-breadcrumb__item c-breadcrumb__item">
        <span itemprop="name"><?php echo htmlspecialchars($row['company'],ENT_QUOTES,'UTF-8'); ?></span>
      </li>
    </ul>
  </div>

  <div class="l-inner">
    <div class="p-blog-archive">
    <?php
      if(isset($_SESSION['ec_apo_cart'])){
        foreach($_SESSION['ec_apo_cart'] as $k => $v) {
          if($v['company_id'] == $_GET['userid']){  ?>
            <div class="alert alert-warning" role="alert" style="margin: 20px;">
            このアイテムはすでにカートに入っています。
            </div>
         <?php }
        }
      }
      ?>
      <div id="parent1">
        <div id="child11">
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
        <div id="child12">
          <h2 class="p-blog-archive__item-title p-article__title">
            <?php echo htmlspecialchars($row['company'],ENT_QUOTES,'UTF-8'); ?></h2>
          <br>
          <p class="p-blog-archive__item-price p-article__price">
            <?php echo htmlspecialchars($row['pref'],ENT_QUOTES,'UTF-8'); ?><?php echo htmlspecialchars($row['city'],ENT_QUOTES,'UTF-8'); ?><?php echo htmlspecialchars($row['addr'],ENT_QUOTES,'UTF-8'); ?>
          </p>
          <br>
          <p class="p-blog-archive__item-price p-article__price">
            商談相手：<?php echo htmlspecialchars($row['position'],ENT_QUOTES,'UTF-8'); ?></p>
          <br>
          <p class="p-blog-archive__item-price p-article__price">商談設定金額：
            <?php if($rebate_rate > 0) {?>
              <?php $old_price = htmlspecialchars($row['paycost'],ENT_QUOTES,'UTF-8'); ?>
              <?php $new_price = number_format(ceil(str_replace(",","",$old_price) * (1 - $rebate_rate / 100)), 0, '.', ',') ?>
              <span style="text-decoration: line-through;">
              ¥<?php echo $old_price ?></span>
              <span class="red">¥<?php echo $new_price ?><br>
            (期間限定 <?php echo $rebate_rate ?>%OFF)</span>
          <?php } else { ?>
            <span class="red">¥<?php echo htmlspecialchars($row['paycost'],ENT_QUOTES,'UTF-8') ?></span>
          <?php } ?>
        </p>
          <br>
          <p class="p-blog-archive__item-price p-article__price">項目充実度：<span
              class="star"><?php echo htmlspecialchars($row['star'],ENT_QUOTES,'UTF-8'); ?></span></p>
					<br>
					<br>
		<div class="favorites-button<?php echo $is_favorite ? ' is-active' : ''; ?>" id="fav-button">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
              <path d="M244 84L255.1 96L267.1 84.02C300.6 51.37 347 36.51 392.6 44.1C461.5 55.58 512 115.2 512 185.1V190.9C512 232.4 494.8 272.1 464.4 300.4L283.7 469.1C276.2 476.1 266.3 480 256 480C245.7 480 235.8 476.1 228.3 469.1L47.59 300.4C17.23 272.1 0 232.4 0 190.9V185.1C0 115.2 50.52 55.58 119.4 44.1C164.1 36.51 211.4 51.37 244 84C243.1 84 244 84.01 244 84L244 84zM255.1 163.9L210.1 117.1C188.4 96.28 157.6 86.4 127.3 91.44C81.55 99.07 48 138.7 48 185.1V190.9C48 219.1 59.71 246.1 80.34 265.3L256 429.3L431.7 265.3C452.3 246.1 464 219.1 464 190.9V185.1C464 138.7 430.4 99.07 384.7 91.44C354.4 86.4 323.6 96.28 301.9 117.1L255.1 163.9z"/>
            </svg>
            <?php if ($is_favorite): ?>
              <div>追加済み</div>
            <?php else: ?>
              <div>お気に入り追加</div>
            <?php endif; ?>
          </div>
        <script>
          jQuery(function ($) {
            $('#fav-button').on('click', function () {
              if (<?php echo $_email ? 'true' : 'false'; ?>) {
                $.ajax({
                  url: '<?php echo admin_url('admin-ajax.php'); ?>',
                  type: 'POST',
                  data: {
                    'action': 'favorite_toggle',
                    'company_id': '<?php echo $row['userid']; ?>',
                    'seller_id': '<?php echo $_email; ?>'
                  },
                  success: function (data) {
                    if(data['error']) {
                      alert(data['message']);
                    } else {
                      if (data['action'] == 'add') {
                        $('#fav-button').addClass('is-active');
                        $('#fav-button div').text('追加済み');
                      } else {
                        $('#fav-button').removeClass('is-active');
                        $('#fav-button div').text('お気に入り追加');
                      }
                    }
                  }
                });
              } else {
                window.location.href = 'https://ec-apo.com/login/?action=must_login&return_to=company&userid=<?php echo $userid; ?>';
              }
            });
          });
        </script>
        </div>
        <div id="child13">
          <form id="cart_adjust" method="post">
            <div id="price_setting_dialogue">
              <h3 class="text-center text-danger">商談設定金額:
                 <?php if($rebate_rate > 0) {?>
              <?php $old_price = htmlspecialchars($row['paycost'],ENT_QUOTES,'UTF-8'); ?>
              <?php $new_price = number_format(ceil(str_replace(",","",$old_price) * (1 - $rebate_rate / 100)), 0, '.', ',') ?>
              <span style="text-decoration: line-through;">
              ¥<?php echo $old_price ?></span>
              <span class="red">¥<?php echo $new_price ?><br>
            (期間限定 <?php echo $rebate_rate ?>%OFF)</span>
          <?php } else { ?>
            ¥<?php echo htmlspecialchars($row['paycost'],ENT_QUOTES,'UTF-8') ?>
          <?php } ?>
				</h3>
              <hr>
              <h4 class="control-label" style="font-weight: 600; padding-bottom: 3px">希望商談方法</h4>
              <p>
                <select class="form-control form-control-inline form-select" name="method" id="method" aria-label="Default select example" required>
                <option value="" disabled selected>選択して下さい</option>
                  <option value="オンライン商談">オンライン商談</option>
                  <option value="対面商談">対面商談</option>
                </select>
              </p>
              <br>
              <h4 class="control-label" style="font-weight: 600; padding-bottom: 3px">希望商談日(直近)</h4>
              <p>
                <input type="date" class="form-control mb-2" id="inlineFormInput" name="hope1" placeholder="yyyy/mm/dd" 
                min="<?php
                date_default_timezone_set("Asia/Tokyo");
                $now = time();
                $enc_minutes = $now + (0* 60 * 60);
                $day = date('Y-m-d', $enc_minutes);
                echo $day;
                ?>" required>
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
              </p>
              <br>
              <h4 class="control-label" style="font-weight: 600; padding-bottom: 3px">第2希望</h4>
              <p>
                <input type="date" class="form-control mb-2" id="inlineFormInput" name="hope2" placeholder="yyyy/mm/dd"
                min="<?php echo date_i18n('Y-m-d', strtotime('+5 day')); ?>" required>
							<div id="hope1_date_error" style="display:none; padding: 0.5rem; color: blue; background: yellow; border-radius: 5px; margin-bottom: 1rem;  animation: flash 1s linear infinite;">先方の都合により<?php echo date_i18n('Y/m/d', strtotime('+5 day')); ?>以降の日付をご選択ください。</div>
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
              </p>
              <br>
              <h4 class="control-label" style="font-weight: 600; padding-bottom: 3px">第3希望</h4>
              <p>
                <input type="date" class="form-control mb-2" id="inlineFormInput" name="hope3" placeholder="yyyy/mm/dd"
                min="<?php echo date_i18n('Y-m-d', strtotime('+10 day')); ?>" required>
							<div id="hope1_date_error" style="display:none; padding: 0.5rem; color: blue; background: yellow; border-radius: 5px; margin-bottom: 1rem;  animation: flash 1s linear infinite;">先方の都合により<?php echo date_i18n('Y/m/d', strtotime('+10 day')); ?>以降の日付をご選択ください。</div>
                <div class="row">
                  <div class="col-6">
                  <select name="hope3_time_h" id="hope3_time_h" class="form-select" aria-label="select" required>
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
                  <select name="hope3_time_min" id="hope3_time_min" class="form-select" aria-label="select" required>
                    <option value="" disabled selected>分</option>
                    <option value="00">00</option>
                    <option value="30">30</option>
                  </select>
                  </div>
                </div>
              </p><br>
              <center>
              <p style="color:#383aff;font-weight:bold;">商材は後程入力</p>
              </center><br>
              <?php
              if(isset($_SESSION['ec_apo_cart']) && !empty($_SESSION['ec_apo_cart'])){
                $is_added_in = false;
                foreach($_SESSION['ec_apo_cart'] as $k => $v) {
                  if($v['company_id'] == $_GET['userid']){
                    $is_added_in = true;
                    break; 
                     }
                }
              }

              if($is_added_in == false){ ?>
                  <button style="
                  font-size: 20px;
                  border-radius: 20px;
                  width: 100%;
                  " type="submit" class="btn btn-primary text-center">カートに入れる
                  </button>
            <?php  }else{ ?>
              <button style="
                  font-size: 20px;
                  border-radius: 20px;
                  width: 100%;
                  " type="" class="btn btn-primary text-center" disabled>カートに入れる
                  </button>
          <?php  }
              ?>
            </div>
          </form>
<!--                <?php $url = "/research?userid=".$_GET['userid']; ?>
          <div><a href="<?php echo $url ?>" class="btn" style="background-color: #77787b; color: white; border-radius: 20px; width: 50%; text-align: center; display: block; margin: 16px auto 0; font-size: 16px;">興味あり</a></div></div> -->
        </div>
      </div>
      <div id="parent2">
        <div id="child21">

          <table class="status">
            <tr>
              <th class="statusth">
                種別
              </th>
              <td class="statustd">
                <?php echo htmlspecialchars($row['type'],ENT_QUOTES,'UTF-8'); ?>
              </td>
            </tr>
            <tr>
              <th class="statusth">
                ホームページ
              </th>
              <td class="statustd">
                <?php if ($row['urlimgcheck'] == '2'): ?>
                　
                <?php else : ?>
                <a href="<?php echo htmlspecialchars($row['homepage'],ENT_QUOTES,'UTF-8'); ?>" target="_blank"
                  style="color:#383aff;"><?php echo htmlspecialchars($row['homepage'],ENT_QUOTES,'UTF-8'); ?></a>
                <?php endif; ?>
              </td>
            </tr>
            <tr>
              <th class="statusth">
                商談相手の役職
              </th>
              <td class="statustd">
                <?php echo htmlspecialchars($row['position'],ENT_QUOTES,'UTF-8'); ?>
              </td>
            </tr>
            <tr>
              <th class="statusth">
                対面商談する際の<br>所在都道府県
              </th>
              <td class="statustd">
                <?php echo htmlspecialchars($row['talkpref'],ENT_QUOTES,'UTF-8'); ?>
              </td>
            </tr>
            <tr>
              <th class="statusth">
                業種
              </th>
              <td class="statustd">
                <?php echo htmlspecialchars($row['jobs'],ENT_QUOTES,'UTF-8'); ?>　<?php echo htmlspecialchars($row['jobs2'],ENT_QUOTES,'UTF-8'); ?>　<?php echo htmlspecialchars($row['jobs3'],ENT_QUOTES,'UTF-8'); ?>　<?php echo htmlspecialchars($row['jobs4'],ENT_QUOTES,'UTF-8'); ?>
              </td>
            </tr>
          </table>
        </div>
        <div id="child22">

          <table class="status">
            <tr>
              <th class="statusth">
                設立
              </th>
              <td class="statustd">
                <?php echo htmlspecialchars($row['fromwhen'],ENT_QUOTES,'UTF-8'); ?>
              </td>
            </tr>
            <tr>
              <th class="statusth">
                資本金
              </th>
              <td class="statustd">
                <?php echo htmlspecialchars($row['money'],ENT_QUOTES,'UTF-8'); ?>
              </td>
            </tr>
            <tr>
              <th class="statusth">
                正社員人数
              </th>
              <td class="statustd">
                <?php echo htmlspecialchars($row['staff'],ENT_QUOTES,'UTF-8'); ?>
              </td>
            </tr>
            <tr>
              <th class="statusth">
                アルバイト人数
              </th>
              <td class="statustd">
                <?php echo htmlspecialchars($row['baito'],ENT_QUOTES,'UTF-8'); ?>
              </td>
            </tr>
          </table>

        </div>

      </div>

      <div class="aboutbox">

        <table class="about">
<!--          <tr>
            <th class="aboutth">
              事業概要
            </th>
            <td class="abouttd">
              <?php echo htmlspecialchars($row['about'],ENT_QUOTES,'UTF-8'); ?>
            </td>
          </tr> -->
          <tr>
            <th class="aboutth">
              興味/関心
            </th>
            <td class="abouttd">
              <?php echo htmlspecialchars($row['interest'],ENT_QUOTES,'UTF-8'); ?>
            </td>
          </tr>
        </table>

      </div>
      <?php 
} 
?>

    </div>
    
    <form id="cart_adjust" method="post" style="padding: 30px;
    box-shadow: rgb(17 17 26 / 10%) 0px 0px 16px;">
            <div id="price_setting_dialogue">
              <h3 class="text-center text-danger">商談設定金額:
               <?php if($rebate_rate > 0) {?>
              <?php $old_price = htmlspecialchars($row['paycost'],ENT_QUOTES,'UTF-8'); ?>
              <?php $new_price = number_format(ceil(str_replace(",","",$old_price) * (1 - $rebate_rate / 100)), 0, '.', ',') ?>
              <span style="text-decoration: line-through;">
              ¥<?php echo $old_price ?></span>
              <span class="red">¥<?php echo $new_price ?><br>
            (期間限定 <?php echo $rebate_rate ?>%OFF)</span></p>
          <?php } else { ?>
            ¥<?php echo htmlspecialchars($row['paycost'],ENT_QUOTES,'UTF-8') ?>
          <?php } ?>
				</h3>
              <hr>
              <h4 class="control-label" style="font-weight: 600; padding-bottom: 3px">希望商談方法</h4>
              <p>
                <select class="form-control form-control-inline" name="method" id="method" class="form-select" aria-label="Default select example" required>
                  <option value="" disabled selected>選択して下さい</option>
                  <option value="オンライン商談">オンライン商談</option>
                  <option value="対面商談">対面商談</option>
                </select>
              </p>
              <br>
              <h4 class="control-label" style="font-weight: 600; padding-bottom: 3px">希望商談日(直近)</h4>
              <p>
                <input type="date" class="form-control mb-2" id="inlineFormInput" name="hope1" placeholder="yyyy/mm/dd" 
                min="<?php
                date_default_timezone_set("Asia/Tokyo");
                $now = time();
                $enc_minutes = $now + (0* 60 * 60);
                $day = date('Y-m-d', $enc_minutes);
                echo $day;
                ?>" required>
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
              </p>
              <br>
              <h4 class="control-label" style="font-weight: 600; padding-bottom: 3px">第2希望</h4>
              <p>
                <input type="date" class="form-control mb-2" id="inlineFormInput" name="hope2" placeholder="yyyy/mm/dd"
                min="<?php echo date_i18n('Y-m-d', strtotime('+5 day')); ?>" required>
							<div id="hope1_date_error" style="display:none; padding: 0.5rem; color: blue; background: yellow; border-radius: 5px; margin-bottom: 1rem;  animation: flash 1s linear infinite;">先方の都合により<?php echo date_i18n('Y/m/d', strtotime('+5 day')); ?>以降の日付をご選択ください。</div>
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
              </p>
              <br>
              <h4 class="control-label" style="font-weight: 600; padding-bottom: 3px">第3希望</h4>
              <p>
                <input type="date" class="form-control mb-2" id="inlineFormInput" name="hope3" placeholder="yyyy/mm/dd"
                min="<?php echo date_i18n('Y-m-d', strtotime('+10 day')); ?>" required>
							<div id="hope1_date_error" style="display:none; padding: 0.5rem; color: blue; background: yellow; border-radius: 5px; margin-bottom: 1rem;  animation: flash 1s linear infinite;">先方の都合により<?php echo date_i18n('Y/m/d', strtotime('+10 day')); ?>以降の日付をご選択ください。</div>
                <div class="row">
                  <div class="col-6">
                  <select name="hope3_time_h" id="hope3_time_h" class="form-select" aria-label="select" required>
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
                  <select name="hope3_time_min" id="hope3_time_min" class="form-select" aria-label="select" required>
                    <option value="" disabled selected>分</option>
                    <option value="00">00</option>
                    <option value="30">30</option>
                  </select>
                  </div>
                </div>
              </p><br>
              <center>
              <p style="color:#383aff;font-weight:bold;">商材は後程入力</p>
              </center><br>
              <?php
              if($is_added_in == false){ ?>
                <button style="
                font-size: 20px;
                border-radius: 20px;
                width: 100%;
                " type="submit" class="btn btn-primary text-center">カートに入れる
                </button>
          <?php  }else{ ?>
            <button style="
                font-size: 20px;
                border-radius: 20px;
                width: 100%;
                " type="" class="btn btn-primary text-center" disabled>カートに入れる
                </button>
        <?php  }
            ?>
            </div>
          </form>

  </div>
</main>


<footer class="l-footer">
  <center>
    <div id="js-footer-widget" class="p-footer-widget-area p-footer-widget-area__default">
      <div class="footertext l-inner">
        <a href="privacy.php" target="_blank">個人情報保護方針</a>　　　<a href="rule.php" target="_blank">サイト利用規約</a><br
          class="br-sp">　　　<a href="publish.php" target="_blank">サイト掲載規約</a>　　　<a href="dsct.php"
          target="_blank">特商法表示</a>　　　<br class="br-sp"><a href="https://www.realideal.jp/" target="_blank">運営会社</a>　　　<a href="want.php" target="_blank">掲載希望の方</a>
      </div>
    </div>
    <div class="p-copyright">
      <div class="l-inner">
        <p>Copyright &copy;Realideal. All Rights Reserved.</p>
      </div>
    </div>
  </center>
  <div id="js-pagetop" class="p-pagetop"><a href="#"></a></div>
</footer>
<script type='text/javascript'>
uscesL10n = {

  'ajaxurl': "https://ec-apo.com/wp-admin/admin-ajax.php",
  'loaderurl': "https://ec-apo.com/wp-content/plugins/usc-e-shop/images/loading.gif",
  'post_id': "48",
  'cart_number': "46",
  'is_cart_row': false,
  'opt_esse': new Array(),
  'opt_means': new Array(),
  'mes_opts': new Array(),
  'key_opts': new Array(),
  'previous_url': "https://ec-apo.com",
  'itemRestriction': "",
  'itemOrderAcceptable': "0",
  'uscespage': "",
  'uscesid': "MDNjMzZiNmZkOTRiMjE1NTBkOGUzMWU3NDA4NzllMGQ1MzFhNjI4OTdlMmRmNTllX2FjdGluZ18wX0E%3D",
  'wc_nonce': "1346d7ad96"
}
</script>
<?php
if($_SERVER['REQUEST_METHOD']=='POST')
{
	cart_adjuct();
} 

?>