<?php
///template/user/checkout_confirm.php
?>
<div class="d-flex flex-column vh-100">
    <div class="hedear">
        <nav class="navbar bg-secondary">
            <div class="container">
                <a class="navbar-brand" href="./">
                    <img src="./itemplates/iweb/media/logo.png" alt="" width="100" height="39">
                </a>
            </div>
        </nav>
        <div class="container-md">
            <div class="m-2 m-sm-4">
                <ol id="progress-bar">
                    <li class="step-done">ورود</li>
                    <li class="step-done">
                        <a href="./?user=checkout_address" class="text-decoration-none text-orange">آدرس</a>
                    </li>
                    <li class="step-active">تایید</li>
                    <li class="step-todo">پایان!</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- start section -->
    <section class="z-1 w-100">
        <div class="container-md px-2 px-sm-5 my-2">
            <div class="col-12 col-md-10 m-auto">
                <div class="d-flex align-items-end w-100 mb-3">
                    <h5 class="fw-bold lh-sm m-0 p-0">خلاصه سفارش</h5>
                </div>
                <hr class="mt-0 mb-4">
                <div class="row gx-3">
                    <div class="col-12 col-md-8">
                        <div class="d-flex w-100">
                            <h5 class="fw-bold lh-base">گزینه تحویل</h5>
                        </div>
                        <hr class="mt-0">
                        <div class="form-check ms-2">
                            <input id="deliveryOption1" class="form-check-input" type="radio" name="deliveryOption"
                                checked />
                            <label class="form-check-label ms-3" for="deliveryOption1">
                                <span class="fw-bold fs-5"> 25 روز کاری </span>
                                <br>
                                <span class="text-secondary-emphasis">تحویل استاندارد</span>
                            </label>
                        </div>
                        <p class="small text-body-tertiary my-3">ارسال سریع برای این سفارش امکان پذیر نیست.</p>
                        <div class="d-flex w-100">
                            <h5 class="fw-bold lh-base">سفارش</h5>
                        </div>
                        <hr class="mt-0">
                        <h6>بسته توسط پست تحویل داده می شود</h6>
                        <ul class="p-0 list-unstyled">
                            <!-- items product -->
                            <?php $total_parice = 0;
                            $count_product = 0;
                            $total_discount_persent = 0;
                            $total_with_shipping = 0;
                            $total_shipping = 0;
                            foreach ((array) get_cart_info() as $product) { ?>
                                <li class="product hstack gap-3 align-items-start py-3">
                                    <div class="product-image">
                                        <img src='<?php echo $product->images_address; ?>' width="120" alt="">
                                    </div>
                                    <div>
                                        <div class="product-brand lh-sm">
                                            <?php echo ($product->name); ?>
                                        </div>
                                        <div class="product-title">
                                            <?php echo ($product->product_type); ?>
                                        </div>
                                        <p class="m-0">رنگ: <span>
                                                <?php echo ($product->colour); ?>
                                            </span></p>
                                        <p>اندازه: <span>
                                                <?php echo ($product->size); ?>
                                            </span></p>
                                        <p>تعداد: <span>
                                                <?php echo ($product->qty); ?>
                                            </span></p>
                                        <div class="product-line-price fw-semibold d-block text-danger">
                                            <?php echo ($product->price); ?>&nbsp;<span>
                                                <?php echo ($product->name_currency); ?>
                                            </span>
                                        </div>
                                        <?php if ($product->discount_persent) { ?>
                                            <del class="me-2 d-inline-block">
                                                <?php echo ($product->old_price); ?>&nbsp;<span>
                                                    <?php echo ($product->name_currency); ?>
                                                </span>
                                            </del>
                                            <p class="small d-inline-block text-danger">
                                                <?php echo ($product->discount_persent); ?>%
                                            </p>
                                        <?php } ?>
                                    </div>
                                    <div class="ms-auto">
                                        <button class="btn"><i class="fa fa-remove"></i></button>
                                    </div>
                                </li>
                                <li>
                                    <hr class="text-secondary-emphasis">
                                </li>
                                <?php
                                ++$count_product;
                                $total_parice += $product->int_price;
                                $total_shipping += $product->int_shipping_price;
                                $total_discount_persent += $product->int_discount_persent;

                            } ?>
                        </ul>
                        <div class="d-flex w-100">
                            <h5 class="fw-bold lh-base">شرایط قیمت گذاری توضیح داده شده است</h5>
                        </div>
                        <hr class="mt-0">
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="d-flex w-100">
                            <h5 class="fw-bold">آدرس تحویل</h5>
                            <a href="./?user=checkout_address" class="show-choice-address btn ms-auto"><i
                                    class="fa-solid fa-pen"></i></a>
                        </div>
                        <hr class="mt-0">
                        <address class="">

                            <?php echo get_user_address_default()[0]->address_nicname; ?>
                            <br>
                            <?php echo get_user_address_default()[0]->city; ?>
                            <br>
                            <?php echo get_user_address_default()[0]->address; ?>
                            <br>
                            <?php echo get_user_address_default()[0]->address_post_code; ?>
                            <br>
                            <?php echo get_user_address_default()[0]->country_name; ?>
                        </address>
                        <!-- payment method -->
                        <div class="w-100">
                            <h5 class="fw-bold">روش پرداخت</h5>
                            <hr class="mt-0">
                            <div class="mb-4">
                                <div class="d-inline-block mb-1">
                                    <input type="radio" class="btn-check" name="payment" id="btn-payment-1"
                                        autocomplete="off">
                                    <label class="btn btn-outline-dark border-dark-subtle rounded-0"
                                        for="btn-payment-1">
                                        <img src="./itemplates/iweb/media/sep.jpg" alt="بانک سامان">
                                    </label>
                                    <label class="btn btn-outline-dark border-dark-subtle rounded-0"
                                        for="btn-payment-1">
                                        <img src="./itemplates/iweb/media/shaparak.jpg" alt="کلیه کارت های متصل به شاپرک">
                                    </label>
                                </div>

                            </div>
                            <div class="d-flex w-100">
                                <h5 class="fw-bold lh-base">کوپن / کارت هدیه <span
                                        class="text-body-tertiary small">(انتخابی)</span></h5>
                            </div>
                            <hr class="mt-0">
                            <!-- copen or giftcard -->
                            <div>
                                <input id="promo-code" type="text" name="promo-code" maxlength="5"
                                    class="promo-code-field form-control" placeholder="10off">
                                <button
                                    class="promo-code-cta btn btn-white border-orange text-orange w-100 rounded-0 mt-3"
                                    style="display: none;">اعمال</button>
                                <p class="result-promo-code small text-orange mt-1"></p>
                            </div>
                            <div class="totals bg-gainsboro-light p-3">
                                <!-- total -->
                                <div class="d-flex align-items-baseline mb-3">
                                    <p class="small">(قیمت بر حسب تومان میباشد)</p>
                                </div>
                                <div class="totals-item d-flex mb-3">
                                    <label>تحویل</label>
                                    <div class="totals-value ms-auto" id="cart-shipping">
                                        <?php echo ($total_parice); ?>
                                    </div>
                                </div>
                                <hr class="mt-0">
                                <div class="summary-promo mb-3 d-none">
                                    <label>تخفیف</label>
                                    <div class="promo-value final-value ms-auto" id="basket-promo">
                                        <?php $total_discount_persent / $count_product ?>%
                                    </div>
                                </div>
                                <div
                                    class="totals-item totals-item-total d-flex fw-semibold border-top border-secondary-subtle py-2">
                                    <label>
                                        جمع کل
                                        <br>
                                        (با احتساب مالیات بر ارزش افزوده)</label>
                                    <div class="totals-value ms-auto" id="cart-total">
                                        <?php echo $total_shipping + $total_parice; ?>
                                    </div>
                                </div>
                                <a href="./?user=set_bank&bank=saman&price=<?php echo 1500; ?>&cnu=<?php echo base64_encode(base64_encode((1500) . 'saman')); ?>"
                                    class="checkout my-3 w-100 btn text-white btn-next border-0 rounded-0 bg-orange fw-semibold">پرداخت</a>
                            </div>
                            <p class="mt-4 small">
                                با ثبت سفارش در tanjameh.com، با خط مشی رازداری، شرایط و ضوابط و خط مشی لغو موافقت می
                                کنید. شما همچنین تأیید می کنید که این خرید فقط برای استفاده شخصی است. ممکن است گاهی
                                توصیه های محصول را برای شما ایمیل کنیم. نگران نباشید، می‌توانید در هر زمان با کلیک کردن
                                روی پیوند موجود در ایمیل ما، اشتراک خود را لغو کنید.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    <div class="footer border-top border-dark mt-3">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-md pb-4">
                <a class="nav-link d-flex align-items-center" href="#"><i class="fa fa-arrow-right me-2"></i><span>برگشت
                        به فروشگاه</span></a>
                <a class="nav-link" href="#">کمک خواستن؟</a>
                <ul class="d-flex navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="#">ردیابی داده ها</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">اطلاعیه حریم خصوصی</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">شرایط و ضوابط </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">اعلامیه حقوقی</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>