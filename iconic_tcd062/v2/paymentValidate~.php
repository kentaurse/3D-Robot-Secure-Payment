<?php
date_default_timezone_set('Asia/Tokyo');
/* 
Template Name: PaymentValidate 
*/  

$_email = $_SESSION['apo_log_mail'];
global $seconddb;

$title_name = $seconddb->get_var("SELECT title_name FROM vendor WHERE email='$_email'");

$request_body = file_get_contents('php://input');
$data = json_decode($request_body);
$orderID = $data->orderID;
$uri = 'https://api-m.paypal.com/v1/oauth2/token';
$clientId = 'AR5jRe8vQwJcDR721nns0Rzbj3H5KuCXXqWGtm1FVypr0nCAyB3UDsxD5Nou8ffiP3WhwiczM6f_cWU-';
$secret = 'EGvhXf4L4MndWSPqtVW2cKcWiIuL-5QyTRpm44Lj2rfFP3ZHxZMNqz1v2t_4eQP-AHQXoGgHpc9UyfK3';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $uri);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSLVERSION , 6);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
curl_setopt($ch, CURLOPT_USERPWD, $clientId.":".$secret);
curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

$result = curl_exec($ch);
$access_token = '';
if(empty($result))die("Error: No response.");
else
{
    $json = json_decode($result);
    $access_token = $json->access_token;
}
curl_close($ch);


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api-m.paypal.com/v2/checkout/orders/{$orderID}");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


$headers = array();
$headers[] = 'Content-Type: application/json';
$headers[] = "Authorization: Bearer $access_token";
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$order_result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}

curl_close($ch);

$payment_response = json_decode($order_result);



//Payment Info
$order_id = $payment_response->id;
$intent = $payment_response->intent;
$status = $payment_response->status;
$total = $payment_response->purchase_units[0]->amount->value;
$payments_info = json_encode($payment_response->purchase_units[0]->payments->authorizations);
$payee_info = json_encode($payment_response->purchase_units[0]->payee);
$payer_info = json_encode($payment_response->payer);
$shipping_info = json_encode($payment_response->purchase_units[0]->shipping);
$create_at = date('Y-m-d H:i:s');
$updated_at = date('Y-m-d H:i:s');


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


if(!empty($order_result)){
    if($status == 'COMPLETED'){
        $register_payment = $seconddb->insert("billing", array(
            "billing_order_id" => $order_id,
            "intent" => $intent,
            "total" => $total,
            "payments_info" => $payments_info,
            "payee_info" => $payee_info,
            "payer_info" => $payer_info,
            "shipping_info" => $shipping_info,
            "status" => $status ,
            "paypal_json" => $order_result ,
            "created_at" => $create_at ,
            "updated_at" => $updated_at ,
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
                    **************************** <br>
                    EC Apo 運営事務局 <br>
                    株式会社リアリディール <br>
                    東京都渋谷区恵比寿4-20-3 <br>
                    恵比寿ガーデンプレイスタワー18階 <br>
                    sales-offer@ec-apo.com <br>
                    ****************************
                    </div>
                ";
                $headers = "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                $headers .= "From:" . $from . "\r\n";
                $headers .= "Bcc:" . $bcc . "\r\n";
                mail($to,$subject,$message, $headers);



                if(isset($_SESSION['ec_apo_cart'])){
                    foreach($_SESSION['ec_apo_cart'] as $k => $v) {
                        $company_id = $v['company_id'];
                        $president = $seconddb->get_var("SELECT company FROM userlist WHERE userid='$company_id'");
                        $company_mail = $seconddb->get_var("SELECT mail FROM userlist WHERE userid='$company_id'");
                        $on_shop_order = $seconddb->get_var("SELECT id FROM orders WHERE order_id='$orderID'");
                        $tkn = $seconddb->get_var("SELECT url_token FROM orders WHERE order_id='$orderID'");
                        $tkn = json_decode($tkn);

                        for ($i = 0; $i < count($tkn); $i++){
                            if($tkn[$i]->company_id == $company_id){
                                $url_token = $tkn[$i]->url_token;
                            }
                        }
                        
                        $from = "sales-offer@ec-apo.com";
                        $to = $company_mail;
                        $bcc = "sales-offer@ec-apo.com";
                        $subject = "【要ご回答】{$title_name}様より商談オファーが届きました。";
                        $message = "
                            <p>※本アドレスは送信専用のため、ご返信頂いても確認ができかねますのでご了承下さい。</p>
                            <p>※本文内のURLからご回答下さい。</p>
                            <p>{$president} 様</p><br>
                            <h4>お世話になります、EC Apo運営事務局でございます。</h4>

                            <p>$title_name 様 から商談オファーが届いております</p>

                            <p>詳細を下記URLよりご回答下さい。</p>


                            URL: <a href='https://ec-apo.com/company-invitation/?access={$url_token}&order={$on_shop_order}&com={$company_id}'>https://ec-apo.com/company-invitation/?access={$url_token}&order={$on_shop_order}&com={$company_id}</a>

                            <p>EC Apoを今後ともよろしくお願いいたします。</p>

                            <p>※本アドレスは送信専用のため、ご返信頂いても確認ができかねますのでご了承下さい。</p>
                            <p>※本文内のURLからご回答下さい。</p>
                            <p>※URLは7日後に自動的に無効になります。</p>
                            <hr>
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
                        $headers = "MIME-Version: 1.0\r\n";
                        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                        $headers .= "From:" . $from . "\r\n";
                        $headers .= "Bcc:" . $bcc . "\r\n";
                        mail($to,$subject,$message, $headers);


                    }
                }
                

                //create remainder schedule
                if(isset($_SESSION['ec_apo_cart'])){
                    foreach($_SESSION['ec_apo_cart'] as $k => $v) {
                        $company_id = $v['company_id'];
                        $president = $seconddb->get_var("SELECT company FROM userlist WHERE userid='$company_id'");
                        $company_mail = $seconddb->get_var("SELECT mail FROM userlist WHERE userid='$company_id'");
                        $on_shop_order = $seconddb->get_var("SELECT id FROM orders WHERE order_id='$orderID'");
                        $tkn = $seconddb->get_var("SELECT url_token FROM orders WHERE order_id='$orderID'");
                        $tkn = json_decode($tkn);
                        $exp_date = date('Y-m-d H:i:s', strtotime($create_at. ' + 2 days'));  

                        for ($i = 0; $i < count($tkn); $i++){
                            if($tkn[$i]->company_id == $company_id){
                                $url_token = $tkn[$i]->url_token; 
                            }
                        }

                        $mail_subject = "【未回答です】{$title_name}様からの商談オファーが未回答です。【要ご確認】";
                        $mail_body = "<p>※本アドレスは送信専用のため、ご返信頂いても確認ができかねますのでご了承下さい。</p>
                        <p>※本文内のURLからご回答下さい。</p>
                        <p>{$president} 様</p><br>
                        <h4>お世話になります、EC Apo運営事務局でございます。</h4>

                        <p>$title_name 様 からの商談オファーが未回答のままとなっております。</p>

                        <p>詳細を下記URLよりご回答下さい。</p>


                        URL: <a href='https://ec-apo.com/company-invitation/?access={$url_token}&order={$on_shop_order}&com={$company_id}'>https://ec-apo.com/company-invitation/?access={$url_token}&order={$on_shop_order}&com={$company_id}</a>

                        <p>EC Apoを今後ともよろしくお願いいたします。</p>

                        <p>※本アドレスは送信専用のため、ご返信頂いても確認ができかねますのでご了承下さい。</p>
                        <p>※本文内のURLからご回答下さい。</p>
                        <p>※URLは初回配信から7日後に自動的に無効になります。残り日数が少ないためご注意ください。</p>
                        <hr>
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


                unset($_SESSION['ec_apo_cart']);
                unset($_SESSION['ec_apo_product']);
             }


         }
    }
}



    
?>