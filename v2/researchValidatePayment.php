<?php
date_default_timezone_set('Asia/Tokyo');
/* 
Template Name: Research Payment 
*/

$_email = $_SESSION['apo_log_mail'];
global $seconddb;

$title_name = $seconddb->get_var("SELECT title_name FROM vendor WHERE email='$_email'");
$tel = $seconddb->get_var("SELECT contact_cell FROM vendor WHERE email='$_email'");

$request_body = file_get_contents('php://input');
$data = json_decode($request_body);
$access_token = $data->tkn;
$target = $data->target;
$price = $data->price;
$userid = $data->userid;
$uri_first = 'https://credit.j-payment.co.jp/gateway/gateway_token.aspx';

// 3Dセキュア認証結果を取得
$threeDSecureResult = null;
if (isset($data->threeDSecureResult)) {
    $threeDSecureResult = json_decode($data->threeDSecureResult);
}

$postfields = array(
  'aid' => '123747',
  'tkn' => $access_token,
  'jb' => 'CAPTURE',
  'rt' =>  '1',
  'em' => $_email,
  'pn' => $tel,
  'am' => $price,
  'tx' => '0',
  'sf' => '0',
);

// 3Dセキュア認証結果を追加
if ($threeDSecureResult) {
  $postfields['3dsecure_status'] = $threeDSecureResult->status;
  $postfields['3dsecure_cavv'] = $threeDSecureResult->cavv;
  $postfields['3dsecure_eci'] = $threeDSecureResult->eci;
  $postfields['3dsecure_xid'] = $threeDSecureResult->xid;
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $uri_first);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postfields));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$order_result = curl_exec($ch);
if (curl_errno($ch)) {
  echo 'Error:' . curl_error($ch);
}

curl_close($ch);

$order_result = explode(',', $order_result);
$payment_response = [
  'gid' => $order_result[0],
  'rst' => $order_result[1],
  'ap' => $order_result[2],
  'ec' => $order_result[3],
  'god' => $order_result[4],
  'cod' => $order_result[5],
  'am' => $order_result[6],
  'tx' => $order_result[7],
  'sf' => $order_result[8],
  'ta' => $order_result[9],
];

$success = $payment_response['rst'] == 1;

if ($success) {
  $company = $seconddb->get_var("SELECT company FROM userlist WHERE userid = '$userid'");
  $pref = $seconddb->get_var("SELECT pref FROM userlist WHERE userid = '$userid'");
  $city = $seconddb->get_var("SELECT city FROM userlist WHERE userid = '$userid'");
  $addr = $seconddb->get_var("SELECT addr FROM userlist WHERE userid = '$userid'");
  $address = $pref . $city . $addr;

  $from = "contact9-1@ec-apo.com";
  $to = $_email;
  $bcc = "sales-offer@ec-apo.com";
  $subject = "【ECApo】調査を承りました。";

  $service_info_mail = "";

  $message = "<p> $title_name  様</p>
  <p>お世話になります、EC Apo運営事務局でございます。</p><br>
  <p>下記内容にて調査を承りました。</p><br>
  - - - - - - - - - -
  <p>対象企業名：$company</p>
  <p>住所：$address</p><br>
  <p>調査したい商材：$target</p>
  - - - - - - - - - - <br><br>
  <p>3営業日以内に調査結果をお返し致しますので、しばらくお待ちくださいませ。</p><br><br>
  <p>(ご同意頂いた内容)</p>
  <p>・調査していることは、先方の会社には知らされません。<br>
  ・調査対象期間は「調査する」ボタンを押してから遡って30日以内です。<br>
  ・調査対象は同業者に購入されて成立しているかどうかです。<br>
  ・調査結果が出るまでに3営業日頂戴します。<br>
  ・調査費用は1社あたり3,300円となります。</p>
  <p>ご確認のほどお願い申し上げます。</p><br>                  
  <div>
  **************************** <br>
  EC Apo 運営事務局 <br>
  株式会社リアリディール <br>
  東京都渋谷区恵比寿4-20-3 <br>
  恵比寿ガーデンプレイスタワー18階 <br>
  <a href='https://ec-apo.com/'>https://ec-apo.com/</a> <br>
  ****************************
  </div>
";
  $headers = "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
  $headers .= "From:" . $from . "\r\n";
  $headers .= "Bcc:" . $bcc . "\r\n";
  mail($to, $subject, $message, $headers);
}
