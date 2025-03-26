<?php
/*
Template Name: Contracts
 */
$_email = $_SESSION['apo_log_mail'];
global $seconddb;

if (!isset($_SESSION['apo_log_tkn'])) {
    header("Location: /");
}

get_header();

$fetch_order_info_once = $seconddb->get_results("SELECT * FROM orders WHERE seller_id='$_email'");
$seller_id = $fetch_order_info_once[0]->seller_id;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    cancel_order();
}

function cancel_order()
{
    global $seconddb;
    date_default_timezone_set('Asia/Tokyo');

    $_email = $_SESSION['apo_log_mail'];
    $order_id = $_POST['oc-order'];
    $company_id = $_POST['oc-order-com'];
    $fetch_date = $seconddb->get_var("SELECT created_at FROM orders WHERE id='$order_id'");
    $curr_date = date('Y-m-d H:i:s', time());
    $exp_date = date('Y-m-d H:i:s', strtotime($fetch_date . ' + 7 days'));
    $user_name = $seconddb->get_var("SELECT title_name FROM vendor WHERE email='$_email'");

    if ($curr_date <= $exp_date) {
        $initial_approval = $seconddb->get_var("SELECT vendor_approval FROM orders WHERE id='$order_id'");
        $decode_initial_approval = json_decode($initial_approval, true);

        foreach ($decode_initial_approval as $key => $entry) {
            if ($entry['company_id'] == $company_id) {
                $decode_initial_approval[$key]['status'] = "Canceled";
                $decode_initial_approval[$key]['comment'] = "Canceled by user.";
                $decode_initial_approval[$key]['created_at'] = $curr_date;
            } else {

            }
        }
        $updated_approval = json_encode($decode_initial_approval);

        $seconddb->update("orders", array(
            "vendor_approval" => $updated_approval,
        ), array('id' => $order_id));

        $fetch_vendor_info = $seconddb->get_var("SELECT vendors_info FROM orders WHERE id='$order_id'");
        $decode_fetch_vendor_info = json_decode($fetch_vendor_info, true);

        $target_service_info = '';
        foreach ($decode_fetch_vendor_info as $key => $entry) {
            if ($entry['company_id'] == $company_id) {
                $target_info_1 = $decode_fetch_vendor_info[$key]['charge'];
                $target_info_2 = $decode_fetch_vendor_info[$key]['address'];
                $target_info_3 = $decode_fetch_vendor_info[$key]['company_id'];
                $target_info_4 = $decode_fetch_vendor_info[$key]['company_tel'];
                $target_info_5 = $decode_fetch_vendor_info[$key]['company_mail'];
                $target_info_6 = $decode_fetch_vendor_info[$key]['company_name'];
                $target_info_7 = $decode_fetch_vendor_info[$key]['company_homepage'];

                $target_service_info .= "- - - - - - - - - -<p> {$target_info_6} </p> <p>住所: {$target_info_2} </p><p>商談設定金額: {$target_info_1} </p>";
            }
        }

        $fetch_vendor_hopes = $seconddb->get_var("SELECT hopes FROM orders WHERE id='$order_id'");
        $decode_fetch_hopes_info = json_decode($fetch_vendor_hopes, true);

        $target_hopes_info = '';
        foreach ($decode_fetch_hopes_info as $key => $entry) {
            if ($entry['company_id'] == $company_id) {
                $hope_1 = $decode_fetch_hopes_info[$key]['hope1'];
                $hope_2 = $decode_fetch_hopes_info[$key]['hope2'];
                $hope_3 = $decode_fetch_hopes_info[$key]['hope3'];
                $method = $decode_fetch_hopes_info[$key]['method'];

                $target_hopes_info .= "<p>希望商談日: {$hope_1}, {$hope_2}, {$hope_3} </p><br>{$method}<br>- - - - - - - - - - <br><br>";
            }
        }

        ini_set('display_errors', 1);
        error_reporting(E_ALL);

        $from = "sales-offer@ec-apo.com";
        $to = $_email;
        $bcc = "sales-offer@ec-apo.com";
        $subject = "キャンセル希望を受け取りました。";
        $message = "
                    <p> $user_name  様</p>
                    <h4>EC Apo運営事務局でございます。</h4><br>

                    <p>下記案件のキャンセル要望を承りました。</p><br>

                    <p>商談の日程成立前である場合、仮決済は自動キャンセルとなりますのでご安心ください。</p>
                    <p>カードへのキャンセルの反映がされるまで、数日かかる場合もございますので詳細はカード会社にご確認くださいませ。</p><br>

                    <p> 商談の日程成立後である場合は、キャンセル理由と利用規約を確認、場合によっては商談相手にヒアリングを行い、要望が認められた場合のみキャンセル処理をさせて頂きます。</p><br>
                    
                    <p>利用規約は下記より確認可能です。</p>

                    <p>https://ec-apo.com/rule.php</p><br>

                    {$target_service_info}
                    {$target_hopes_info}


                    <br><p>ご確認のほどお願い申し上げます。</p>

                    <hr>
                    <div>
                    **************************** <br>
                    EC Apo 運営事務局 <br>
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
        mail($to, $subject, $message, $headers);

        header("Location: /appointments?action=success");
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

    .nav_sec li {
        padding: 10px;
        margin: 5px;
        float: right;
        background-color: white;
    }

    .bg_chip {
        background-color: #f08080;
    }
</style>

<?php
if (isset($_GET['action'])&!empty($_GET['action'])) {
    if ($_GET['action'] == 'success') {?>
<div class="container">
    <div class="d-flex justify-content-md-center align-items-center" style="height: 80vh!important">
        <div>
            <div class="card text-center" style="border: 0">
                <div class="card-body">
                    <h5 class="card-title" style="font-size: 23px;
    font-weight: 600;">キャンセル要望を承りました。</h5>
                    <h4>現段階でまだキャンセルは未確定になります。</h4>
                    <p class="card-text" style="line-height: 20px;
    font-weight: 500;
    font-family: sans-serif;">詳しくは自動返信メールをご確認ください</p>
                    <hr>
                    <a href="/appointments" class="btn btn-primary">戻る</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
}
} else {?>
<div class="container">
    <div style="padding: 30px">
		<a href="/favorites" class="btn btn-sm btn-primary">お気に入り</a>
        <a href="/appointments" class="btn btn-sm btn-primary">依頼履歴</a>
        <a href="/billing" class="btn btn-sm btn-primary">成立履歴</a><br>
        課金対象案件を確認するには成立履歴をご確認ください。
    </div>

    <div style="padding-bottom: 44px;">
        <div class="table-responsive">
            <table class="table table-striped table-warning text-center" style="line-height: 18px">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">注文ID</th>
                        <th scope="col">会社名</th>
                        <th scope="col">商品名</th>
                        <th scope="col">注文日</th>
                        <th scope="col">承認状況</th>
                        <th scope="col">アポイント日時</th>
                        <th scope="col">キャンセル</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
$count = 1;
    for ($i = 0; $i < count($fetch_order_info_once); $i++) {
        $decode_company = json_decode($fetch_order_info_once[$i]->vendors_info);
        $subCount = 1;
        foreach ($decode_company as $each_company) {
            $decode_contactWay = json_decode($fetch_order_info_once[$i]->contact_way);
            // $subCount = 1;
            foreach ($decode_contactWay as $each_contactWay) {
                $curr_date = date('Y-m-d H:i:s', time());
                if ($each_contactWay->company_id == $each_company->company_id && $curr_date <= $each_contactWay->date_confirm || $each_contactWay->date_confirm == '') {?>
                    <tr>
                        <th scope="row"><?php echo $count++; ?></th>
                        <td><?php echo substr($fetch_order_info_once[$i]->order_id, 0, 8); ?>-<?php echo $subCount++; ?>
                        </td>
                        <td><?php echo $each_company->company_name; ?></td>
                        <td>
                            <?php
$decode_product = json_decode($fetch_order_info_once[$i]->product_info);
                    foreach ($decode_product as $each_product) {
                        echo $each_product->product_name . "<br>";
                    }
                    ?>
                        </td>
                        <td>
                            <?php
echo $fetch_order_info_once[$i]->created_at;
                    ?>
                        </td>
                        <td>
                            <?php
$decode_approval = json_decode($fetch_order_info_once[$i]->vendor_approval);
                    foreach ($decode_approval as $each_approval) {
                        if ($each_approval->company_id == $each_company->company_id) {
                            if ($each_approval->status == 'Pending') {
                                echo "<span class='badge rounded-pill bg_chip'>先方調整中</span>";
                            } else if ($each_approval->status == 'Rejected') {
                                echo "<span class='badge rounded-pill bg_chip'>商談非成立</span>";
                            } else if ($each_approval->status == 'Approved') {
                                echo "<span class='badge rounded-pill bg_chip'>アポイント確定</span>";
                            } else if ($each_approval->status == 'Canceled') {
                                echo "<span class='badge rounded-pill bg_chip'>商談非成立</span>";
                            } else {
                                echo '';
                            }
                        }
                    }
                    ?>
                        </td>
                        <td>
                            <?php
$decode_contactWay = json_decode($fetch_order_info_once[$i]->contact_way);
                    foreach ($decode_contactWay as $each_contactWay) {
                        if ($each_contactWay->company_id == $each_company->company_id) {
                            echo $each_contactWay->date_confirm;
                        }
                    }
                    ?>
                        </td>
                        <td>
                            <?php
date_default_timezone_set('Asia/Tokyo');
                    $curr_date = date('Y-m-d H:i:s', time());
                    $exp_date = date('Y-m-d H:i:s', strtotime($fetch_order_info_once[$i]->created_at . ' + 7 days'));
                    if ($curr_date <= $exp_date) {
                        $decode_approval = json_decode($fetch_order_info_once[$i]->vendor_approval);
                        foreach ($decode_approval as $each_approval) {
                            if ($each_approval->company_id == $each_company->company_id && $each_approval->status == 'Canceled') {?>
                            <span style="color: black; text-align: center">キャンセル済み</span>
                            <?php } else if ($each_approval->company_id == $each_company->company_id && $each_approval->status == 'Rejected') {?>
                                <span style="color: black; text-align: center">キャンセル済み</span>
                            <?php } else if ($each_approval->company_id == $each_company->company_id && $each_approval->status == 'Approved') {
                                echo "";
                            } else if ($each_approval->company_id == $each_company->company_id && $each_approval->status == 'Pending') {?>
                            <form method="post" action="">
                                <input type="hidden" name="oc-order"
                                    value="<?php echo $fetch_order_info_once[$i]->id; ?>">
                                <input type="hidden" name="oc-order-com"
                                    value="<?php echo $each_company->company_id; ?>">
                                <button type="submit" class='badge rounded-pill bg-secondary'>キャンセル</button>
                            </form>
                            <?php }
                        }
                        ?>
                            <?php } else {?>
                            <button class='badge rounded-pill bg-secondary' style="opacity: .7" disabled>キャンセル期限切れ</button>
                            <?php }
                    ?>

                        </td>
                    </tr>
                    <?php
                 break;
                }
            }
        }
    }
    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php }
?>

<?php get_footer();?>