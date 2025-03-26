<?php ob_start(); ?>
<?php
date_default_timezone_set('Asia/Tokyo');
session_start();
global $dp_options;
if ( ! $dp_options ) $dp_options = get_design_plus_option();
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head <?php if ( $dp_options['use_ogp'] ) { echo 'prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#"'; } ?>>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="keywords" content="ECApo,イーシーアポ,ECアポ,アポ獲得代行,営業代行">
<meta name="description" content="<?php seo_description(); ?>">
<meta name="viewport" content="width=device-width">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<?php if ( $dp_options['use_ogp'] ) { ogp(); } ?>
<?php wp_head(); ?>


<script type="text/javascript">
src = new Array();
src[0]='生命保険営業　▶▶　飲食店代表';
src[1]='求人広告営業　▶▶　介護施設代表';
src[2]='OA機器営業　▶▶　WEBマーケ企業代表';
src[3]='経営コンサル営業　▶▶　工務店取締役';
src[4]='人事系SaaS営業　▶▶　ECサイト運営会社代表';
src[5]='SNS広告営業　▶▶　美容院オーナー';
src[6]='インスタ運用代行営業　▶▶　整体院院長';
src[7]='MEO営業　▶▶　歯科医院長';
src[8]='税理士営業　▶▶　建設会社代表';
src[9]='社労士営業　▶▶　WEB制作会社代表';
src[10]='人材紹介営業　▶▶　美容メーカー代表';
src[11]='SEO対策営業　▶▶　保険代理店代表';
src[12]='LP制作営業　▶▶　WEBコンサル会社代表';
src[13]='研修コンサル営業　▶▶　家電メーカー代表';
src[14]='法人携帯営業　▶▶　不動産賃貸会社代表';
src[15]='損害保険営業　▶▶　ゴルフ場代表';
src[16]='人事評価制作営業　▶▶　求人サービス代表';
src[17]='助成金コンサル営業　▶▶　花屋代表';
src[18]='空間デザイン営業　▶▶　エステサロン代表';
src[19]='営業代行事業営業　▶▶　不動産投資会社代表';
src[20]='集客広告営業　▶▶　学習塾代表';
src[21]='証券会社営業　▶▶　営業研修会社代表';
src[22]='SNS運用コンサル営業　▶▶　FC運営会社代表';
src[23]='オンライン秘書営業　▶▶　弁護士事務所代表';
src[24]='オフィス賃貸営業　▶▶　法人チャットツール取締役';
src[25]='営業コンサル　▶▶　　IFA代表';
src[26]='海外金融商品営業　▶▶　食品メーカー代表';
src[27]='補助金コンサル営業　▶▶　ガラス細工代表';
src[28]='融資コンサル営業　▶▶　リスティング代行代表';
src[29]='複合機営業　▶▶　税理士事務所代表';
src[30]='生命保険営業　▶▶　介護施設代表';
src[31]='求人広告営業　▶▶　工務店取締役';
src[32]='OA機器営業　▶▶　歯科医院長';
src[33]='経営コンサル営業　▶▶　建設会社代表';
src[34]='人事系SaaS営業　▶▶　家電メーカー代表';
src[35]='SNS広告営業　▶▶　求人サービス代表';
src[36]='インスタ運用代行営業　▶▶　エステサロン代表';
src[37]='MEO営業　▶▶　飲食店代表';
src[38]='税理士営業　▶▶　不動産賃貸会社代表';
src[39]='社労士営業　▶▶　保険代理店代表';
src[40]='人材紹介営業　▶▶　ゴルフ場代表';
src[41]='SEO対策営業　▶▶　営業研修会社代表';
src[42]='LP制作営業　▶▶　食品メーカー代表';
src[43]='研修コンサル営業　▶▶　リスティング代行代表';
src[44]='法人携帯営業　▶▶　WEB制作会社代表';
src[45]='損害保険営業　▶▶　弁護士事務所代表';
src[46]='人事評価制作営業　▶▶　法人チャットツール取締役';
src[47]='助成金コンサル営業　▶▶　食品メーカー代表';
src[48]='空間デザイン営業　▶▶　美容院オーナー';
src[49]='営業代行事業営業　▶▶　税理士事務所代表';
src[50]='集客広告営業　▶▶　花屋代表';
src[51]='証券会社営業　▶▶　美容メーカー代表';
src[52]='SNS運用コンサル営業　▶▶　不動産賃貸会社代表';
src[53]='オンライン秘書営業　▶▶　WEBコンサル会社代表';
src[54]='オフィス賃貸営業　▶▶　不動産投資会社代表';
src[55]='営業コンサル　▶▶　　財務顧問会社代表';
src[56]='海外金融商品営業　▶▶　中小企業人事コンサル代表';
src[57]='補助金コンサル営業　▶▶　アプリ制作会社代表';
src[58]='融資コンサル営業　▶▶　デザイン会社代表';
src[59]='複合機営業　▶▶　印刷会社代表';
src[60]='生命保険営業　▶▶　飲食関連代表';
src[61]='求人広告営業　▶▶　旅館代表';
src[62]='OA機器営業　▶▶　老人ホーム代表';
src[63]='経営コンサル営業　▶▶　スポーツジム代表';
src[64]='SaaS営業　▶▶　WEBアプリ制作会社代表';
src[65]='SNS広告営業　▶▶　健康食品メーカー代表';
src[66]='インスタ運用代行営業　▶▶　美容サプリ販売会社代表';
src[67]='MEO営業　▶▶　Iphone修理会社代表';
src[68]='税理士営業　▶▶　中古車販売代表';
src[69]='社労士営業　▶▶　複合機代理店代表';
src[70]='人材紹介営業　▶▶　不動産会社代表';
src[71]='SEO対策営業　▶▶　営業代行会社代表';
src[72]='LP制作営業　▶▶　医療コンサル代表';
src[73]='研修コンサル営業　▶▶　経費削減コンサル代表';
src[74]='電力切り替え営業　▶▶　飲食店代表';
src[75]='損害保険営業　▶▶　建築会社代表';
src[76]='生命保険営業　▶▶　美容室オーナー';
src[77]='助成金コンサル営業　▶▶　マッサージ店代表';
src[78]='生命保険営業　▶▶　工務店代表';
src[79]='営業代行事業営業　▶▶　社労士事務所代表';
src[80]='集客広告営業　▶▶　習い事教室代表';
src[81]='証券会社営業　▶▶　人材紹介代表';
src[82]='SNS運用コンサル営業　▶▶　買取屋代表';
src[83]='オンライン秘書営業　▶▶　デザイン会社代表';
src[84]='オフィス賃貸営業　▶▶　求人広告代理店代表';
src[85]='営業コンサル　▶▶　　社労士事務所';
src[86]='海外金融商品営業　▶▶　保険代理店代表';
src[87]='補助金コンサル営業　▶▶　システム開発会社代表';
src[88]='融資コンサル営業　▶▶　オフショア開発代表';
src[89]='複合機営業　▶▶　不動産賃貸代表';
window.onload=chX;
function chX(){
i=Math.floor(Math.random()*src.length);
document.getElementById("yesterdayresult").innerHTML=src[i];
setTimeout("chX()",8000);
}
</script>


<style>
	.p-blog-archive__item{
		box-shadow: rgb(17 17 26 / 10%) 0px 0px 16px;
    	padding: 20px;
	}
	.hover-deepblue:hover{
	color: #383aff;
}


.menu-btn {
    position: fixed;
    right: 10px;
    display: flex;
    height: 50px;
    width: 50px;
    justify-content: center;
    align-items: center;
    z-index: 90;
    background-color: #383aff;
}
.menu-btn span,
.menu-btn span:before,
.menu-btn span:after {
    content: '';
    display: block;
    height: 3px;
    width: 25px;
    border-radius: 3px;
    background-color: #ffffff;
    position: absolute;
}
.menu-btn span:before {
    bottom: 8px;
}
.menu-btn span:after {
    top: 8px;
}

#menu-btn-check:checked ~ .menu-btn span {
    background-color: rgba(255, 255, 255, 0);/*メニューオープン時は真ん中の線を透明にする*/
}
#menu-btn-check:checked ~ .menu-btn span::before {
    bottom: 0;
    transform: rotate(45deg);
}
#menu-btn-check:checked ~ .menu-btn span::after {
    top: 0;
    transform: rotate(-45deg);
}

#menu-btn-check {
    display: none;
}


.menu-content {
    width: 100%;
    height: 100%;
    position: fixed;
    top: 0;
    left: 100%;/*leftの値を変更してメニューを画面外へ*/
    z-index: 80;
    background-color: #383aff;
    transition: all 0.5s;/*アニメーション設定*/
}


#menu-btn-check:checked ~ .menu-content {
    left: 0;/*メニューを画面内へ*/
}



@media only screen and (min-width: 800px) {
div.hamburger-menu{
    display: none;
}

}


.text-ani_sample {
    border-radius:0.5em;    /*角丸*/
    background:#383aff;        /*背景色*/
    overflow:hidden;
    text-align:right;
    margin-left: auto;
    margin-right: 5%;
    width: 29%;
    max-width: 1000px;
}

@media only screen and (max-width: 600px) {
.text-ani_sample {
    margin-left: auto;
    margin-right: auto;
    width: 90%;
    max-width: 1000px;
}

}

.text-ani_sample p {
    margin:0;
    font-size:0.9em;         /*文字サイズ*/
    color:#fff;              /*文字の色*/
    font-weight:bold;
    animation: flowing 8s linear infinite;    /*アニメーション*/
    transform:translateX(125%);                /*最初の位置*/
}

@keyframes flowing {
  100% {
    transform:translateX(-100%);    /*終了の位置*/
  }


</style>
</head>
<body <?php body_class(); ?>>
<?php
if ( $dp_options['use_load_icon'] ) :
?>
<div id="site_loader_overlay">
	<div id="site_loader_animation" class="c-load--<?php echo esc_attr( $dp_options['load_icon'] ); ?>">
<?php
	if ( 'type3' === $dp_options['load_icon'] ) :
?>
		<i></i><i></i><i></i><i></i>
<?php
	endif;
?>
	</div>
</div>
<?php
endif;
?>
<header id="js-header" class="l-header">
	<div class="p-header__top">
		<div class="p-header__top__inner l-inner">
<?php
$logotag = is_front_page() ? 'h1' : 'div';
if ( 'yes' == $dp_options['use_header_logo_image'] && $image = wp_get_attachment_image_src( $dp_options['header_logo_image'], 'full' ) ) :
?>
			<<?php echo $logotag; ?> class="p-logo p-header__logo<?php if ( $dp_options['header_logo_image_retina'] ) { echo ' p-header__logo--retina'; } ?>">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_attr( $image[0] ); ?>" alt="<?php bloginfo( 'name' ); ?>"<?php if ( $dp_options['header_logo_image_retina'] ) echo ' width="' . floor( $image[1] / 2 ) . '"'; ?>></a>
			</<?php echo $logotag; ?>>
			
			
<?php
	if ( is_welcart_active() ) :
?>
			
	<div class="hamburger-menu">
        <input type="checkbox" id="menu-btn-check">
        <label for="menu-btn-check" class="menu-btn"><span></span></label>
			
        <div class="menu-content">
				<br><br>
        <center>
				<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
				<form method="post" action="/search" class="search_container">
				<input type="text" name="company" size="35" placeholder="アポをとりたい会社名/店名を検索">
				<input type="submit" value="&#xf002">
				</form>
				<br><br>
			<a id="js-header-cart" href="/cart">カート<span class="p-header__welcart-nav__badge">
			<?php
							$count = 0;
							if(isset($_SESSION['ec_apo_cart'])){
								foreach($_SESSION['ec_apo_cart'] as $key => $val){
									$count++;
								}
							}
							echo $count;
						?>
			</span></a>
			
<?php
    endif;
?>
			
				<br><br>
				<a href="/faq.php" target="_blank">よくある質問</a>
				<br><br>

<?php
			if ( isset($_SESSION['apo_log_tkn']) ) :
?>
				<a href="/profile">マイページ</a>
				<br><br>
				<a href="/logout"><?php _e( 'Logout', 'tcd-w' ); ?></a>
				<br><br>
<?php
			else :
?>
				<a href="/login"><?php _e( 'Login', 'tcd-w' ); ?></a>
				<br><br>
<?php
            endif;
     
?>
				<a href="/contact.php" target="_blank">問い合わせ</a>
				<br><br>
				<a href="/want.php">掲載希望の方はこちら</a>
				<br><br>
				<a href="/index.php">トップに戻る</a>
				
				
        </center>
				
				
				
    </div>
    </div>
        
        

<?php
	if ( is_welcart_active() ) :
?>
			<ul class="p-header__welcart-nav">
				<li class="searchboxli">
				<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
				<form method="post" action="/search" class="search_container">
				<input type="text" name="company" size="35" placeholder="アポをとりたい会社名/店名を検索">
				<input type="submit" value="&#xf002">
				</form></li>
				<li><a href="/faq.php" target="_blank">よくある質問</a></li>
				<li><a href="/contact.php" target="_blank">問い合わせ</a></li>
<?php
			if ( isset($_SESSION['apo_log_tkn']) ) :
?>
				<li><a href="/profile">マイページ</a></li>
				<li class="p-header__welcart-nav__logout"><a href="/logout"><?php _e( 'Logout', 'tcd-w' ); ?></a></li>
<?php
			else :
?>
				<li class="p-header__welcart-nav__login"><a href="/login"><?php _e( 'Login', 'tcd-w' ); ?></a></li>
<?php
            endif;
     
?>
			<li class="p-header__welcart-nav__cart"><a id="js-header-cart" href="/cart">カート<span class="p-header__welcart-nav__badge">
			<?php
							$count = 0;
							if(isset($_SESSION['ec_apo_cart'])){
								foreach($_SESSION['ec_apo_cart'] as $key => $val){
									$count++;
								}
							}
							echo $count;
						?>
			</span></a></li>
            </ul>
<?php
    endif;
?>
		</div>
	</div>
<?php
endif;
?>
</header>