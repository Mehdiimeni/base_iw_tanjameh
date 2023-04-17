<?php
//Contact.php
include IW_ASSETS_FROM_PANEL . "include/PageUnity.php";
include "./view/GlobalPage/TopPages.php";
include "./controller/GlobalPage/MenuPart.php";
?>
<!-- Start Page Title -->
<div class="page-title-area">
    <div class="container">
        <div class="page-title-content">
            <h2><?php echo FA_LC["contact"];?></h2>
            <ul>
                <li><a href="./"><?php echo FA_LC["home_page"];?></a></li>
                <li><?php echo FA_LC["contact"];?></li>
            </ul>
        </div>
    </div>
</div>
<!-- End Page Title -->

<!-- Start Contact Area -->
<section class="contact-area ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-md-12">
                <div class="contact-info">
                    <h3><?php echo FA_LC["contact"];?></h3>
                    <p>در صورت داشتن هرگونه سوال می توانید مطالب قوانین را مطالعه کنید <a href="?part=Contact&page=Faqs"><?php echo FA_LC["faqs"];?></a>با تن جامه همیشه با مد جدید همراه باشید و از خرید خود لذت ببرید.</p>

                    <ul class="contact-list">
                        <li><i class='bx bx-map'></i><a href="#">ایران - تهران - خیابان اندرزگو - خیابان سلیمی - ساختمان شماره 2 واحد 126</a></li>
                        <li><i class='bx bx-phone-call'></i> تلفن : <a href="tel:+02122206812">021-22206812</a></li>
                        <li><i class='bx bx-envelope'></i> پست  الکترونیک : <a href="mailto:info@tanjameh.com">info@tanjameh.com</a></li>
                    </ul>

                    <h3>ساعات پشتیبانی</h3>
                    <ul class="opening-hours">
                        <li><span>شنبه:</span> 8AM - 6PM</li>
                        <li><span>یکشنبه:</span> 8AM - 6PM</li>
                        <li><span>دوشنبه:</span> 8AM - 6PM</li>
                        <li><span>سه شنبه :</span> 8AM - 6PM</li>
                        <li><span>چهارشنبه :</span> 8AM - 6PM</li>
                        <li><span>پنج شنبه :</span> 8AM - 1PM</li>
                        <li><span>جمعه:</span> بسته</li>
                    </ul>

                 <!--   <h3>Follow Us:</h3>
                    <ul class="social">
                        <li><a href="#" target="_blank"><i class='bx bxl-facebook'></i></a></li>
                        <li><a href="#" target="_blank"><i class='bx bxl-twitter'></i></a></li>
                        <li><a href="#" target="_blank"><i class='bx bxl-instagram'></i></a></li>
                        <li><a href="#" target="_blank"><i class='bx bxl-linkedin'></i></a></li>
                        <li><a href="#" target="_blank"><i class='bx bxl-skype'></i></a></li>
                        <li><a href="#" target="_blank"><i class='bx bxl-pinterest-alt'></i></a></li>
                        <li><a href="#" target="_blank"><i class='bx bxl-youtube'></i></a></li>
                    </ul>
                    -->
                </div>
            </div>

            <div class="col-lg-7 col-md-12">
                <div class="contact-form">
                    <h3>برای ما پیام بگذارید</h3>
                    <p>شما در هر زمان و مکان می توانید ما را از نظرات و پیشنهادات همچنین سوالات و انتقادات خود آگاه سازید</p>

                    <form id="contactForm" name="contact" action="mailto:info@example.com" method="post" enctype="text/plain">
                        <div class="row">
                            <div class="col-lg-12 col-md-6">
                                <div class="form-group">
                                    <label>نام و نام خانوادگی <span>*</span></label>
                                    <input type="text" name="name" id="name" class="form-control" required data-error="لطفا نام و نام خانوادگی خود را وارد نمایید" placeholder="نام و نام خانوادگی">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-6">
                                <div class="form-group">
                                    <label>پست الکترونیکی <span>*</span></label>
                                    <input type="email" name="email" id="email" class="form-control" required data-error="لطفا پست الکترونیکی خود را وارد نمایید" placeholder="پست الکترونیکی">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <label>شماره تماس <span>*</span></label>
                                    <input type="text" name="phone_number" id="phone_number" class="form-control" required data-error="لطفا شماره تماس خود را وارد نمایید" placeholder="شماره تماس">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <label>پیام شما <span>*</span></label>
                                    <textarea name="message" id="message" cols="30" rows="5" required data-error="لطفا پیام خود را وارد نمایید" class="form-control" placeholder="پیام شما"></textarea>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12">
                                <button type="submit" class="default-btn">ارسال پیام</button>
                                <div id="msgSubmit" class="h3 text-center hidden"></div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Contact Area -->


<?php
include "./controller/Adver/Offer.php";
include "./controller/Adver/Partner.php";
//include "./view/Adver/Testimonials.php";
//include "./view/Adver/Facility.php";
//include "./view/Adver/Instagram.php";
//include "./view/GlobalPage/ModalParts.php";
include "./view/GlobalPage/FooterArea.php";
?>