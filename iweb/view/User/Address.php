<?php
//Address.php

include IW_ASSETS_FROM_PANEL . "include/PageUnity.php";
include "./view/GlobalPage/TopPages.php";
include "./controller/GlobalPage/MenuPart.php";
?>

<!-- Start Page Title -->
<div class="page-title-area">
    <div class="container">
        <div class="page-title-content">
            <h2><?php echo FA_LC['address'];?></h2>
            <ul>
                <li><a href="./"><?php echo FA_LC['home_page'];?></a></li>
                <li><?php echo FA_LC['address'];?></li>
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
                    <h2><?php echo FA_LC['address'];?></h2>

                    <form class="login-form" method="post" action="">


                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo FA_LC["country"]; ?>
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <select name="CountryIdKey" class="form-control" required="required">
                                    <?php echo $strCountryIdKey; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo FA_LC["nice_name"]; ?>
                                <span
                                    class="required">*</span>
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input name="NicName" class="date-picker form-control col-md-7 col-xs-12"
                                       required="required" type="text"
                                       value="<?php echo @$objEditView->NicName; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo FA_LC["post_code"]; ?>
                                <span
                                    class="required">*</span>
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input name="PostCode" class="date-picker form-control col-md-7 col-xs-12"
                                       required="required" type="text"
                                       value="<?php echo @$objEditView->PostCode; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo FA_LC["other_tel"]; ?>
                                <span
                                    class="required">*</span>
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input name="OtherTel" class="date-picker form-control col-md-7 col-xs-12"
                                        type="text"
                                       value="<?php echo @$objEditView->OtherTel; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo FA_LC["address"]; ?>
                                <span
                                        class="required">*</span>
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                            <textarea required="required" name="Address" class="form-control" rows="3"
                                                      placeholder="<?php echo FA_LC["address"]; ?>"><?php echo @$objEditView->Address; ?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo FA_LC["description"]; ?>
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                            <textarea name="Description" class="form-control" rows="3"
                                                      placeholder="<?php echo FA_LC["description"]; ?>"><?php echo @$objEditView->Description; ?></textarea>
                            </div>
                        </div>

                        <button  type="submit" name="SubmitL" class="default-btn" value="N"><?php echo FA_LC["submit"]; ?></button>

                    </form>
                </div>
            </div>

            <div class="col-lg-6 col-md-6">
                <div class="new-customer-content">
                    <h2><?php echo FA_LC["addresses"];?></h2>
                    <p><?php echo $strAdresses; ?></p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Login Area -->
<?php
//include "./controller/Adver/Partner.php";
//include "./view/Adver/Testimonials.php";
//include "./view/Adver/Facility.php";
//include "./view/Adver/Instagram.php";
//include "./view/GlobalPage/ModalParts.php";
include "./view/GlobalPage/FooterArea.php";
?>
