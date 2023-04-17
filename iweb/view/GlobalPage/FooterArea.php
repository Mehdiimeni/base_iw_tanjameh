<?php
//FooterArea.php

$strExpireDate = date("W m-Y");
$UCondition = "  ExpireDate = '$strExpireDate' and Page = 'MainPage' ";
if (!$objORM->DataExist($UCondition, TableIWStatusView)) {

    $InSet = "";
    $InSet .= " Count = 0 ,";
    $InSet .= " Page = 'MainPage' ,";
    $InSet .= " ExpireDate = '$strExpireDate' ";
    $objORM->DataAdd($InSet, TableIWStatusView);
} else {
    $USet = " Count = Count + 1 ";
    $objORM->DataUpdate($UCondition, $USet, TableIWStatusView);
}

?>

    <!-- Start Footer Area -->
    <footer class="footer-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="single-footer-widget">
                        <h3>تن جامه</h3>

                        <div class="about-the-store">
                            <p>با تن جامه همیشه با مد جدید همراه باشید و از خرید خود لذت ببرید.</p>
                            <ul class="footer-contact-info">
                                <li><i class='bx bx-map'></i> <a href="?part=Contact&page=Contact"
                                                                 target="_blank">تهران</a>
                                </li>
                                <li><i class='bx bx-phone-call'></i> <a href="tel:02122206812">02122206812</a></li>
                                <li><i class='bx bx-envelope'></i> <a href="info@tanjameh.com">info@tanjameh.com</a>
                                </li>
                            </ul>
                        </div>
                        <!--
                                            <ul class="social-link">
                                                <li><a href="#" class="d-block" target="_blank"><i class='bx bxl-facebook'></i></a></li>
                                                <li><a href="#" class="d-block" target="_blank"><i class='bx bxl-twitter'></i></a></li>
                                                <li><a href="#" class="d-block" target="_blank"><i class='bx bxl-instagram'></i></a></li>
                                                <li><a href="#" class="d-block" target="_blank"><i class='bx bxl-linkedin'></i></a></li>
                                                <li><a href="#" class="d-block" target="_blank"><i class='bx bxl-pinterest-alt'></i></a></li>
                                            </ul>
                                            -->
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="single-footer-widget pl-4">
                        <h3><?php echo FA_LC["quick_view"]; ?></h3>

                        <ul class="quick-links">
                            <li><a href="?part=Contact&page=About"><?php echo FA_LC["about_us"]; ?></a></li>
                            <li><a href="?part=Contact&page=Faqs"><?php echo FA_LC["faqs"]; ?></a></li>
                            <li><a href="?part=Contact&page=Contact"><?php echo FA_LC["contact"]; ?></a></li>
                            <!--  <li><a href="?part=Contact&page=CustomerService">Customer Services</a></li> -->
                            <li><a href="?part=Product&page=SizingGuide"><?php echo FA_LC["sizing_guide"]; ?></a></li>
                            <li><a href="?part=Contact&page=Complaints"><?php echo FA_LC["complaints"]; ?></a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="single-footer-widget">
                        <h3><?php echo(FA_LC["customer_part"]); ?></h3>

                        <ul class="customer-support">
                            <li><a href="?part=User&page=Login"><?php echo(FA_LC["my_account"]); ?></a></li>
                            <li><a href="?part=User&page=Checkout"><?php echo(FA_LC["checkout"]); ?></a></li>
                            <li><a href="?part=User&page=Shop"><?php echo(FA_LC["basket"]); ?></a></li>
                            <li><a href="?part=User&page=TrackOrder"><?php echo(FA_LC["track_order"]); ?></a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="single-footer-widget">
                        <h3><?php echo(FA_LC["newsletter"]); ?></h3>

                        <div class="footer-newsletter-box">
                            <p><?php echo(FA_LC["email_newsletter_subject"]); ?></p>

                            <form class="newsletter-form" data-bs-toggle="validator">
                                <label><?php echo(FA_LC["email"]); ?>:</label>
                                <input type="email" class="input-newsletter"
                                       placeholder="<?php echo(FA_LC["email"]); ?>" name="EMAIL"
                                       required autocomplete="off">
                                <button type="submit"><?php echo(FA_LC["register"]); ?></button>
                                <div id="validator-newsletter" class="form-result"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-bottom-area">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6">
                        <p>Copyright <i class='bx bx-copyright'></i>2022 <a href="#" target="_blank">Tanjameh</a>
                            Designed By <a
                                    href="https://Tanjameh.com/" target="_blank">IWA</a> | All rights reserved.
                        </p>
                    </div>

                    <div class="col-lg-6 col-md-6">

                        <ul class="payment-types">
                            <li>

                                <a referrerpolicy="origin" target="_blank"
                                   href="https://trustseal.enamad.ir/?id=299914&amp;Code=4u3Lpn1DjNMlwbzktHtk"><img
                                            referrerpolicy="origin"
                                            src="https://Trustseal.eNamad.ir/logo.aspx?id=299914&amp;Code=4u3Lpn1DjNMlwbzktHtk"
                                            alt="" style="cursor:pointer" id="4u3Lpn1DjNMlwbzktHtk"></a>

                            </li>
                            <!-- <li><a href="#" target="_blank"><img
                                        src="<?php echo(IW_WEB_THEME_FROM_PANEL); ?>assets/img/payment/mastercard.png"
                                        alt="image"></a>
                        </li>
                        <li><a href="#" target="_blank"><img
                                        src="<?php echo(IW_WEB_THEME_FROM_PANEL); ?>assets/img/payment/mastercard2.png"
                                        alt="image"></a>
                        </li>
                        <li><a href="#" target="_blank"><img
                                        src="<?php echo(IW_WEB_THEME_FROM_PANEL); ?>assets/img/payment/visa2.png"
                                        alt="image"></a></li>
                        <li><a href="#" target="_blank"><img
                                        src="<?php echo(IW_WEB_THEME_FROM_PANEL); ?>assets/img/payment/expresscard.png"
                                        alt="image"></a>
                        </li> -->
                        </ul>

                    </div>
                </div>
            </div>
        </div>

        <div class="lines">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </div>
    </footer>
    <!-- End Footer Area -->

    <div class="go-top"><i class='bx bx-up-arrow-alt'></i></div>

    <!-- Links of JS files -->
    <script src="<?php echo(IW_WEB_THEME_FROM_PANEL); ?>assets/js/jquery.min.js"></script>
    <script src="<?php echo(IW_WEB_THEME_FROM_PANEL); ?>assets/js/popper.min.js"></script>
    <script src="<?php echo(IW_WEB_THEME_FROM_PANEL); ?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo(IW_WEB_THEME_FROM_PANEL); ?>assets/js/owl.carousel.min.js"></script>
    <script src="<?php echo(IW_WEB_THEME_FROM_PANEL); ?>assets/js/magnific-popup.min.js"></script>
    <script src="<?php echo(IW_WEB_THEME_FROM_PANEL); ?>assets/js/parallax.min.js"></script>
    <script src="<?php echo(IW_WEB_THEME_FROM_PANEL); ?>assets/js/rangeSlider.min.js"></script>
    <script src="<?php echo(IW_WEB_THEME_FROM_PANEL); ?>assets/js/nice-select.min.js"></script>
    <script src="<?php echo(IW_WEB_THEME_FROM_PANEL); ?>assets/js/meanmenu.min.js"></script>
    <script src="<?php echo(IW_WEB_THEME_FROM_PANEL); ?>assets/js/isotope.pkgd.min.js"></script>
    <script src="<?php echo(IW_WEB_THEME_FROM_PANEL); ?>assets/js/slick.min.js"></script>
    <script src="<?php echo(IW_WEB_THEME_FROM_PANEL); ?>assets/js/sticky-sidebar.min.js"></script>
    <script src="<?php echo(IW_WEB_THEME_FROM_PANEL); ?>assets/js/wow.min.js"></script>
    <script src="<?php echo(IW_WEB_THEME_FROM_PANEL); ?>assets/js/form-validator.min.js"></script>
    <script src="<?php echo(IW_WEB_THEME_FROM_PANEL); ?>assets/js/contact-form-script.js"></script>
    <script src="<?php echo(IW_WEB_THEME_FROM_PANEL); ?>assets/js/ajaxchimp.min.js"></script>
    <script src="<?php echo(IW_WEB_THEME_FROM_PANEL); ?>assets/js/main.js"></script>
    <script src="<?php echo(IW_PANEL_JSON_FROM_PANEL); ?>OnClickAdd.js"></script>
    <script src="<?php echo(IW_PANEL_JSON_FROM_PANEL); ?>jquery-ui.js"></script>


    <script>
        $('#SelectAddress').change(function () {
            window.location = "?part=User&page=Checkout&AddId=" + $(this).val();
        });
    </script>

    <script src="../iwtheme2/vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js"></script>
    <script src="../iwtheme2/vendor/nouislider/dist/nouislider.min.js"></script>
    <!-- Main theme script-->
    <script src="../iwtheme2/js/theme.min.js"></script>


    </body>
    </html>
<?php
include "./controller/GlobalPage/DataLoader.php";
?>