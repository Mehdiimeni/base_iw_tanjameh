<?php
///template/help/help_contact.php
?>
<div class="container-md">
    <div class="my-4">
        <h2 class="fw-bold">راه های ارتباط با ما</h2>
        <h6 class="lh-base">
            آدرس: تهران ، اندرزگو ، سلیمی شمالی ، پ ۱۲۶ ، زنگ ۲</br>
            تلفن تماس: ۲۲۲۰۶۸۱۲</br>
            ایمیل:info@tanjameh.com </br>
        </h6>

    </div>
    <form class="form-validation pb-5" novalidate>
        <div class="container-md">
            <div class="my-5 col-12 col-sm-10 col-md-8 col-lg-6 m-auto">
                <div class="mb-4 b-animate b-purple">
                    <h2 class="fw-bold">چگونه ما میتوانیم به شما کمک کنیم؟</h2>
                </div>
                <div class="mb-4">
                    <label for="personalFamily" class="form-label m-0 p-1 border border-bottom-0 border-dark">نام و نام
                        خانوادگی</label>
                    <div class="input-group">
                        <input type="text" class="form-control form-control-lg rounded-0 border-dark"
                            id="personalFamily" required>
                        <div class="invalid-feedback">
                            لطفا نام و نام خانوادگی را وارد نمایید
                        </div>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="personalEmail"
                        class="form-label m-0 p-1 border border-bottom-0 border-dark">ایمیل</label>
                    <div class="input-group">
                        <input type="email" class="form-control form-control-lg fs-6 rounded-0 border-dark"
                            placeholder="آدرس ایمیل" id="personalEmail" required>
                        <div class="invalid-feedback">
                            لطفا ایمیل را وارد نمایید
                        </div>
                    </div>
                </div>
                <div class="mb-4 w-100">
                    <label for="personalNumber" class="form-label m-0 p-1 border border-bottom-0 border-dark">
                        <span>شماره موبایل</span>
                        <span class="text-body-tertiary ms-1 font-x-s">(انتخابی)</span>
                    </label>
                    <div class="input-group position-relative">
                        <input type="text" class="form-control form-control-lg rounded-0 border-dark"
                            id="personalNumber">
                        <div class="invalid-feedback">
                            لطفا شماره موبایل را وارد نمایید
                        </div>
                        <!-- Button Mobile number modal -->
                        <button type="button" class="btn p-0 d-inline-block position-absolute end-0 top-0 m-2 mt-3"
                            data-bs-toggle="modal" data-bs-target="#MobileNumberModal">
                            <i class="fa fa-info-circle fs-5"></i>
                        </button>
                    </div>
                </div>
                <!-- Modal Mobile number -->
                <div class="modal fade" id="MobileNumberModal" tabindex="-1" aria-labelledby="MobileNumberModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-sm modal-dialog-centered">
                        <div class="modal-content rounded-0">
                            <div class="modal-header border-0">
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                ما فقط در صورت لزوم با شما تماس خواهیم گرفت - برای مثال، به‌روزرسانی مهمی در مورد سفارش
                                شما وجود دارد یا به درخواست مراقبت از مشتری شما پاسخ می‌دهیم. و ما هیچ اطلاعات شخصی را
                                با اشخاص ثالث به اشتراک نمی گذاریم، مگر اینکه پیک ما باشد که بسته شما را تحویل می دهد.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="container-md">
            <div class="my-5 col-12 col-sm-10 col-md-8 col-lg-6 m-auto">
                <h6>آیا سوال شما مربوط به یک سفارش موجود است؟</h6>
                <div class="radioOrder mb-4">
                    <div class="form-check mb-1">
                        <input class="form-check-input" type="radio" name="radioOrder" id="radioOrder1" value="yes"
                            style="width: 1.2em; height: 1.2em;">
                        <label class="form-check-label" for="radioOrder1">
                            بلی
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="radioOrder" id="radioOrder2" value="no"
                            style="width: 1.2em; height: 1.2em;">
                        <label class="form-check-label" for="radioOrder2">
                            خیر
                        </label>
                    </div>
                </div>
                <div class="boxOrder" style="display: none;">
                    <div class="mb-4 orderNumber" style="display: none;">
                        <label for="personalOrderNumber"
                            class="form-label m-0 p-1 border border-bottom-0 border-dark">شماره سفارش</label>
                        <div class="input-group">
                            <input type="text" class="form-control form-control-lg fs-6 rounded-0 border-dark"
                                id="personalOrderNumber" required>
                            <div class="invalid-feedback">
                                لطفا شماره سفارش را وارد نمایید
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="personalComment"
                            class="form-label m-0 p-1 border border-bottom-0 border-dark">متن</label>
                        <div class="input-group">
                            <textarea type="text" class="form-control form-control-lg fs-6 rounded-0 border-dark"
                                rows="5" id="personalComment" required></textarea>
                            <div class="invalid-feedback">
                                لطفا متن را وارد نمایید
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-dark py-2 fs-5 fw-bold rounded-0"
                        onclick="validateForm()">ارسال</button>
                </div>
            </div>
        </div>
    </form>
</div>