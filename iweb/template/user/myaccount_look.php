<?php
///template/user/myaccount_look.php
?>


<!-- side right -->
<div class="col-12 col-lg-9">
    <div class="mb-3">
        <h3 class="fw-bold mb-4">لوک من</h3>
        <h4 class="fw-bold mb-4">در اینجا شما می توانید با نمایش استایل خود کسب درآمد کنید !</h4>
        <h6 class="mb-4">
            <?php if (empty(user_look_page_info()->look_page_name)) { ?>
                <a href="./?user=look_user" class="btn btn-dark w-100 rounded-0 py-2 fw-bold mb-3 text-decoration-none
                    "> اکانت خود را بسازید
                </a>
            <?php } else { ?>
                <a href="./?user=look_page" class="btn btn-dark w-100 rounded-0 py-2 fw-bold mb-3 text-decoration-none
                    "> صفحه من
                </a>
            <?php } ?>
        </h6>
        <div class="row row-cols-1 row-cols-md-2 g-4 mb-4">
            <div class="col">
                <div class="form-check mb-3">
                    <label class="form-check-label mt-1" for="newsletterCheck1">
                        شروع
                    </label>
                </div>
                <p>
                    لازم است پشت و روی کارت ملی و همچنین تصویر خود همراه با برگه پذیرش عضویت به صورت واضح همراه شماره
                    تماس امضا و کارت ملی برای ما ارسال کنید
                </p>
            </div>
            <div class="col">
                <div class="form-check mb-3">
                    <label class="form-check-label mt-1" for="newsletterCheck2">
                        ساخت صفحه
                    </label>
                </div>
                <p>
                    صفحه خود را آنگونه دوست دارید طراحی کنید </p>
            </div>
            <div class="col">
                <div class="form-check mb-3">
                    <label class="form-check-label mt-1" for="newsletterCheck3">
                        ارسال لوک
                    </label>
                </div>
                <p>
                    شما عکس استایل خود را به همراه آیتم ها قرار میدهید </p>
            </div>
            <div class="col">
                <div class="form-check mb-3">
                    <label class="form-check-label mt-1" for="newsletterCheck4">
                        درآمد </label>
                </div>
                <p>
                    اگر کسی از طریق کالایی که شما گذاشته اید خرید کند مبلقی به حساب شما واریز میشود </p>
            </div>
        </div>
    </div>
</div>
</div>
</div>