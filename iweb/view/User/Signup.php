<?php
//Signup.php
include IW_ASSETS_FROM_PANEL . "include/PageUnity.php";
include "./view/GlobalPage/TopPages.php";
include "./controller/GlobalPage/MenuPart.php";
?>
<!-- Start Page Title -->
<div class="page-title-area">
    <div class="container">
        <div class="page-title-content">
            <h2><?php echo FA_LC["signup"]; ?></h2>
            <ul>
                <li><a href="./"><?php echo FA_LC['home_page'];?></a></li>
                <li><?php echo FA_LC["signup"]; ?></li>
            </ul>
        </div>
    </div>
</div>
<!-- End Page Title -->

<!-- Start SignUP Area -->
<section class="signup-area ptb-100">
    <div class="container">
        <div class="signup-content">
            <h2><?php echo FA_LC["signup"]; ?></h2>

            <form class="signup-form"  method="post" action="">
                <div class="form-group">
                    <label><?php echo FA_LC["full_name"]; ?></label>
                    <input type="text" class="form-control" maxlength="85" minlength="6" required="required" placeholder="<?php echo FA_LC["full_name"]; ?>" id="fname" name="Name">
                </div>

                <div class="form-group">
                    <label><?php echo FA_LC["email"]; ?></label>
                    <input type="email" class="form-control" required="required" placeholder="<?php echo FA_LC["email"]; ?>" id="lname" name="Email">
                </div>

                <div class="form-group">
                    <label><?php echo FA_LC["mobile"]; ?></label>
                    <input type="tel" class="form-control" maxlength="17" minlength="10" required="required" placeholder="<?php echo FA_LC["mobile"]; ?>" id="name" name="CellNumber">
                </div>

                <div class="form-group">
                    <label><?php echo FA_LC["username"]; ?></label>
                    <select class="form-control" required="required" placeholder="<?php echo FA_LC["username"]; ?>" id="UsernameSelect" name="UsernameSelect">
                        <?php echo $strUsernameSelect; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label><?php echo FA_LC["password"]; ?></label>
                    <input type="password" maxlength="85" minlength="6" class="form-control" required="required" placeholder="<?php echo FA_LC["password"]; ?>" id="password" name="Password">
                </div>

                <button type="submit" class="default-btn" name="RegisterL"
                        type="submit" value="N"><?php echo FA_LC["send"]; ?></button>

                <a href="./" class="return-store"><?php echo FA_LC['home_page'];?></a>
            </form>
        </div>
    </div>
</section>
<!-- End SignUP Area -->

<?php
include "./controller/Adver/Partner.php";
//include "./view/Adver/Testimonials.php";
//include "./view/Adver/Facility.php";
//include "./view/Adver/Instagram.php";
//include "./view/GlobalPage/ModalParts.php";
include "./view/GlobalPage/FooterArea.php";
?>
