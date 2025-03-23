<?php
/* 
Template Name: Billing 
*/  
$_email = $_SESSION['apo_log_mail'];
global $seconddb;

if ( !isset($_SESSION['apo_log_tkn']) ){
    header("Location: /");
}

get_header();   

$fetch_order_info_once = $seconddb->get_results( "SELECT * FROM orders WHERE seller_id='$_email'");
$seller_id = $fetch_order_info_once[0]->seller_id;



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


    .registerbtn, .loginBtn {
        background-color: #383aff;
        color: white;
        padding: 16px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
        opacity: 0.9;
    }

    .registerbtn:hover, .loginBtn:hover {
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
    .nav_sec li{
        padding: 10px;
        margin: 5px;
        float: right;
        background-color: white;
    } 
    .bg_chip{
        background-color: #f08080;
    }
</style>


<div class="container">

    <div style="padding: 30px">
		<a href="/favorites" class="btn btn-sm btn-primary">お気に入り</a>
        <a href="/appointments" class="btn btn-sm btn-primary">依頼履歴</a>
        <a href="/billing" class="btn btn-sm btn-primary">成立履歴</a>
	</div>

    <div style="padding-bottom: 44px;">
        <div class="table-responsive">
            <table class="table table-striped table-warning text-center">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Order Id</th>
                        <th scope="col">会社名</th>
                        <th scope="col">商品名</th>
                        <th scope="col">価格</th>
                        <th scope="col">注文日</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                        $count = 1;
                        for($i=0; $i < count($fetch_order_info_once); $i++){ 
                            $decode_company = json_decode($fetch_order_info_once[$i]->vendors_info);
                            $subCount = 1;
                            foreach($decode_company as $each_company){ 
                                $decode_approval = json_decode($fetch_order_info_once[$i]->vendor_approval);
                                        foreach($decode_approval as $each_approval){
                                            if($each_approval->company_id == $each_company->company_id && $each_approval->status == 'Approved'){ ?>
                                                <tr>
                                                    <th scope="row"><?php echo $count++; ?></th>
                                                    <td><?php echo substr($fetch_order_info_once[$i]->order_id,0,8)?>-<?php echo $subCount++; ?></td>
                                                    <td><?php echo $each_company->company_name; ?></td>
                                                    <td>
                                                    <?php 
                                                        $decode_product = json_decode($fetch_order_info_once[$i]->product_info);
                                                        foreach($decode_product as $each_product){
                                                            echo $each_product->product_name . "<br>";
                                                        }
                                                    ?>
                                                    </td>
                                                    <td><?php echo $each_company->charge; ?></td>
                                                    <td><?php echo $fetch_order_info_once[$i]->created_at; ?></td>
                                                </tr>
                                          <?php  }
                                        }
                                ?>
                          <?php }
                        }
                        ?>
                    <!--  -->
                </tbody>
            </table>
        </div>
    </div>

</div>


<?php get_footer(); ?>