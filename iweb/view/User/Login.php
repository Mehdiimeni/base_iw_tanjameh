<?php
//Login.php
include IW_ASSETS_FROM_PANEL . "include/PageUnity.php";
include "./view/GlobalPage/TopPages.php";
include "./controller/GlobalPage/MenuPart.php";
?>

<!-- Start Page Title -->
<div class="page-title-area">
    <div class="container">
        <div class="page-title-content">
            <h2><?php echo FA_LC['login'];?></h2>
            <ul>
                <li><a href="./"><?php echo FA_LC['home_page'];?></a></li>
                <li><?php echo FA_LC['login'];?></li>
            </ul>
        </div>
    </div>
</div>
<!-- End Page Title -->

<!-- Start Login Area -->
<section class="login-area ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="login-content">
                    <h2><?php echo FA_LC['login'];?></h2>

                    <form class="login-form" method="post" action="">


                        <div class="form-group">
                            <input name="UserNameL" id="username" type="text" class="form-control"
                                   placeholder=" <?php echo FA_LC["email"]; ?>/<?php echo FA_LC["mobile"]; ?> /<?php echo FA_LC["national_code"]; ?> " />
                        </div>
                        <div class="form-group">
                            <input name="PasswordL" id="password" type="password" class="form-control"
                                   placeholder="<?php echo FA_LC["password"]; ?>" required
                                   oninvalid="this.setCustomValidity('<?php echo FA_LC["required"] ?>')"
                                   oninput="setCustomValidity('')"/>
                        </div>

                        <button  type="submit" name="SubmitL" class="default-btn" value="N"><?php echo FA_LC["enter"]; ?></button>

                        <a href="?part=User&page=Forgot" class="forgot-password"><?php echo FA_LC["forget_password_tip"]; ?></a>
                    </form>
                </div>
            </div>

            <div class="col-lg-6 col-md-6">
                <div class="new-customer-content">
                    <h2><?php echo FA_LC["signup"];?></h2>
                    <p>ثبت نام در سایت تن جامه:
                     <br />   کاربران جهت استفاده از امکانات سایت باید مراحل ثبت نام را طی نمایند. برای این منظور از منوی بالای وب سایت وارد ناحیه کاربری شده و با کلیک بر روی گزینه عضویت، در صفحه جدید باید تمام اطلاعات خواسته شده را به صورت دقیق و صحیح وارد نمایند. با کلیک بر روی گزینه ثبت نام ، در صورتی که همه فیلدها کامل و دقیق پر شده باشند ثبت نام صورت گرفته و میزبان می  تواند از این پس با وارد کردن شماره موبایل و رمز به صفحه خود وارد شوند.
                        <br />   1)	حساب کاربری:
                        <br />  به حساب کاربری خود در وب سایت تن جامه خوش آمدید. شما میتوانید سفارش ها ، بازده ها و اطلاعات حساب خود را در اینجا مدیریت کنید.
                        <br />  2)	سفارش ها:
                        <br />  در این صفحه سفارشات 6 ماه اخیر شما با تمامی مشخصات نشان داده می شود.
                        <br /> 3)	اطلاعات کاربر:
                        <br /> اطلاعات خود را در این صفحه مشاهده، مدیریت و به روز کنید. این اطلاعات شامل رمز ورود، ایمیل ، شماره مویابل و ... می باشد.
                        <br /> 4)	آدرس ها:
                        <br />  آدرس های خود را در اینجا اضافه و مدیریت کنید.
                        <br />  5)	مارک های شما:
                        <br />  دانستن اینکه شما کدام مارک ها را دوست دارید به ما کمک می کند تا محصولات بیشتری از این مارک را به شما نشان دهیم.
                        <br />  6)	خبرنامه های شما:
                        <br />  شما می توانید با انتخاب ایمیل و مواردی که بیشتر به کسب خبر از آن ها علاقه دارید، خبرنامه را دریافت نمایید.
                        <br /> 7)	اعتبار و کارت هدیه:
                        <br /> شما می توانید از اعتبار خود برای پرداخت کامل سفارش ها استفاده نمایید. توجه داشته باشید که اعتبار قابل تبدیل به پول نقد نمی باشد.
                        <br />  8)	راهنما و سوالات متداول:
                        <br /> در این بخش شما می توانید پاسخ بسیاری از پرسش های خود را پیدا کنید و به این ترتیب در طی پروسه خرید مشکلی نداشته باشید.

                    </p>
                    <a href="?part=User&page=Signup" class="optional-btn"><?php echo FA_LC["signup_tip"]; ?></a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Login Area -->
<?php
include "./controller/Adver/Partner.php";
//include "./view/Adver/Testimonials.php";
//include "./view/Adver/Facility.php";
//include "./view/Adver/Instagram.php";
//include "./view/GlobalPage/ModalParts.php";
include "./view/GlobalPage/FooterArea.php";
?>