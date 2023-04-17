<?php
//About.php
include IW_ASSETS_FROM_PANEL . "include/PageUnity.php";
include "./view/GlobalPage/TopPages.php";
include "./controller/GlobalPage/MenuPart.php";
?>
    <!-- Start Page Title -->
    <div class="page-title-area">
        <div class="container">
            <div class="page-title-content">
                <h2><?php echo FA_LC["about_us"];?></h2>
                <ul>
                    <li><a href="./"><?php echo FA_LC["home_page"];?></a></li>
                    <li><?php echo FA_LC["about_us"];?></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- End Page Title -->

    <!-- Start About Area -->
    <section class="about-area ptb-100">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-12">
                    <div class="about-image">
                        <img src="../iwtheme/assets/img/tanjameh.png" class="shadow" alt="tanjameh.com" title="با تن جامه همیشه با مد جدید همراه باشید و از خرید خود لذت ببرید.">
                    </div>
                </div>

                <div class="col-lg-6 col-md-12">
                    <div class="about-content">
                        <span class="sub-title"><?php echo FA_LC["about_us"];?></span>
                        <h2>با تن جامه همیشه با مد جدید همراه باشید و از خرید خود لذت ببرید.</h2>
                        <h6>به سایت تن جامه خوش آمدید. خدماتی که دروب سایت tanjameh.com در دسترس شما عزیزان می¬باشد توسط گروه تجاری لاگزس انگلستان  و به نمایندگی از تن جامه ارائه می¬گردد. </h6>
                        <p>در حال حاضر یکی از بهترین و آسانترین روش¬های خرید، خرید اینترنتی می¬باشد که در کشور ما ایران نیز بسیار رواج دارد. با توجه به محدودیت¬های زیاد برای خرید از سایت¬های خارجی، بر آن شدیم که با تشکیل گروه تن جامه بخشی از این محدودیت را کاسته و راهی آسان و ایمن را برای خرید مشتریان عزیز به وجود آوریم.
                            در سایت تن جامه محصولات 1.900 برند مختلف و معتبر جهانی اعم از پوشاک ، کیف و کفش ، زیورآلات و ... برای بانوان، آقایان و کودکان قابل مشاهده و سفارش است.
                            با استفاده از وب سایت تن جامه، کاربران می¬توانند محصولات مورد نظر خود را از میان 1.900 برند که یا در ایران نیست و یا به سختی پیدا می شوند انتخاب نموده و به صورت مستقیم سفارش دهند.  سفارشات پس از طی زمان مشخص در کشور انگلستان توسط نمایندگان تن جامه دریافت و برای کاربران ارسال می¬گردد.
                            از مهمترین مزایای خرید از تن جامه می¬توان به پرداخت ریالی مبلغ از کلیه بانک های ایرانی اشاره کرد و به این ترتیب دیگر نیازی به کارت¬های اعتباری بین المللی نیست.
                            .</p>

                        <div class="features-text">
                            <h5><i class='bx bx-planet'></i>در سایت تن جامه محصولات 1.900 برند مختلف و معتبر جهانی اعم از پوشاک ، کیف و کفش ، زیورآلات و ... برای بانوان، آقایان و کودکان قابل مشاهده و سفارش است.</h5>
                            <p>این شرکت در سال89  در کشور انگلستان کار خود را با هدف ارائه بهترین روش خرید کالا از معتبرترین برندهای دنیا شروع نموده است.</p>
                        </div>
                    </div>
                </div>
            </div>
<!--
            <div class="about-inner-area">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="about-text">
                            <h3>Our Story</h3>
                            <p>One of the most popular on the web is shopping.</p>

                            <ul class="features-list">
                                <li><i class='bx bx-check'></i> People like Xton</li>
                                <li><i class='bx bx-check'></i> World's finest Xton</li>
                                <li><i class='bx bx-check'></i> The original Xton</li>
                                <li><i class='bx bx-check'></i> We trust Xton</li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="about-text">
                            <h3>Our Values</h3>
                            <p>The best of both worlds. Store and web.</p>

                            <ul class="features-list">
                                <li><i class='bx bx-check'></i> Always in style!</li>
                                <li><i class='bx bx-check'></i> Discover your favorite shopping</li>
                                <li><i class='bx bx-check'></i> Find yourself</li>
                                <li><i class='bx bx-check'></i> Feel-good shopping</li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6 offset-lg-0 offset-md-3 offset-sm-3">
                        <div class="about-text">
                            <h3>Our Promise</h3>
                            <p>Rediscover a great shopping tradition</p>

                            <ul class="features-list">
                                <li><i class='bx bx-check'></i> Get better shopping</li>
                                <li><i class='bx bx-check'></i> Love shopping again</li>
                                <li><i class='bx bx-check'></i> Online shopping.</li>
                                <li><i class='bx bx-check'></i> Shopping for all seasons</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </section>
    <!-- End About Area -->


<?php
include "./controller/Adver/Offer.php";
include "./controller/Adver/Partner.php";
//include "./view/Adver/Testimonials.php";
//include "./view/Adver/Facility.php";
//include "./view/Adver/Instagram.php";
//include "./view/GlobalPage/ModalParts.php";
include "./view/GlobalPage/FooterArea.php";
?>