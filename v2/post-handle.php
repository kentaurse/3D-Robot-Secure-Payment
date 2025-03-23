<?php
/* 
Template Name: PostHandle 
*/  
get_header();

?>

<style>
    .p-header__welcart-nav {
        display: none;
    }
</style>
<?php
$order_id = '';
if(isset($_GET['order']) & !empty($_GET['order']) & isset($_GET['com']) & !empty($_GET['com'])){
    $order_id = $_GET['order'];
    $approval = $seconddb->get_var("SELECT vendor_approval FROM orders WHERE id='$order_id'");
    $decode_approval = json_decode($approval);
    foreach($decode_approval as $each_approval){
        if($each_approval->company_id == $_GET['com'] && $each_approval->status != 'Pending'){
            if($each_approval->status == 'Canceled'){ ?>
                <div class="container">
                    <div class="d-flex justify-content-md-center align-items-center" style="height: 80vh!important">
                        <div>
                            <div class="card text-center">
                                <div class="card-body">
                                    <h5 class="card-title" style="font-size: 23px;font-weight: 600;">本案件は商談相手が商談オファーをキャンセルしました。</h5>
                                    <h5 class="card-title" style="font-size: 23px;font-weight: 600;">そのため、自動的に不成立扱いとなっております。</h5>
                                    <h5 class="card-title" style="font-size: 23px;font-weight: 600;">恐れ入りますが、また別の商談にてご対応頂けますと幸いです。
                                    </h5>

                                    <hr>
                                    <a href="about:blank" target="" class="btn btn-primary">閉じる</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
          <?php }else{ ?>
            <div class="container">
                    <div class="d-flex justify-content-md-center align-items-center" style="height: 80vh!important">
                        <div>
                            <div class="card text-center">
                                <div class="card-body">
                                    <h5 class="card-title" style="font-size: 23px;font-weight: 600;">本案件については既に回答を頂いております。</h5>
                                    <h5 class="card-title" style="font-size: 23px;font-weight: 600;">アポイント確定している場合には自動返信メールが</h5>
                                    <h5 class="card-title" style="font-size: 23px;font-weight: 600;">ご登録のメールアドレス宛に既に届いていますのでご確認くださいませ。
                                    </h5>
                                    <h5 class="card-title" style="font-size: 23px;font-weight: 600;">非承認の場合にはメールは届いておりませんのでご注意くださいませ。
                                    </h5>
                                    <hr>
                                    <a href="about:blank" target="" class="btn btn-primary">閉じる</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
          <?php }
        }
    }
}
?>