<?php
///template/user/myaccount_order_detail.php
$cart_id = $_GET['id'];
if(user_order($cart_id)){
?>

<div class="col-12 col-lg-9">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb b-animate b-dark">
            <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-dark d-inline-block">بررسی کلی</a>
            </li>
            <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-dark d-inline-block">سفارشات</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo($cart_id); ?></li>
        </ol>
    </nav>
    
    <div class="mb-4">
        <div class="d-sm-flex align-items-sm-center justify-content-sm-between">
            <h2 class="fw-bold">
                <span>شماره سفارش:</span>
                <span><?php echo($cart_id); ?></span>
            </h2>
      
        </div>
    </div>

    <dl class="mb-4">
        <div class="d-inline-block me-4">
            <dt>تاریخ سفارش</dt>
            <dd><?php echo(user_order($cart_id)[0]->last_modify); ?></dd>
        </div>
        <div class="d-inline-block me-4">
            <dt>روش پرداخت</dt>
            <dd><?php echo(user_order($cart_id)[0]->BankName); ?></dd>
        </div>
        <div class="d-inline-block me-4">
            <dt>شماره پیگیری</dt>
            <dd><?php echo(user_order($cart_id)[0]->TraceNo); ?></dd>
        </div>

    </dl>
    <?php $total = 0; foreach(user_order($cart_id) as $order){ ?>
    <ol class="list-unstyled">
        <li>
            <hr>
            <ul class="list-unstyled">
                <li>
                    <a href="./?item=<?php echo ($order->product_id); ?>" class="text-decoration-none text-dark mb-3">
                        <div class="hstack gap-4 align-items-start placeholder-glow">
                            <div class="bg-secondary-subtle placeholder">
                                <img class="lazy-image" data-src="<?php echo $order->images_address; ?>" width="70" alt="">
                            </div>
                            <div class="w-100">
                             <!--   <h6 class="m-0 mb-1">Jordan</h6> -->
                                <div class="d-block d-sm-flex justify-content-sm-between">
                                    <div class="text-secondary-emphasis">
                                        <p class="text-dark"><?php echo $order->product_name; ?></p>
                                        <p class="m-0 small">رنگ: <?php echo $order->colour; ?></p>
                                        <p class="m-0 small">اندازه: <?php echo $order->size_text; ?></p>
                                    </div>
                                    
                                </div>
                                <div class="b-animate b-purple d-inline-block">
                                    <a href=".?user=review"
                                        class="text-decoration-none text-mediumpurple small fw-bold d-inline-block">اکنون
                                        نظر دهید</a>
                                </div>
                            </div>
                        </div>
                    </a>
                </li>
            </ul>
        </li>
    </ol>
    <?php } ?>
    <hr>
    <div class="mt-4 d-sm-flex justify-content-sm-between b-animate b-purple">
        <h4 class="fw-bold">جمع </h4>
        <a href="#" class="text-decoration-none text-mediumpurple d-block">دانلود فاکتور</a>
    </div>
    <div class="d-block d-sm-flex">
        <div class="col-12 col-sm-10 col-md-5 ms-auto">
            <!-- total -->

            <div class="d-flex fw-semibold">

                <div class="ms-auto"><?php echo user_order($cart_id)[0]->payment_amount;  ?> <?php echo user_order($cart_id)[0]->currency_name; ?></div>
            </div>
           
        </div>
    </div>
    <hr>
    <h3 class="fw-bold">نشانی تحویل</h3>
    <address class="my-4"><?php echo user_order($cart_id)[0]->city; ?><br><?php echo user_order($cart_id)[0]->address; ?><br><?php echo user_order($cart_id)[0]->post_code; ?><br><?php echo user_order($cart_id)[0]->country_name; ?><br></address>
    </div>
</div>
</div>  

<?php } ?>