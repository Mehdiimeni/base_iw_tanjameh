<?php
///template/look/look_user.php

if (isset($_POST['look_reg'])) {
    $user_look_result = @user_look_reg($_FILES);
    if ($user_look_result->stat) {


        $_SESSION['user_id'] = $user_look_result->user_id;

        setcookie(
            'user_id',
            base64_encode($user_look_result->user_id),
            time() + (7 * 24 * 60 * 60),
            '/'
        );

        switch ($user_look_result->stat_detials) {
            case '20':
                JavaTools::JsAlertWithRefresh(_LANG['user_look_documents_add'], 0, './?user=myaccount_look');
                break;    

        }

    } else {

        switch ($user_look_result->stat_detials) {
            case '12':
                echo "<script>alert('" . _LANG['user_look_form_null'] . "');</script>";
                break;

            case '13':
                echo "<script>alert('" . _LANG['user_look_error_exist'] . "');</script>";
                break;

            case '14':
                echo "<script>alert('" . _LANG['enter_format_file_error'] . "');</script>";
                break;

            case '15':
                echo "<script>alert('" . _LANG['enter_size_file_error'] . "');</script>";
                break;
        }

    }


}
?>
<div class="col-12 col-lg-9">
    <form class="needs-validation" method="post" action="" enctype="multipart/form-data" novalidate>
        <div class="my-5 col-12 col-sm-10 col-md-8 col-lg-6 m-auto">
            <div class="mb-4 b-animate b-purple">
                <h2 class="fw-bold">ورود اطلاعات برای ثبت نام در بخش لوک</h2>
            </div>
            <div class="mb-4">
                <label for="personalFamily" class="form-label m-0 p-1 border border-bottom-0 border-dark">تصویر روی کارت
                    ملی</label>
                <div class="input-group">
                    <input type="file" name="id_cart_front"
                        class="form-control form-control-lg fs-6 rounded-0 border-dark" id="personalFamily" required>
                    <div class="invalid-feedback">
                        تصویر روی کارت ملی
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <label for="personalEmail" 
                    class="form-label m-0 p-1 border border-bottom-0 border-dark">تصویر پشت کارت
                    ملی</label>
                <div class="input-group">
                    <input type="file" name="id_cart_back" class="form-control form-control-lg fs-6 rounded-0 border-dark"
                        id="personalEmail" required>
                    <div class="invalid-feedback">
                        تصویر پشت کارت ملی
                    </div>
                </div>
            </div>
            <div class="mb-4 w-100">
                <label for="personalNumber" class="form-label m-0 p-1 border border-bottom-0 border-dark">
                    <span>تصویر شخص و رضایت نامه</span>
                </label>
                <div class="input-group position-relative">
                    <input type="file" name="user_face" class="form-control form-control-lg fs-6 rounded-0 border-dark"
                        id="personalNumber">
                    <div class="invalid-feedback">
                        تصویر شخص و رضایت نامه
                    </div>
                    <!-- Button Mobile number modal -->
                    <button type="button" class="btn p-0 d-inline-block position-absolute end-0 top-0 m-2 mt-3"
                        data-bs-toggle="modal" data-bs-target="#MobileNumberModal">
                        <i class="fa fa-info-circle fs-5"></i>
                    </button>
                </div>
            </div>
            <div class="modal fade" id="MobileNumberModal" tabindex="-1" aria-labelledby="MobileNumberModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-sm modal-dialog-centered">
                    <div class="modal-content rounded-0">
                        <div class="modal-header border-0">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            لطفا روی کاغد متن پذیرش استفاده از قسمت لوک را بنویسید تاریخ بزنید امضا کنید ان را در دست
                            راست خود و زیر آن کارت ملی خود را قرار بدهید همراه باصورت خود عکس بگیرید
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" name="look_reg" value="1"
                class="btn btn-dark btn-lg fw-bold fs-6 py-3 rounded-0 d-flex align-items-center">
                <i class="fa-regular fa-envelope me-2 fs-4"></i>
                <span>من را ثبت نام کن</span>
            </button>

        </div>
    </form>
</div>
</div>
</div>