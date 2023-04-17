<?php
//ProductDetails.php

include IW_ASSETS_FROM_PANEL . "include/PageUnity.php";
include "./view/GlobalPage/TopPages.php";

include "./controller/GlobalPage/MenuPart.php";


?>

    <!-- Start Page Title -->
    <div class="page-title-area">
        <div class="container">
            <div class="page-title-content">
                <h2><?php echo $objProduct->Name; ?></h2>
                <ul>
                    <li><a href="./"><?php echo FA_LC["home_page"]; ?></a></li>
                    <li><?php echo FA_LC["product_detail"]; ?></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- End Page Title -->

    <!-- Start Product Details Area -->
    <section class="product-details-area pt-100 pb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-12">
                    <div class="products-details-image">
                        <ul class="products-details-image-slides">

                            <?php

                            foreach ($objArrayImage as $image) {

                                echo '<li>' . $objShowFile->ShowImage('', $objShowFile->FileLocation("attachedimage"), $image, $objProduct->Name, 0, '') . '</li>';
                            }

                            ?>

                        </ul>

                        <div class="slick-thumbs">
                            <ul>
                                <?php foreach ($objArrayImage as $image) {
                                    echo '<li>' . $objShowFile->ShowImage('', $objShowFile->FileLocation("attachedimage"), $image, $objProduct->Name, 120, '') . '</li>';
                                }

                                ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7 col-md-12">
                    <div class="products-details-desc">
                        <h3><?php echo $objProduct->Name; ?></h3>

                        <div class="price">
                            <?php echo($strPricingPart); ?>

                        </div>


                        <ul class="products-info">
                            <li><span><?php echo FA_LC["brand"]; ?> : </span> <a
                                        href="#"><?php echo $strOtherData['brand']['name']; ?></a>
                            </li>
                            <li><span><?php echo FA_LC["type"]; ?> :</span> <a
                                        href="#"><?php echo $strOtherData['productType']['name']; ?></a></li>
                        </ul>

                        <div class="products-color-switch">
                            <span><?php echo FA_LC["color"]; ?> :</span>

                            <ul>
                                <!--      <li><a href="#" title="Black" class="color-black"></a></li>
                                      <li><a href="#" title="White" class="color-white"></a></li>
                                      <li class="active"><a href="#" title="Green" class="color-green"></a></li>
                                      <li><a href="#" title="Yellow Green" class="color-yellowgreen"></a></li>
                                      <li><a href="#" title="Teal" class="color-teal"></a></li> -->

                                <?php
                                foreach (@array_unique($arrColor) as $Color) {

                                    echo '<li>' . $Color . '</li>';
                                }
                                ?>
                            </ul>
                        </div>
                        <form method="post" action="" enctype="multipart/form-data">
                            <div class="products-size-wrapper">
                                <span><?php echo FA_LC["size"]; ?> : </span>
                                <div class="col-lg-3 col-xs-12">
                                    <select name="Size" class="form-control">

                                        <?php
                                        foreach (array_unique($arrSize) as $id=>$Size) {
                                            echo '<option  selected value="' . $id . '|' . $Size . '">' . $Size . '</option>';
                                        }

                                        foreach (array_unique($arrSizeDis) as $SizeDis) {
                                            echo '<option   disabled value="' . $SizeDis . '">' . $SizeDis . '</option>';
                                        }
                                        ?>


                                    </select>
                                </div>

                            </div>
                            <!--
                                                    <div class="products-info-btn">
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#sizeGuideModal"><i
                                                                    class='bx bx-crop'></i>
                                                            Size guide</a>
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#productsShippingModal"><i
                                                                    class='bx bxs-truck'></i> Shipping</a>
                                                        <a href="contact.html"><i class='bx bx-envelope'></i> Ask about this products</a>
                                                    </div>
                            -->
                            <div class="products-add-to-cart">

                                <div class="input-counter">
                                    <span class="minus-btn"><i class='bx bx-minus'></i></span>
                                    <input name="Count" type="text" value="1">
                                    <span class="plus-btn"><i class='bx bx-plus'></i></span>
                                </div>
                                <input name="ProductId" type="hidden" value="<?php echo($objProduct->ProductId); ?>">
                                <?php if ($objProductData['isInStock']) { ?>
                                    <button type="submit" href="#" name="SubmitM" value="A"
                                            data-basket="<?php echo $objProduct->ProductId; ?>" class="default-btn"><i
                                                class="fas fa-cart-plus"></i><?php echo FA_LC['add_to_cart']; ?>
                                    </button>
                                <?php } else {
                                    echo FA_LC["unavailable"];
                                } ?>
                            </div>
                        </form>

                        <div class="wishlist-compare-btn">
                            <a href="#" data-wishlist="<?php echo $objProduct->ProductId; ?>" class="optional-btn"><i
                                        class='bx bx-heart'></i> <?php echo FA_LC['list_wishlist']; ?></a>
                            <a href="#" data-comparison="<?php echo $objProduct->ProductId; ?>" class="optional-btn"><i
                                        class='bx bx-refresh'></i> <?php echo FA_LC['comparison']; ?></a>
                        </div>

                        <div class="buy-checkbox-btn">
                            <div class="item">
                                <input class="inp-cbx" id="cbx" type="checkbox" required>
                                <label class="cbx" for="cbx">
                                        <span>
                                            <svg width="12px" height="10px" viewbox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                    <span><?php echo(FA_LC["i_agree_with_the_terms_and_conditions"]); ?></span>
                                </label>
                            </div>


                        </div>

                        <div class="products-details-accordion">
                            <ul class="accordion">
                                <li class="accordion-item">
                                    <a class="accordion-title active" href="javascript:void(0)">
                                        <i class='bx bx-chevron-down'></i>
                                        <?php echo FA_LC['description']; ?>
                                    </a>

                                    <div class="accordion-content show">
                                        <p><?php echo($strOtherData['description']); ?></p>
                                        ID : <?php echo($objProduct->ProductId); ?><br />
                                        Code : <?php echo($objProduct->IdKey); ?><br />


                                    </div>
                                </li>

                                <li class="accordion-item">
                                    <a class="accordion-title" href="javascript:void(0)">
                                        <i class='bx bx-chevron-down'></i>
                                        <?php echo(FA_LC['addtional_info']); ?>

                                    </a>

                                    <div class="accordion-content">
                                        <p><?php echo(trim($strOtherData['info']['aboutMe'])); ?></p>
                                        <p><?php echo(trim($strOtherData['info']['sizeAndFit'])); ?></p>
                                        <p><?php echo(trim($strOtherData['info']['careInfo'])); ?></p>
                                    </div>
                                </li>

                                <li class="accordion-item">
                                    <a class="accordion-title" href="javascript:void(0)">
                                        <i class='bx bx-chevron-down'></i>
                                        <?php echo(FA_LC['post_price']); ?>

                                    </a>

                                    <div class="accordion-content">
                                        <p><?php echo(FA_LC['post_price_note']); ?></p>
                                        <p><?php echo(FA_LC['post_price_unique']); ?> : <?php echo($strShippingPrice); ?></p>
                                        <p><?php echo(FA_LC['weight']); ?> : <?php echo($strShippingWeight); ?></p>
                                    </div>
                                </li>

                                <?php

                                include "./controller/Product/Reviews.php";

                                ?>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php

      //  include "./controller/Product/RelatedProducts.php";

        ?>

    </section>
    <!-- End Product Details Area -->


<?php

include "./controller/Adver/Facility.php";

include "./view/Adver/Instagram.php";

include "./view/GlobalPage/ModalParts.php";

include "./view/GlobalPage/FooterArea.php";

?>