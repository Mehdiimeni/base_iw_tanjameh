<?php
//ChangePass.php


include IW_ASSETS_FROM_PANEL . "include/PageUnity.php";
include "./view/GlobalPage/TopPages.php";
include "./controller/GlobalPage/MenuPart.php";
?>


<!-- Start Page Title -->
<div class="page-title-area">
    <div class="container">
        <div class="page-title-content">
            <h2><?php echo FA_LC["change_password"]; ?></h2>
            <ul>
                <li><a href="./"><?php echo FA_LC["home_page"]; ?></a></li>
                <li><?php echo FA_LC["change_password"]; ?></li>
            </ul>
        </div>
    </div>
</div>
<!-- End Page Title -->


<!-- Start SignUP Area -->
<section class="signup-area ptb-100">
    <div class="container">
        <div class="signup-content">
            <h2><?php echo FA_LC["change_password"]; ?></h2>

            <form class="signup-form"  method="post" action="">


                <div class="form-group">
                    <label><?php echo FA_LC["password"]; ?></label>
                    <input type="password" class="form-control" required="required" placeholder="<?php echo FA_LC["password"]; ?>" id="password" name="Password">
                </div>
                <div class="form-group">
                    <label><?php echo FA_LC["repeat_passwords"]; ?></label>
                    <input type="password" class="form-control" required="required" placeholder="<?php echo FA_LC["repeat_passwords"]; ?>" id="password" name="RePassword">
                </div>



                <button type="submit" class="default-btn" name="RegisterE"
                        type="submit" value="N"><?php echo FA_LC["edit"]; ?></button>

            </form>
        </div>
    </div>
</section>
<!-- End SignUP Area -->

<?php
//include "./controller/Adver/Partner.php";
//include "./view/Adver/Testimonials.php";
//include "./view/Adver/Facility.php";
//include "./view/Adver/Instagram.php";
//include "./view/GlobalPage/ModalParts.php";
include "./view/GlobalPage/FooterArea.php";
?>



