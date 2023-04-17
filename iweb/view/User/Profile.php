<?php
//Profile.php


include IW_ASSETS_FROM_PANEL . "include/PageUnity.php";
include "./view/GlobalPage/TopPages.php";
include "./controller/GlobalPage/MenuPart.php";
?>


<!-- Start Page Title -->
<div class="page-title-area">
    <div class="container">
        <div class="page-title-content">
            <h2><?php echo FA_LC["profile_info"]; ?></h2>
            <ul>
                <li><a href="./"><?php echo FA_LC["home_page"]; ?></a></li>
                <li><?php echo FA_LC["profile_info"]; ?></li>
            </ul>
        </div>
    </div>
</div>
<!-- End Page Title -->


<!-- Start SignUP Area -->
<section class="signup-area ptb-100">
    <div class="container">
        <div class="signup-content">
            <h2><?php echo FA_LC["profile_info"]; ?></h2>

            <form class="signup-form"  method="post" action="">
                <div class="form-group">
                    <label><?php echo FA_LC["full_name"]; ?></label>
                    <input type="text" readonly class="form-control" required="required" value="<?php echo @$objEditView->Name; ?>" placeholder="<?php echo FA_LC["full_name"]; ?>" id="fname" name="Name">
                </div>

                <div class="form-group">
                    <label><?php echo FA_LC["email"]; ?></label>
                    <input type="email" readonly value="<?php echo @$objEditView->Email; ?>" class="form-control" required="required" placeholder="<?php echo FA_LC["email"]; ?>" id="lname" name="Email">
                </div>

                <div class="form-group">
                    <label><?php echo FA_LC["mobile"]; ?></label>
                    <input type="tel" class="form-control" value="<?php echo @$objEditView->CellNumber; ?>" readonly required="required" placeholder="<?php echo FA_LC["mobile"]; ?>" id="name" name="CellNumber">
                </div>

                <div class="form-group">
                    <label><?php echo FA_LC["national_code"]; ?></label>
                    <input type="text" class="form-control" maxlength="10" minlength="10" required="required" value="<?php echo @$objEditView->NationalCode; ?>" placeholder="<?php echo FA_LC["national_code"]; ?>" id="password" name="NationalCode">
                </div>

                <div class="form-group">
                    <label><?php echo FA_LC["username"]; ?></label>
                    <select class="form-control" required="required" placeholder="<?php echo FA_LC["username"]; ?>" id="UsernameSelect" name="UsernameSelect">
                        <?php echo $strUsernameSelect; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label><?php echo FA_LC["password"]; ?></label>
                    <input type="password" class="form-control" required="required" placeholder="<?php echo FA_LC["password"]; ?>" id="password" name="Password">
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


