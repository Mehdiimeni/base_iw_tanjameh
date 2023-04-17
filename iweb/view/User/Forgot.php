<?php
//Forgot.php

include IW_ASSETS_FROM_PANEL . "include/PageUnity.php";
include "./view/GlobalPage/TopPages.php";
include "./controller/GlobalPage/MenuPart.php";
?>
    <!-- Start Page Title -->
    <div class="page-title-area">
        <div class="container">
            <div class="page-title-content">
                <h2><?php echo FA_LC['forget_password'];?></h2>
                <ul>
                    <li><a href="./"><?php echo FA_LC['home_page'];?></a></li>
                    <li><?php echo FA_LC['forget_password'];?></li>
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
                        <h2><?php echo FA_LC['forget_password'];?></h2>

                        <form class="login-form" method="post" action="">


                            <div class="form-group">
                                <input name="UserNameL" id="username" type="text" class="form-control"
                                       placeholder=" <?php echo FA_LC["email"]; ?>/<?php echo FA_LC["mobile"]; ?> /<?php echo FA_LC["national_code"]; ?> " />
                            </div>

                            <button type="submit" name="SubmitForget" value="F" class="default-btn"><?php echo FA_LC["send"]; ?></button>

                            <a href="?part=User&page=Login" class="forgot-password"><?php echo FA_LC["login"]; ?></a>
                        </form>
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