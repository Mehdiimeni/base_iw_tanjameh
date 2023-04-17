<?php
//WishList.php

include IW_ASSETS_FROM_PANEL . "include/PageUnity.php";
include "./view/GlobalPage/TopPages.php";
include "./controller/GlobalPage/MenuPart.php";
?>
<!-- Start Page Title -->
<div class="page-title-area">
    <div class="container">
        <div class="page-title-content">
            <h2><?php echo FA_LC["your_wishlist"]; ?></h2>
            <ul>
                <li><a href="./"><?php echo FA_LC["home_page"]; ?></a></li>
                <li><?php echo FA_LC["your_wishlist"]; ?></li>
            </ul>
        </div>
    </div>
</div>
<!-- End Page Title -->

<!-- Start Cart Area -->
<section class="cart-area ptb-100">
    <div class="container">
        <form  method="post" action="" enctype="multipart/form-data">
            <div class="cart-table table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col"><?php echo(FA_LC["product"]); ?></th>
                        <th scope="col"><?php echo(FA_LC["name"]); ?></th>
                        <th scope="col"><?php echo (FA_LC["unit_price"]); ?></th>
                    </tr>
                    </thead>

                    <tbody>

                    <?php echo($strProductsShop); ?>


                    </tbody>
                </table>
            </div>

            <div class="cart-buttons">
                <div class="row align-items-center">
                    <div class="col-lg-7 col-sm-7 col-md-7">
                        <a href="./" class="optional-btn"><?php echo(FA_LC["continue_shopping"]); ?></a>
                    </div>


                </div>
            </div>


        </form>
    </div>
</section>
<!-- End Cart Area -->
<?php
include "./controller/Adver/Offer.php";
include "./controller/Adver/Partner.php";
//include "./view/Adver/Testimonials.php";
//include "./view/Adver/Facility.php";
//include "./view/Adver/Instagram.php";
//include "./view/GlobalPage/ModalParts.php";
include "./view/GlobalPage/FooterArea.php";
?>

