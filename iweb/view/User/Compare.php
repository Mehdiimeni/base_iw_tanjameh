<?php
//Compare.php

include IW_ASSETS_FROM_PANEL . "include/PageUnity.php";
include "./view/GlobalPage/TopPages.php";
include "./controller/GlobalPage/MenuPart.php";
?>
    <!-- Start Page Title -->
    <div class="page-title-area">
        <div class="container">
            <div class="page-title-content">
                <h2><?php echo FA_LC["comparison"]; ?></h2>
                <ul>
                    <li><a href="./"><?php echo FA_LC["home_page"]; ?></a></li>
                    <li><?php echo FA_LC["comparison"]; ?></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- End Page Title -->

    <!-- Start Compare Area -->
    <section class="compare-area ptb-100">
        <div class="container">
            <div class="products-compare-table table-responsive">
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <td></td>

                        <td>
                            <a href="#" data-recomparison="<?php echo @$strProductId[1]; ?>" class="remove"><i
                                        class="bx bx-trash"></i></a>

                        </td>

                        <td>
                            <a href="#" data-recomparison="<?php echo @$strProductId[2]; ?>" class="remove"><i
                                        class="bx bx-trash"></i></a>
                        </td>

                        <td>


                            <a href="#" data-recomparison="<?php echo @$strProductId[3]; ?>" class="remove"><i
                                        class="bx bx-trash"></i></a>

                        </td>

                    </tr>
                    <tr>
                        <td><?php echo FA_LC["properties"]; ?></td>

                        <td>
                            <div class="single-products-box">
                                <div class="products-image">
                                    <?php echo(@$strLink[1]); ?>
                                    <?php echo(@$strImageOne[1]); ?>
                                    <?php echo(@$strImageSec[1]); ?>
                                    </a>
                                </div>
                            </div>

                        </td>

                        <td>
                            <div class="single-products-box">
                                <div class="products-image">
                                    <?php echo(@$strLink[2]); ?>
                                    <?php echo(@$strImageOne[2]); ?>
                                    <?php echo(@$strImageSec[2]); ?>
                                    </a>
                                </div>
                            </div>
                        </td>

                        <td>


                            <div class="single-products-box">
                                <div class="products-image">
                                    <?php echo(@$strLink[3]); ?>
                                    <?php echo(@$strImageOne[3]); ?>
                                    <?php echo(@$strImageSec[3]); ?>
                                    </a>
                                </div>
                            </div>
                        </td>

                    </tr>

                    <tr>
                        <td><?php echo FA_LC["name"]; ?></td>
                        <td><?php echo @$strName[1]; ?></td>
                        <td><?php echo @$strName[2]; ?></td>
                        <td><?php echo @$strName[3]; ?></td>
                    </tr>

                    <tr>
                        <td><?php echo FA_LC["price"]; ?></td>
                        <td>
                            <div class="price">
                                <span class="old-price"><?php echo @$strOldPricingPart[1]; ?></span>
                                <span class="new-price"><?php echo @$strPricingPart[1]; ?></span>
                            </div>
                        </td>
                        <td>
                            <div class="price">
                                <span class="old-price"><?php echo @$strOldPricingPart[2]; ?></span>
                                <span class="new-price"><?php echo @$strPricingPart[2]; ?></span>
                            </div>
                        </td>
                        <td>
                            <div class="price">
                                <span class="old-price"><?php echo @$strOldPricingPart[3]; ?></span>
                                <span class="new-price"><?php echo @$strPricingPart[3]; ?></span>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo FA_LC["brand"]; ?></td>
                        <td><?php echo @$strBrand[1]; ?></td>
                        <td><?php echo @$strBrand[2]; ?></td>
                        <td><?php echo @$strBrand[3]; ?></td>
                    </tr>

                    <tr>
                        <td><?php echo FA_LC["color"]; ?></td>
                        <td><?php echo @$arrAllColor[0]; ?></td>
                        <td><?php echo @$arrAllColor[1]; ?></td>
                        <td><?php echo @$arrAllColor[2]; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo FA_LC["type"]; ?></td>
                        <td><?php echo @$strProductType[1]; ?></td>
                        <td><?php echo @$strProductType[2]; ?></td>
                        <td><?php echo @$strProductType[3]; ?></td>
                    </tr>


                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <!-- End Compare Area -->

<?php
include "./controller/Adver/Partner.php";
//include "./view/Adver/Testimonials.php";
//include "./view/Adver/Facility.php";
//include "./view/Adver/Instagram.php";
//include "./view/GlobalPage/ModalParts.php";
include "./view/GlobalPage/FooterArea.php";
?>