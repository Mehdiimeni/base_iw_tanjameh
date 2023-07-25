<?php
///template/help/help_complaint.</br>php
?>
<div class="container-md">
    <div class="my-4">
        <h2 class="fw-bold">شکایات و انتقادات</h2>
        <h6 class="lh-base">
            مهمترین و اصلی ترین هدف سایت تن جامه، جلب رضایت مشتریان می باشد.</br>
            کاربران می توانند درصورت وجود هرگونه نارضایتی از کالای خریداری شده، کیفیت خدمات ارائه شده یا رفتار پرسنل،
            شکایت یا انتقادات خود را از طریق فرم زیر به ما گزارش دهند.</br>
            لازم به ذکر است که به منظور حفظ احترام و رعایت حقوق شما، گزارش های ارسالی مستقیما توسط مدیران سایت تن جامه
            رویت میشود.</br>
            این اطمینان به شما داده می شود که در اسرع وقت به درخواستها رسیدگی خواهد شد و حقوق شما کاملا محفوظ است.</br>

        </h6>

    </div>
    <div class="my-5 col-12 col-sm-10 col-md-8 col-lg-6 m-auto">
        <div class="mb-4">
            <label for="personalFamily" class="form-label m-0 p-1 border border-bottom-0 border-dark">نام و نام
                خانوادگی</label>
            <div class="input-group">
                <input type="text" class="form-control form-control-lg rounded-0 border-dark" id="personalFamily"
                    required>
                <div class="invalid-feedback">
                    لطفا نام و نام خانوادگی را وارد نمایید
                </div>
            </div>
        </div>
        <div class="mb-4">
            <label for="personalEmail" class="form-label m-0 p-1 border border-bottom-0 border-dark">ایمیل</label>
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
                <input type="text" class="form-control form-control-lg rounded-0 border-dark" id="personalNumber">
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
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ما فقط در صورت لزوم با شما تماس خواهیم گرفت - برای مثال، به‌روزرسانی مهمی در مورد سفارش شما وجود
                        دارد یا به درخواست مراقبت از مشتری شما پاسخ می‌دهیم. و ما هیچ اطلاعات شخصی را با اشخاص ثالث به
                        اشتراک نمی گذاریم، مگر اینکه پیک ما باشد که بسته شما را تحویل می دهد.
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <label for="personalComment" class="form-label m-0 p-1 border border-bottom-0 border-dark">متن</label>
            <div class="input-group">
                <textarea type="text" class="form-control form-control-lg fs-6 rounded-0 border-dark" rows="5"
                    id="personalComment" required></textarea>
                <div class="invalid-feedback">
                    لطفا متن را وارد نمایید
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-dark py-2 fs-5 fw-bold rounded-0" onclick="validateForm()">ارسال</button>
    </div>
</div>