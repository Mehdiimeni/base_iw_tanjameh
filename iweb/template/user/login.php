<?php
///template/user/login.php


if(isset($_POST['registerL']))
{
    if (@user_signup($_POST)->stat) {

        switch (user_signup($_POST)->stat_detials) {
            case '20':
                echo "<script>window.location.href = './?user=cart';</script>";
                break;

            case '21':
                echo "<script>window.location.href = './?user=myaccount';</script>";
                break;
        }

    } else {

        switch (@user_signup($_POST)->stat_detials) {
            case '12':
                echo "<script>alert('" . _LANG['user_signup_form_null'] . "');</script>";
                break;

            case '13':
                echo "<script>alert('" . _LANG['user_signup_error_exist'] . "');</script>";
                break;
        }

    }

}


if (isset($_POST['loginL'])) {

    $username = $_POST['UserNameL'];
    $password = $_POST['PasswordL'];

    if (@user_login($username, $password)->stat) {

        switch (user_login($username, $password)->stat_detials) {
            case '20':
                echo "<script>window.location.href = './?user=cart';</script>";
                break;

            case '21':
                echo "<script>window.location.href = './?user=myaccount';</script>";
                break;
        }

    } else {

        switch (@user_login($username, $password)->stat_detials) {
            case '10':
                echo "<script>alert('" . _LANG['user_pass_null'] . "');</script>";
                break;

            case '11':
                echo "<script>alert('" . _LANG['user_login_error'] . "');</script>";
                break;
        }

    }
}

?>
<header>
    <nav class="navbar border-0 mb-3">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="./itemplates/iweb/media/logo.png" alt="" width="100" height="39">
            </a>
        </div>
    </nav>
</header>
<!-- start section -->
<section>
    <div class="accordion accordion-flush px-3 px-sm-0" id="accordionAuthenticate">
        <div class="accordion-item col-12 col-sm-8 col-md-6 col-lg-4 m-auto border-0">
            <h3 class="loginTitle fw-bold mb-3">
                <?php echo _LANG['welcome']; ?>
            </h3>
            <button id="btnLogin" class="btn btn-dark w-100 fw-bold rounded-0 py-2" type="button"
                data-bs-toggle="collapse" data-bs-target="#login-collapse">
                ورود
            </button>
            <div id="login-collapse" class="accordion-collapse collapse" data-bs-parent="#accordionAuthenticate">
                <div class="accordion-body px-0">
                    <div class="boxLogin">
                        <form class="needs-validation" method="post" action="" novalidate>
                            <div class="mb-4">
                                <label for="loginEmail"
                                    class="form-label m-0 p-1 border border-bottom-0 border-dark"><?php echo _LANG["email"]; ?>/<?php echo _LANG["mobile_number"]; ?></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white rounded-0 border-end-0 border-dark"><i
                                            class="fa-regular fa-envelope"></i></span>
                                    <input type="text" name="UserNameL"
                                        class="form-control py-2 border-start-0 rounded-0 border-dark"
                                        placeholder="<?php echo _LANG["email"]; ?>/<?php echo _LANG["mobile_number"]; ?>"
                                        id="loginEmail" required>
                                    <div class="invalid-feedback">
                                        <?php echo _LANG['please_enter_your_email']; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="loginPass" class="form-label m-0 p-1 border border-bottom-0 border-dark">
                                    <?php echo _LANG["password"]; ?>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white rounded-0 border-end-0 border-dark"><i
                                            class="fa-solid fa-lock"></i></span>
                                    <input type="password" name="PasswordL" type="password"
                                        class="password form-control py-2 border-start-0 border-end-0 rounded-0 border-dark"
                                        placeholder="<?php echo _LANG["password"]; ?>" id="loginPass" required>
                                    <span class="input-group-text bg-white border-dark rounded-0 border-start-0">
                                        <i class="fa fa-eye togglePassword" style="cursor: pointer"></i>
                                    </span>
                                    <div class="invalid-feedback">
                                        <?php echo _LANG["please_enter_password"]; ?>

                                    </div>
                                </div>
                            </div>
                            <button type="submit" name="loginL" class="btn btn-dark w-100 rounded-0 py-2 fw-bold mb-4">
                                <?php echo _LANG["enter"]; ?>
                            </button>
                            <div class="b-animate b-purple">
                                <a href="#"
                                    class="btnForgetPass d-inline-block text-decoration-none fw-bold small text-mediumpurple">
                                    <?php echo _LANG["forget_password_tip"]; ?></a>
                            </div>
                        </form>
                    </div>
                    <div class="boxForgetPass">
                        <h3 class="fw-bold mb-3">رمز عبور خود را بازنشانی کنید</h3>
                        <h6 class="mb-3">آدرس ایمیل مرتبط با حساب Tanjameh خود را وارد کنید، و ما پیوند بازنشانی را برای
                            شما ارسال خواهیم کرد.</h6>
                        <form>
                            <div class="mb-4">
                                <label for="loginEmail"
                                    class="form-label m-0 p-1 border border-bottom-0 border-dark">آدرس ایمیل</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white rounded-0 border-end-0 border-dark"><i
                                            class="fa-regular fa-envelope"></i></span>
                                    <input type="email" class="form-control py-2 border-start-0 rounded-0 border-dark"
                                        placeholder="آدرس ایمیل" id="loginEmail" required>
                                    <div class="invalid-feedback">
                                        لطفا ایمیل خود را وارد نمایید
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-dark w-100 rounded-0 py-2 fw-bold mb-4">دریافت لینک
                                بازیابی</button>
                            <div class="b-animate b-purple">
                                <a href="#"
                                    class="btnBackLogin d-inline-block text-decoration-none fw-bold small text-mediumpurple">برگشت
                                    به ورود</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="accordion-item col-12 col-sm-8 col-md-6 col-lg-4 m-auto border-0">
            <h3 class="fw-bold mb-3">من اینجا جدید هستم</h3>
            <button id="btnRegister" class="btn btn-dark w-100 fw-bold rounded-0 py-2" type="button"
                data-bs-toggle="collapse" data-bs-target="#register-collapse">
                ثبت نام
            </button>
            </h2>
            <div id="register-collapse" class="accordion-collapse collapse" data-bs-parent="#accordionAuthenticate">
                <div class="accordion-body px-0">
                    <div>
                        <form class="needs-validation" method="post" action="" novalidate>
                            <div class="mb-4">
                                <label for="registerName"
                                    class="form-label m-0 p-1 border border-bottom-0 border-dark">نام و نام خانوادگی
                                    *</label>
                                <div class="input-group">
                                    <input type="text" name="Name" class="form-control py-2 rounded-0 border-dark"
                                        placeholder="نام و نام خانوادگی" id="registerName" required>
                                    <div class="invalid-feedback">
                                        لطفا نام و نام خانوادگی خود را وارد نمایید
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="registerFamily"
                                    class="form-label m-0 p-1 border border-bottom-0 border-dark">شماره همراه *</label>
                                <div class="input-group">
                                    <input type="tel" name="CellNumber" class="form-control py-2 rounded-0 border-dark"
                                        placeholder="شماره همراه" id="registerFamily" required>
                                    <div class="invalid-feedback">
                                        لطفا شماره همراه خود را وارد نمایید
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="registerEmail"
                                    class="form-label m-0 p-1 border border-bottom-0 border-dark">آدرس ایمیل *</label>
                                <div class="input-group">
                                    <input type="email" name="Email" class="form-control py-2 rounded-0 border-dark"
                                        placeholder="آدرس ایمیل" id="registerEmail" required>
                                    <div class="invalid-feedback">
                                        لطفا ایمیل خود را وارد نمایید
                                    </div>
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="registerPass"
                                    class="form-label m-0 p-1 border border-bottom-0 border-dark">رمز عبور *</label>
                                <div class="input-group">
                                    <input type="password" name="Password"
                                        class="password form-control py-2 border-end-0 rounded-0 border-dark"
                                        placeholder="رمز عبور" id="registerPass" required>
                                    <span class="input-group-text bg-white border-dark rounded-0 border-start-0">
                                        <i class="fa fa-eye togglePassword" style="cursor: pointer"></i>
                                    </span>
                                    <div class="invalid-feedback">
                                        لطفا رمز عبور خود را وارد نمایید
                                    </div>
                                </div>
                            </div>
                            <div class="small mb-4">
                                <i class="fa fa-info-circle me-2"></i>
                                <span>رمز عبورتان تا ۸ کاراکتر مجاز میباشد</span>
                            </div>
                            <div class="mb-3">
                                <h5 class="d-inline-block mb-3">بیشتر به چه چیزی علاقه دارید؟</h5>
                                <small class="text-body-tertiary">(انتخابی)</small>
                                <h6 class="text-body-tertiary">ما از این اطلاعات برای ارائه توصیه‌های شخصی‌شده‌تر
                                    استفاده خواهیم کرد.</h6>
                            </div>
                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" value="women" name="Fashionpreference"
                                        id="FashionRadios1">
                                    <label class="form-check-label fs-5" for="FashionRadios1">
                                        مد زنانه
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" value="men" name="Fashionpreference"
                                        id="FashionRadios2">
                                    <label class="form-check-label fs-5" for="FashionRadios2">
                                        مد مردانه
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" value="none" name="Fashionpreference"
                                        id="FashionRadios3" checked>
                                    <label class="form-check-label fs-5" for="FashionRadios3">
                                        بدون ترجیهات
                                    </label>
                                </div>
                            </div>
                            <hr>
                            <div class="form-check mb-3">
                                <input class="form-check-input" name="accept" required type="checkbox"
                                    id="reciveCheckbox">
                                <label class="form-check-label" for="reciveCheckbox">
                                    بله، من مایلم گاه به گاه ایمیل هایی درباره پیشنهادات ویژه، محصولات جدید و تبلیغات
                                    انحصاری دریافت کنم. من می توانم اشتراک خود را در هر زمان لغو کنم. (اختیاری)
                                </label>
                            </div>
                            <button type="submit" name="registerL"
                                class="btn btn-dark w-100 rounded-0 py-2 fw-bold mb-3">ثبت
                                نام</button>
                            <small class="text-body-tertiary">* فیلد اجباری</small>
                        </form>
                        <div class="b-animate b-purple my-4">
                            <p>
                                با ثبت نام برای یک حساب کاربری، با <a href="#"
                                    class="text-decoration-none text-mediumpurple d-inline-block">شرایط استفاده</a> ما
                                موافقت می کنید. لطفا اعلامیه <a href="#"
                                    class="text-decoration-none text-mediumpurple d-inline-block">حریم خصوصی</a> ما را
                                بخوانید.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<footer class="text-center mt-5">
    <div class="b-animate b-dark mb-3 small">
        <a href="#" class="text-decoration-none text-dark d-inline-block mx-3">اطلاعیه حفظ حریم خصوصی</a>
        <a href="#" class="text-decoration-none text-dark d-inline-block mx-3"> شرایط استفاده</a>
        <a href="#" class="text-decoration-none text-dark d-inline-block mx-3"> اطلاع قانونی</a>
    </div>
    <a class="navbar-brand my-5 pb-3 d-inline-block" href="#">
        <img src="./itemplates/iweb/media/logo.png" alt="" width="100" height="39">
    </a>
</footer>
<!-- spinner show -->
<div id="loader">
    <div class="d-flex justify-content-center align-items-center h-100">
        <div class="spinner-border text-orange" role="status">
            <span class="visually-hidden">در حال ذخیره سازی...</span>
        </div>
    </div>
</div>