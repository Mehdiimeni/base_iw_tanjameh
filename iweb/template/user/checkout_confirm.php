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
                    <a href="#"
                        class="btn-next btn w-25 border-0 rounded-0 bg-orange text-white ms-auto">پرداخت</a>
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
                                <span class="fw-bold fs-5">چهارشنبه، 01.03. - Sa, 04.03.</span>
                                <br>
                                <span class="text-secondary-emphasis">تحویل استاندارد</span>
                                <br>
                                رایگان
                            </label>
                        </div>
                        <p class="small text-body-tertiary my-3">ارسال سریع برای این سفارش امکان پذیر نیست.</p>
                        <div class="d-flex w-100">
                            <h5 class="fw-bold lh-base">سفارش</h5>
                        </div>
                        <hr class="mt-0">
                        <h6>بسته توسط تن جامه تحویل داده می شود</h6>
                        <p class="fw-bold fs-5">چهارشنبه، 01.03. - Sa, 04.03.</p>
                        <ul class="p-0 list-unstyled">
                            <!-- items product -->
                            <li class="product hstack gap-3 align-items-start py-3">
                                <div class="product-image">
                                    <img src='media/product/product-detail-color-box-1.webp' width="120" alt="">
                                </div>
                                <div>
                                    <div class="product-brand lh-sm">Nike</div>
                                    <div class="product-title">سوییشرت کلاه دار</div>
                                    <p class="m-0">رنگ: <span>سرمه ای</span></p>
                                    <p>اندازه: <span>xl</span></p>
                                    <div class="product-line-price fw-semibold d-block text-danger">
                                        12.99&nbsp;<span>تومان</span></div>
                                    <del class="me-2 d-inline-block">14.99&nbsp;<span>تومان</span></del>
                                    <p class="small d-inline-block text-danger">20%</p>
                                </div>
                                <div class="ms-auto">
                                    <button class="btn"><i class="fa fa-remove"></i></button>
                                </div>
                            </li>
                            <li>
                                <hr class="text-secondary-emphasis">
                            </li>
                            <!-- items product -->
                            <li class="product hstack gap-3 align-items-start py-3">
                                <div class="product-image">
                                    <img src='media/product/product-detail-color-box-1.webp' width="120" alt="">
                                </div>
                                <div>
                                    <div class="product-brand lh-sm">Nike</div>
                                    <div class="product-title">سوییشرت کلاه دار</div>
                                    <p class="m-0">رنگ: <span>سرمه ای</span></p>
                                    <p>اندازه: <span>m</span></p>
                                    <div class="product-line-price fw-semibold d-block text-danger">
                                        12.99&nbsp;<span>تومان</span></div>
                                    <del class="me-2 d-inline-block">14.99&nbsp;<span>تومان</span></del>
                                    <p class="small d-inline-block text-danger">20%</p>
                                </div>
                                <div class="ms-auto">
                                    <button class="btn"><i class="fa fa-remove"></i></button>
                                </div>
                            </li>
                        </ul>
                        <div class="d-flex w-100">
                            <h5 class="fw-bold lh-base">شرایط قیمت گذاری توضیح داده شده است</h5>
                        </div>
                        <hr class="mt-0">
                        <h6 class="text-body-tertiary">در اصل</h6>
                        <h6>قیمت کالا برای اولین بار در لیست شده است.</h6>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="d-flex w-100">
                            <h5 class="fw-bold">آدرس تحویل</h5>
                            <a href="./?user=checkout_address" class="show-choice-address btn ms-auto"><i
                                    class="fa-solid fa-pen"></i></a>
                        </div>
                        <hr class="mt-0">
                        <address class="">Seyed Shirazi<br>High Street<br>EN6 5BA Potters Bar<br>United Kingdom<br>
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
                                        <img src="media/enamad.png" alt="">
                                    </label>
                                </div>
                                <div class="d-inline-block mb-1">
                                    <input type="radio" class="btn-check" name="payment" id="btn-payment-2"
                                        autocomplete="off">
                                    <label class="btn btn-outline-dark border-dark-subtle rounded-0"
                                        for="btn-payment-2">
                                        <img src="media/enamad.png" alt="">
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
                                    <div class="totals-value ms-auto" id="cart-shipping">15.00</div>
                                </div>
                                <hr class="mt-0">
                                <div class="summary-promo mb-3 d-none">
                                    <label>تخفیف</label>
                                    <div class="promo-value final-value ms-auto" id="basket-promo"></div>
                                </div>
                                <div
                                    class="totals-item totals-item-total d-flex fw-semibold border-top border-secondary-subtle py-2">
                                    <label>
                                        جمع کل
                                        <br>
                                        (با احتساب مالیات بر ارزش افزوده)</label>
                                    <div class="totals-value ms-auto" id="cart-total">42.28</div>
                                </div>
                                <a href="#"
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