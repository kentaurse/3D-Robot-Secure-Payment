<?php
date_default_timezone_set('Asia/Tokyo');
/* 
Template Name: PaymentValidate 
*/ 

ini_set("log_errors", 1);
ini_set("error_log", __DIR__. "/php-error.log");

$_email = $_SESSION['apo_log_mail'];
global $seconddb;

$blacklist = $seconddb->get_var("SELECT blacklist FROM vendor WHERE email='$_email'");
$blacklisted = $blacklist == 'on';
$title_name = $seconddb->get_var("SELECT title_name FROM vendor WHERE email='$_email'");
$tel = $seconddb->get_var("SELECT contact_cell FROM vendor WHERE email='$_email'");

$request_body = file_get_contents('php://input');
$data = json_decode($request_body);
$access_token = $data->tkn;
$amounts = json_decode($data->amounts);
$onetouch = filter_var($data->onetouch, FILTER_VALIDATE_BOOLEAN);
$uri_first = 'https://credit.j-payment.co.jp/gateway/gateway_token.aspx';
$uri_onetouch = 'https://credit.j-payment.co.jp/gateway/onetouch.aspx';

// 3Dセキュア認証結果を取得
$threeDSecureResult = null;
if (isset($data->threeDSecureResult)) {
    $threeDSecureResult = json_decode($data->threeDSecureResult);
}

$success = 1;
$order_id = "";
$payments_info = [];
$order_results = [];
$total = 0;
$shipping_info = 0;

if(isset($_SESSION['ec_apo_cart'])){
    $i = 0;
    foreach ($_SESSION['ec_apo_cart'] as $v) {
        if ($success) {
            $postfields = array(
                'aid' => '123747',
                'jb' => 'AUTH',
                'rt' =>  '1',
                'em' => $_email,
                'pn' => $tel,
                'am' => $amounts[$i],
                'tx' => '0',
                'sf' => '0',
            );
            
            // 3Dセキュア認証結果がある場合は追加
            if ($i == 0 && $onetouch == false) {
                $postfields['tkn'] = $access_token;
                
                // 3Dセキュア認証結果を追加
                if ($threeDSecureResult) {
                    $postfields['3dsecure_status'] = $threeDSecureResult->status;
                    $postfields['3dsecure_cavv'] = $threeDSecureResult->cavv;
                    $postfields['3dsecure_eci'] = $threeDSecureResult->eci;
                    $postfields['3dsecure_xid'] = $threeDSecureResult->xid;
                }
            } else {
                $postfields['cmd'] = '1';
                $postfields['pn'] = $tel;
            }

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $i == 0 && $onetouch == false ? $uri_first : $uri_onetouch);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postfields));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $order_result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
                $success = 0;
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
            $order_result = json_encode($payment_response);
            array_push($order_results, $order_result);


            //Payment Info
            if ($i == 0) {
                $order_id = $payment_response['gid'];
            }
            $payments_info[$v['company_id']] = $payment_response['gid'];
            $total = $total + intval($payment_response['ta']);
            $shipping_info = $shipping_info + intval($payment_response['sf']);
            $success = $success && ($payment_response['rst'] == 1) && $order_id != "";

            if(!$success){
                $_SESSION['ec_apo_payment_error'] = "決済に失敗しました。";
                if($payment_response['ec'] != ""){
                    $_SESSION['ec_apo_payment_error'] = $_SESSION['ec_apo_payment_error'] . "エラーコード：" . $payment_response['ec'] . "。情報を確認して再度お試しください。エラーが続く場合はお問い合わせください。";
                }
                exit();
            }

            $i++;
        }
    }                   
} else {
    $success = 0;
}

$intent = "order";
$payee_info = json_encode([]);
$payer_info = json_encode([]);
$payments_info = json_encode($payments_info);
$order_results = json_encode($order_results);
$create_at = date('Y-m-d H:i:s');
$updated_at = date('Y-m-d H:i:s');

if(!$success){
    $_SESSION['ec_apo_payment_error'] = "決済に失敗しました。";
    exit();
}

//Order Info
$product_info = array();
$vendors_info = array();
$vendor_approval = array();
$hopes = array();
$final_status = array();
$contact_way = array();
$order_total = 0.00;
$order_url_token = array();

//Product info
if(isset($_SESSION['ec_apo_product'])){
    foreach($_SESSION['ec_apo_product'] as $k => $v) {
        $product_info[] = array(
            'id' => $_SESSION['ec_apo_product'][0]['id'],
            'product_name'=> $_SESSION['ec_apo_product'][0]['product_name'],
            'product_page'=> $_SESSION['ec_apo_product'][0]['product_page'],
        );
    }
}

//Vendor info
if(isset($_SESSION['ec_apo_cart'])){
    foreach($_SESSION['ec_apo_cart'] as $k => $v) {
        $vendors_info[] = array(
            'company_id' => $v['company_id'],
            'company_name'=> $v['company'],
            'company_mail'=> $v['email'],
            'company_tel'=> $v['tel'],
            'company_homepage'=> $v['homepage'],
            'charge'=> $v['amount'],
            'address' => $v['address'],
        );
    }
}

//Vendor approval
if(isset($_SESSION['ec_apo_cart'])){
    foreach($_SESSION['ec_apo_cart'] as $k => $v) {
        $vendor_approval[] = array(
            'company_id' => $v['company_id'],
            'status'=> "Pending",
            'comment'=> "",
            'created_at'=> "",
        );
    }
}

//hopes
if(isset($_SESSION['ec_apo_cart'])){
    foreach($_SESSION['ec_apo_cart'] as $k => $v) {
        $hopes[] = array(
            'company_id' => $v['company_id'] ,
            'method'=> $v['method'] ,
            'hope1'=> $v['day1'] . "  " . $v['day1_time'] ,
            'hope2'=> $v['day2'] . "  " . $v['day2_time'] ,
            'hope3'=> $v['day3'] . "  " . $v['day3_time'] ,
        );
    }
}

//service info mail
$service_info_mail = '';
if(isset($_SESSION['ec_apo_cart'])){
    foreach($_SESSION['ec_apo_cart'] as $k => $v) {
        $service_info_mail .= "- - - - - - - - - -<p> {$v['company']} </p> <p>住所: {$v['address']} </p> <p>商談相手: {$v['negotiation_partner']} </p> <p>商談設定金額: ¥ {$v['amount']} </p> <p>希望商談日: {$v['day1']} {$v['day1_time']}, {$v['day2']} {$v['day2_time']}, {$v['day3']} {$v['day3_time']} </p>- - - - - - - - - - <br><br>";
    }
}

echo $service_info_mail;

//final Status
if(isset($_SESSION['ec_apo_cart'])){
    foreach($_SESSION['ec_apo_cart'] as $k => $v) {
        $final_status[] = array(
            'company_id' => $v['company_id'],
            'status'=> "Panding",
        );
    }
}


//Generate order url token
if(isset($_SESSION['ec_apo_cart'])){
    foreach($_SESSION['ec_apo_cart'] as $k => $v) {
        $_token = openssl_random_pseudo_bytes(32);
        $order_url_token[] = array(
            'company_id' => $v['company_id'],
            'url_token'=> bin2hex($_token),
            'created_at' => $create_at,
            'updated_at' => $updated_at,
        );
    }
}

//Contact way
if(isset($_SESSION['ec_apo_cart'])){
    foreach($_SESSION['ec_apo_cart'] as $k => $v) {
        $contact_way[] = array(
            'company_id' => $v['company_id'],
            'method'=> $v['method'],
            'title_name'=> "",
            'contact_url'=> "",
            'contact_address'=> "",
            'contact_tel'=> "",
            'date_confirm'=> "",
        );
    }
}

if ($success) {
    $register_payment = $seconddb->insert("billing", array(
        "billing_order_id" => $order_id,
        "intent" => $intent,
        "total" => $total,
        "payments_info" => $payments_info,
        "payee_info" => $payee_info,
        "payer_info" => $payer_info,
        "shipping_info" => $shipping_info,
        "status" => "COMPLETED",
        "paypal_json" => $order_results,
        "created_at" => $create_at,
        "updated_at" => $updated_at,
    ));


    if($register_payment){
        $create_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');

        $register_order = $seconddb->insert("orders", array(
            "order_id" => $order_id,
            "seller_id" => $_email,
            "product_info" => json_encode($product_info, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT),
            "vendors_info" => json_encode($vendors_info, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT),
            "vendor_approval" => json_encode($vendor_approval, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT),
            "hopes" => json_encode($hopes, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT),
            "final_status" => json_encode($final_status, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT),
            "contact_way" => json_encode($contact_way, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT),
            "total" => $total,
            "url_token" => json_encode($order_url_token, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT),
            "created_at" => $create_at,
            "updated_at" => $updated_at,
        ));json_encode($product_info, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);


		if($register_order){
			ini_set( 'display_errors', 1 );
			error_reporting( E_ALL );

			$from = "sales-offer@ec-apo.com";
			$to = $_email;
			$bcc = "sales-offer@ec-apo.com";
			$subject = "※本決済前【{$title_name} 様】 先方へ商談のご依頼中です。";
			$message = "
                <p>※本アドレスは送信専用のため、ご返信頂いても確認ができかねますのでご了承下さい。</p>
                <p> $title_name  様</p>
                <h4>現在、下記お客様へ商談のご依頼中です。</h4>
                {$service_info_mail}
                <p>現状は与信決済状態です。先方が商談OKで日程が返ってきた段階で、ご登録のクレジットカードより本決済となりますが、商談自体を先方がお断りした場合は本決済されませんのでご安心下さい。</p>

                <p>先方から回答があり次第、ご連絡させて頂きますのでしばしお待ちくださいませ。</p>

                <p>EC Apoを今後ともよろしくお願いいたします。</p>

                <p>※本アドレスは送信専用のため、ご返信頂いても確認ができかねますのでご了承下さい。</p>
                <hr>
                <div>
                <br>
                **************************** <br>
                EC Apo 運営事務局 <br>
                株式会社リアリディール <br>
                東京都渋谷区恵比寿4-20-3 <br>
                恵比寿ガーデンプレイスタワー18階 <br>
                sales-offer@ec-apo.com <br>
                ****************************
                </div>
            ";
			$from_name = "ECApo(イーシーアポ)運営事務局";

$from_name = mb_encode_mimeheader($from_name, "UTF-8", "B", "\n");
			$headers = "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
			$headers .= "From:".$from_name."<".$from.">\r\n";
			$headers .= "Bcc:" . $bcc . "\r\n";
			mail($to,$subject,$message, $headers);


			if(isset($_SESSION['ec_apo_cart']) && !$blacklisted){
				foreach($_SESSION['ec_apo_cart'] as $k => $v) {
					$company_id = $v['company_id'];
					$president = $seconddb->get_var("SELECT company FROM userlist WHERE userid='$company_id'");
					$sei = $seconddb->get_var("SELECT sei FROM userlist WHERE userid='$company_id'");
					$mei = $seconddb->get_var("SELECT mei FROM userlist WHERE userid='$company_id'");
					$company_mail = $seconddb->get_var("SELECT mail FROM userlist WHERE userid='$company_id'");
					$on_shop_order = $seconddb->get_var("SELECT id FROM orders WHERE order_id='$order_id'");
					$tkn = $seconddb->get_var("SELECT url_token FROM orders WHERE order_id='$order_id'");
					$tkn = json_decode($tkn);

					for ($i = 0; $i < count($tkn); $i++){
						if($tkn[$i]->company_id == $company_id){
							$url_token = $tkn[$i]->url_token;
						}
					}

					$from = "sales-offer@ec-apo.com";
					$to = $company_mail;
					$bcc = "sales-offer@ec-apo.com";
					$subject = "【報酬付き】{$sei} {$mei} 様へ商談オファーが届きました。";
					$message = "
                        <p>{$president}<br>{$sei} {$mei} 様</p><br>
                        <h4>お世話になります、EC Apo運営事務局でございます。</h4>

                        <p>$title_name 様 から報酬付き商談オファーが届いております<br>(営業受けるのみで報酬受け取り可)</p>

                        <p>詳細を下記URLよりご確認下さい。</p>
                        <p>なお、$title_name 様は同業他者にもオファーを出しているため、同業他社との商談日が先に決まった場合は、本オファーは取り下げになる可能性もございます。</p>
                        <p>お早めに下記をクリックしてご回答くださいませ。</p>

                        URL: <a href='https://ec-apo.com/company-invitation/?access={$url_token}&order={$on_shop_order}&com={$company_id}&p=rp'>https://ec-apo.com/company-invitation/?access={$url_token}&order={$on_shop_order}&com={$company_id}&p=rp</a>

                        <p>EC Apoを今後ともよろしくお願いいたします。</p>

                        <p>※本アドレスは送信専用のため、ご返信頂いても確認ができかねますのでご了承下さい。</p>

                        <p>※本文内のURLからご回答下さい。</p>

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
					$from_name = "ECApo(イーシーアポ)運営事務局";

$from_name = mb_encode_mimeheader($from_name, "UTF-8", "B", "\n");
					$headers = "MIME-Version: 1.0\r\n";
					$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
					$headers .= "From:".$from_name."<".$from.">\r\n";
					$headers .= "Bcc:" . $bcc . "\r\n";
					mail($to,$subject,$message, $headers);


				}
			}
			

			//create remainder schedule 1
			if(isset($_SESSION['ec_apo_cart']) && !$blacklisted){
				foreach($_SESSION['ec_apo_cart'] as $k => $v) {
					$company_id = $v['company_id'];
					$president = $seconddb->get_var("SELECT company FROM userlist WHERE userid='$company_id'");
					$sei = $seconddb->get_var("SELECT sei FROM userlist WHERE userid='$company_id'");
					$mei = $seconddb->get_var("SELECT mei FROM userlist WHERE userid='$company_id'");
					$company_mail = $seconddb->get_var("SELECT mail FROM userlist WHERE userid='$company_id'");
					$on_shop_order = $seconddb->get_var("SELECT id FROM orders WHERE order_id='$order_id'");
					$tkn = $seconddb->get_var("SELECT url_token FROM orders WHERE order_id='$order_id'");
					$tkn = json_decode($tkn);
					$exp_date = date('Y-m-d H:i:s', strtotime($create_at. ' + 2 days'));

					for ($i = 0; $i < count($tkn); $i++){
						if($tkn[$i]->company_id == $company_id){
							$url_token = $tkn[$i]->url_token;
						}
					}

					$mail_subject = "【未回答状態】{$title_name}様からの報酬付き商談オファーが未回答です。";
					$mail_body = "<p>{$president}<br>{$sei} {$mei} 様</p><br>
                    <h4>お世話になります、EC Apo運営事務局でございます。</h4>

                    <p>$title_name 様 から報酬付きの商談オファーが届いております。<br>(営業受けるのみで報酬受け取り可)</p>

                    <p>未回答率がと高いと、他の商談ファーが届かなくなってしまうため、お早めに下記をクリックしてご回答くださいませ。</p>

                    URL: <a href='https://ec-apo.com/company-invitation/?access={$url_token}&order={$on_shop_order}&com={$company_id}&p=rp'>https://ec-apo.com/company-invitation/?access={$url_token}&order={$on_shop_order}&com={$company_id}&p=rp</a>

                    <p>EC Apoを今後ともよろしくお願いいたします。</p>

                    <p>※本アドレスは送信専用のため、ご返信頂いても確認ができかねますのでご了承下さい。</p>
                    <p>※本文内のURLからご回答下さい。</p>
                    <div>
                    **************************** <br>
                    EC Apo 運営事務局 <br>
                    株式会社リアリディール <br>
                    東京都渋谷区恵比寿4-20-3 <br>
                    恵比寿ガーデンプレイスタワー18階 <br>
                    sales-offer@ec-apo.com <br>
                    ****************************
                    </div>";




					$register_schedule_response_check = $seconddb->insert("remainder_mail", array(
						"order_id" => $order_id,
						"company_id" => $company_id,
						"company_mail" => $company_mail,
						"status" => '0',
						"mail_subject" => $mail_subject,
						"mail_body" => $mail_body,
						"scheduled" => $exp_date,
						"created_at" => $create_at,
					));

				}
			}

			if(isset($_SESSION['ec_apo_cart']) && !$blacklisted){
				foreach($_SESSION['ec_apo_cart'] as $k => $v) {
					$company_id = $v['company_id'];
					$president = $seconddb->get_var("SELECT company FROM userlist WHERE userid='$company_id'");
					$sei = $seconddb->get_var("SELECT sei FROM userlist WHERE userid='$company_id'");
					$mei = $seconddb->get_var("SELECT mei FROM userlist WHERE userid='$company_id'");
					$company_mail = $seconddb->get_var("SELECT mail FROM userlist WHERE userid='$company_id'");
					$on_shop_order = $seconddb->get_var("SELECT id FROM orders WHERE order_id='$order_id'");
					$tkn = $seconddb->get_var("SELECT url_token FROM orders WHERE order_id='$order_id'");
					$tkn = json_decode($tkn);
					$exp_date = date('Y-m-d H:i:s', strtotime($create_at. ' + 5 days'));

					for ($i = 0; $i < count($tkn); $i++){
						if($tkn[$i]->company_id == $company_id){
							$url_token = $tkn[$i]->url_token;
						}
					}

					$mail_subject = "【明日が期日です】 {$sei} {$mei} 様の受け取り報酬が逸失します。";
					$mail_body = "<p>{$president}<br>{$sei} {$mei} 様</p>
                    <h4>お世話になります、EC Apo運営事務局でございます。</h4>

                    <p>$title_name 様 からの報酬つき商談オファーが未回答のままとなっております。<br>(営業受けるのみで報酬受け取り可)</p>

                    <p>なお、報酬は1回商談するのみで受け取れるもので、申し込む申し込まないは関係ございません！<br>明日が回答期日となっておりますので、下記URLよりご回答下さい。</p>


                    URL: <a href='https://ec-apo.com/company-invitation/?access={$url_token}&order={$on_shop_order}&com={$company_id}&p=rp'>https://ec-apo.com/company-invitation/?access={$url_token}&order={$on_shop_order}&com={$company_id}&p=rp</a>

                    <p>EC Apoを今後ともよろしくお願いいたします。</p>

                    <p>※本アドレスは送信専用のため、ご返信頂いても確認ができかねますのでご了承下さい。</p>
                    <p>※本文内のURLからご回答下さい。</p>
                    <div>
                    **************************** <br>
                    EC Apo 運営事務局 <br>
                    株式会社リアリディール <br>
                    東京都渋谷区恵比寿4-20-3 <br>
                    恵比寿ガーデンプレイスタワー18階 <br>
                    sales-offer@ec-apo.com <br>
                    ****************************
                    </div>";




					$register_schedule_response_check = $seconddb->insert("remainder_mail", array(
						"order_id" => $order_id,
						"company_id" => $company_id,
						"company_mail" => $company_mail,
						"status" => '0',
						"mail_subject" => $mail_subject,
						"mail_body" => $mail_body,
						"scheduled" => $exp_date,
						"created_at" => $create_at,
					));

				}
			}


			if(isset($_SESSION['ec_apo_cart'])){
				foreach($_SESSION['ec_apo_cart'] as $k => $v) {
					$company_id = $v['company_id'];
					$president = $seconddb->get_var("SELECT company FROM userlist WHERE userid='$company_id'");
					$on_shop_order = $seconddb->get_var("SELECT id FROM orders WHERE order_id='$order_id'");
					$tkn = $seconddb->get_var("SELECT url_token FROM orders WHERE order_id='$order_id'");
					$tkn = json_decode($tkn);
					$exp_date = date('Y-m-d H:i:s', strtotime($create_at. ' + 7 days'));

					for ($i = 0; $i < count($tkn); $i++){
						if($tkn[$i]->company_id == $company_id){
							$url_token = $tkn[$i]->url_token;
						}
					}

					$mail_subject = "{$title_name}様へ、商談オファーの取り下げのお知らせ";
					$mail_body = "<p>{$title_name} 様</p><br>
                    <h4>お世話になります、EC Apo運営事務局でございます。</h4>

                    <p>1週間前にオファーを頂いた下記商談ですが、先方経営者が御忙しく回答できないようなので、一度取り下げさせて頂きます。</p>

                    <p>仮決済状態であったクレジットカード決済は、3営業日以内に取り消しされ課金はされませんのでご安心くださいませ。</p>

                    <p>(取り下げ対象の商談オファー)</p>

                    <p>- - - - - - - - - -</p>
                    <p> {$v['company']} </p>
                    <p>住所: {$v['address']} </p> 
                    <p>商談相手: {$v['negotiation_partner']} </p> 
                    <p>商談設定金額: ¥ {$v['amount']} </p> 
                    <p>希望商談日: {$v['day1']} {$v['day1_time']}, {$v['day2']} {$v['day2_time']}, {$v['day3']} {$v['day3_time']} </p>
                    <p>- - - - - - - - - -</p>
                    <br><br>

                    <p>掲載社数は日に日に増えておりますので、ぜひ別会社へ商談をご依頼下さい。</p>

                    <p><a href='https://ec-apo.com/' target='_blank'>https://ec-apo.com/</a></p>

                    <p>※本アドレスは送信専用のため、ご返信頂いても確認ができかねますのでご了承下さい。</p>
                    <div>
                   <br>
                    **************************** <br>
                    EC Apo 運営事務局 <br>
                    株式会社リアリディール <br>
                    東京都渋谷区恵比寿4-20-3 <br>
                    恵比寿ガーデンプレイスタワー18階 <br>
                    sales-offer@ec-apo.com <br>
                    ****************************
                    </div>";




					$register_schedule_response_check = $seconddb->insert("remainder_mail", array(
						"order_id" => $order_id,
						"company_id" => $company_id,
						"company_mail" => $_email,
						"status" => '0',
						"mail_subject" => $mail_subject,
						"mail_body" => $mail_body,
						"scheduled" => $exp_date,
						"created_at" => $create_at,
					));

				}
			}


			unset($_SESSION['ec_apo_cart']);
			unset($_SESSION['ec_apo_product']);
			$_SESSION['ec_apo_payment_success'] = $success; 

		}


    }
}




?>