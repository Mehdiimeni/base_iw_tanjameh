<?php
//Shop.php
include IW_ASSETS_FROM_PANEL . "include/PageUnity.php";
include "./view/GlobalPage/TopPages.php";
include "./controller/GlobalPage/MenuPart.php";
?>
<!-- Start Page Title -->
<div class="page-title-area">
    <div class="container">
        <div class="page-title-content">
            <h2><?php echo FA_LC["basket"]; ?></h2>
            <ul>
                <li><a href="./"><?php echo FA_LC["home_page"]; ?></a></li>
                <li><?php echo FA_LC["basket"]; ?></li>
            </ul>
        </div>
    </div>
</div>
<!-- End Page Title -->

<!-- Start Cart Area -->
<section class="cart-area ptb-100">
    <div class="container">
        <form method="post" action="" enctype="multipart/form-data">
            <div class="cart-table table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col"><?php echo(FA_LC["product"]); ?></th>
                        <th scope="col"><?php echo(FA_LC["name"]); ?></th>
                        <th scope="col"><?php echo(FA_LC["existence"]); ?></th>
                        <th scope="col"><?php echo(FA_LC["size"]); ?></th>
                        <th scope="col"><?php echo(FA_LC["unit_price"]); ?></th>
                        <th scope="col"><?php echo(FA_LC["weight"]); ?></th>
                        <th scope="col"><?php echo(FA_LC["quantity"]); ?></th>
                        <th scope="col"><?php echo(FA_LC["total_count"]); ?></th>
                    </tr>
                    </thead>

                    <tbody>

                    <?php echo($strProductsShop); ?>


                    </tbody>
                </table>
                <div class="cart-buttons">
                    <div class="row align-items-center">
                        <div class="col-lg-7 col-sm-7 col-md-7">
                            <a href="./" class="optional-btn"><?php echo(FA_LC["continue_shopping"]); ?></a>
                        </div>

                        <div class="col-lg-5 col-sm-5 col-md-5 text-end">
                            <button type="submit" href="#" name="SubmitM" value="A"
                                    class="default-btn"><?php echo(FA_LC["update_cart"]); ?></button>
                        </div>
                    </div>
                </div>
                <div class="cart-totals">
                    <h3><?php echo(FA_LC["cart_totals"]); ?></h3>

                    <ul>
                        <li><?php echo(FA_LC["sub_total"]); ?> : <span><?php echo($intTotalPrice); ?></span></li>
                        <li><?php echo(FA_LC["shipping"]); ?> : <span><?php echo($intTotalShipping); ?></span></li>
                        <li><?php echo(FA_LC["pack_number"]); ?> : <span><?php echo($intPackcount); ?></span></li>
                        <li><?php echo(FA_LC["total_count"]); ?> : <span><?php echo($intTotalPriceShipping); ?></span>
                        </li>
                    </ul>
                    <?php if ($boolAllowCheckout) { ?>
                        <a href="?part=User&page=Checkout"
                           class="default-btn"><?php echo(FA_LC["proceed_to_checkout"]); ?></a>
                    <?php } elseif($boolAllowCheckoutLogin) {?>
                        <a href="?part=User&page=Login"
                           class="default-btn"><?php echo(FA_LC["login"]); ?></a>
                    <?php }else{
                        ?>
                        <a href = "#" ><?php echo(FA_LC["allow_checkout_tip"]); ?></a>
                    <?php
                    } ?>
                </div>
            </div>


        </form>
    </div>
</section>
<!-- End Cart Area -->
<?php
//include "./controller/Adver/Offer.php";
//include "./controller/Adver/Partner.php";
//include "./view/Adver/Testimonials.php";
//include "./view/Adver/Facility.php";
//include "./view/Adver/Instagram.php";
//include "./view/GlobalPage/ModalParts.php";
include "./view/GlobalPage/FooterArea.php";
?>
