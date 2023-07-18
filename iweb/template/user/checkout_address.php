<?php
///template/user/checkout_address.php
if (isset($_POST['addressL'])) {
    $user_address_result = @user_adress($_POST);
    if ($user_address_result->stat) {

        switch ($user_address_result->stat_detials) {
            case '22':
                echo "<script>window.location.href = './?user=myaccount-addresses';</script>";
                break;
        }

    } else {

        switch ($user_address_result->stat_detials) {
            case '14':
                echo "<script>alert('" . _LANG['user_address_form_null'] . "');</script>";
                break;

            case '15':
                echo "<script>alert('" . _LANG['user_address_error_exist'] . "');</script>";
                break;
        }

    }

}
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
                    <li class="step-active">آدرس</li>
                    <li class="step-todo">تایید</li>
                    <li class="step-todo">پایان!</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- start section -->
    <section class="z-1 w-100">
        <div class="container-md px-2 px-sm-5 my-2">
            <div class="col-12 col-md-10 m-auto">
                <!-- add new address when address is null -->
                <div class="delivery-address">
                    <div class="row row-cols-1 row-cols-sm-2 gx-5 mb-3">
                        <div class="col">
                            <div class="d-flex w-100">
                                <h5 class="fw-bold">آدرس تحویل</h5>
                                <button class="show-choice-address btn ms-auto"><i class="fa-solid fa-pen"></i></button>
                            </div>
                            <hr class="mt-0">
                            <address>

                                <?php echo get_user_address_default()[0]->NicName; ?>
                                <br>
                                <?php echo get_user_address_default()[0]->city; ?>
                                <br>
                                <?php echo get_user_address_default()[0]->Address; ?>
                                <br>
                                <?php echo get_user_address_default()[0]->PostCode; ?>
                                <br>
                                <?php echo get_user_address_default()[0]->iw_country_id; ?>
                                <br>
                            </address>
                        </div>
                        <div class="col">
                            <div class="d-flex w-100">
                                <h5 class="fw-bold">جزئیات تماس</h5>
                            </div>
                            <hr class="mt-1">
                            <p>
                                اگر تحویل به یک نقطه تحویل را انتخاب کرده اید، زمانی که بسته شما برای تحویل گرفتن آماده
                                شد، از طریق پیامک با شما تماس خواهیم گرفت، بنابراین لطفاً بهترین شماره تماس خود را برای
                                ما بگذارید. فراموش نکنید که شناسنامه خود را همراه داشته باشید.
                            </p>
                        </div>
                        <div class="col">
                            <a href="./?user=checkout_confirm"
                                class="btn-next btn w-100 border-0 rounded-0 text-white bg-orange">بعدی</a>
                        </div>
                    </div>
                </div>
                <div class="choice-address hide col-12 col-sm-10 col-md-8 col-lg-6 m-auto">
                    <h5 class="fw-bold">آدرس تحویل</h5>
                    <hr class="mt-0">
                    <div class="card text-center rounded-0 mb-3">
                        <div class="card-body border-bottom border-3 border-orange text-orange">
                            <i class="fa-solid fa-house-chimney fs-1"></i>
                            <p class="font-x-s">آدرس من</p>
                        </div>
                    </div>
                    <div class="accordion" id="accordionWithRadio">
                        <!-- address exists -->
                        <div class="mb-4 pb-4 border-bottom">
                            <div class="form-check d-flex align-items-start">
                                <input id="customRadio1" class="form-check-input" type="radio" name="customRadio" />
                                <label class="form-check-label ms-4" for="customRadio1">
                                    <?php echo get_user_address_default()[0]->NicName; ?>
                                    <br>
                                    <?php echo get_user_address_default()[0]->city; ?>
                                    <br>
                                    <?php echo get_user_address_default()[0]->Address; ?>
                                    <br>
                                    <?php echo get_user_address_default()[0]->PostCode; ?>
                                    <br>
                                    <?php echo get_user_address_default()[0]->iw_country_id; ?>
                                </label>
                                <button class="btn ms-auto" data-bs-toggle="collapse" data-bs-target="#collapseOne"><i
                                        class="fa-solid fa-pen"></i></button>
                            </div>
                            <div id="collapseOne" class="collapse" data-bs-parent="#accordionWithRadio">
                                <div class="m-4">
                                    <form class="needs-validation small" novalidate>
                                        <div class="radio-btn-group mb-3">
                                            <div class="radio">
                                                <input type="radio" name="radioEdit1" value="menEdit1" checked="checked"
                                                    v-model="checked" id="menEdit1" />
                                                <label for="menEdit1">مرد</label>
                                            </div>
                                            <div class="radio">
                                                <input type="radio" name="radioEdit1" value="womenEdit1"
                                                    v-model="checked" id="womenEdit1" />
                                                <label for="womenEdit1">زن</label>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="nameInputEdit1" class="form-label">نام*</label>
                                            <input type="text" class="form-control rounded-0" id="nameInputEdit1"
                                                required>
                                            <div class="invalid-feedback">
                                                فیلد نام را کامل نمایید
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="familyInputEdit1" class="form-label">نام خانوادگی*</label>
                                            <input type="text" class="form-control rounded-0" id="familyInputEdit1"
                                                required>
                                            <div class="invalid-feedback">
                                                فیلد نام خانوادگی را کامل نمایید
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="zipcodeInputEdit1" class="form-label">کد پستی*</label>
                                            <input type="text" class="form-control rounded-0" id="zipcodeInputEdit1"
                                                required>
                                            <div class="invalid-feedback">
                                                فیلد کد پستی را کامل نمایید
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="cityInputEdit1" class="form-label">شهر*</label>
                                            <input type="text" class="form-control rounded-0" id="cityInputEdit1"
                                                required>
                                            <div class="invalid-feedback">
                                                فیلد شهر را کامل نمایید
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="addressInputEdit1" class="form-label">آدرس*</label>
                                            <input type="text" class="form-control rounded-0" id="addressInputEdit1"
                                                required>
                                            <div class="invalid-feedback">
                                                فیلد آدرس را کامل نمایید
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <button
                                                class="btn-white btn border-orange border-2 w-100 text-orange rounded-0"
                                                type="submit">ذخیره</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- add new address -->
                        <div class="mb-5">
                            <div class="form-check">
                                <input data-bs-toggle="collapse" data-bs-target="#collapseTwo" type="radio"
                                    id="customRadio2" name="customRadio" class="form-check-input" />
                                <label class="form-check-label ms-4" for="customRadio2">افزودن آدرس جدید</label>
                            </div>
                            <div id="collapseTwo" class="collapse" data-bs-parent="#accordionWithRadio">
                                <div class="m-4">
                                    <form class="needs-validation small" novalidate>
                                        <div class="radio-btn-group mb-3">
                                            <div class="radio">
                                                <input type="radio" name="radio" value="addMen" checked="checked"
                                                    v-model="checked" id="addMen1" />
                                                <label for="addMen1">مرد</label>
                                            </div>
                                            <div class="radio">
                                                <input type="radio" name="radio" value="addWomen" v-model="checked"
                                                    id="addWomen1" />
                                                <label for="addWomen1">زن</label>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="nameInputAdd2" class="form-label">نام*</label>
                                            <input type="text" class="form-control rounded-0" id="nameInputAdd2"
                                                required>
                                            <div class="invalid-feedback">
                                                فیلد نام را کامل نمایید
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="familyInputAdd2" class="form-label">نام خانوادگی*</label>
                                            <input type="text" class="form-control rounded-0" id="familyInputAdd2"
                                                required>
                                            <div class="invalid-feedback">
                                                فیلد نام خانوادگی را کامل نمایید
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="zipcodeInputAdd2" class="form-label">کد پستی*</label>
                                            <input type="text" class="form-control rounded-0" id="zipcodeInputAdd2"
                                                required>
                                            <div class="invalid-feedback">
                                                فیلد کد پستی را کامل نمایید
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="cityInputAdd2" class="form-label">شهر*</label>
                                            <input type="text" class="form-control rounded-0" id="cityInputAdd2"
                                                required>
                                            <div class="invalid-feedback">
                                                فیلد شهر را کامل نمایید
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="addressInputAdd2" class="form-label">آدرس*</label>
                                            <textarea type="text" class="form-control rounded-0" id="addressInputAdd2"
                                                required></textarea>
                                            <div class="invalid-feedback">
                                                فیلد آدرس را کامل نمایید
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <button
                                                class="btn-white btn border-orange border-2 w-100 text-orange rounded-0"
                                                type="submit">ذخیره</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <a href="./?user=checkout_confirm"
                            class="btn-next btn w-100 border-0 rounded-0 text-white bg-orange">بعدی</a>
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