<?php
//Brands.php

include IW_ASSETS_FROM_PANEL . "include/PageUnity.php";
include "./view/GlobalPage/TopPages.php";
include "./controller/GlobalPage/MenuPart.php";
?>
    <!-- Start Page Title -->
    <div class="page-title-area">
        <div class="container">
            <div class="page-title-content">
                <h2><?php echo FA_LC["brands"]; ?></h2>
                <ul>
                    <li><a href="./"><?php echo FA_LC["home_page"]; ?></a></li>
                    <li><?php echo FA_LC["brands"]; ?></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- End Page Title -->


    <!-- Start Brands Area -->
    <section class="about-area ">
        <div class="container">
            <div class="about-inner-area">
                <div class="row">
                    <?php echo $strAllBrands; ?>

                </div>
            </div>
        </div>
    </section>
    <!-- End Brands Area -->


<?php
include "./controller/Adver/Offer.php";
include "./controller/Adver/Partner.php";
//include "./view/Adver/Testimonials.php";
//include "./view/Adver/Facility.php";
//include "./view/Adver/Instagram.php";
//include "./view/GlobalPage/ModalParts.php";
include "./view/GlobalPage/FooterArea.php";
?>