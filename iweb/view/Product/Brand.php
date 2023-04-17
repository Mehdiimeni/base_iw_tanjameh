<?php
//Brand.php

include IW_ASSETS_FROM_PANEL . "include/PageUnity.php";
include "./view/GlobalPage/TopPages.php";
include "./controller/GlobalPage/MenuPart.php";


?>

<!-- Start Page Title -->
<div class="page-title-area">
    <div class="container">
        <div class="page-title-content">
            <h2><?php echo @$objGlobalVar->getUrlEncode($_GET['BrandName']); ?></h2>
            <ul>
                <li><a href="./"><?php echo FA_LC["home_page"]; ?></a></li>

            </ul>
        </div>
    </div>
</div>
<!-- End Page Title -->

<!-- Start Products Area -->
<section class="products-area pt-100 pb-70">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-12">
                <div class="woocommerce-widget-area">
                    <div class="woocommerce-widget filter-list-widget">
                        <h3 class="woocommerce-widget-title"><?php echo FA_LC['current_selection']; ?></h3>

                        <div class="selected-filters-wrap-list">

                            <a href="<?php echo $strClear; ?>" class="delete-selected-filters"><i class='bx bx-trash'></i>
                                <span><?php echo FA_LC['clear_all']; ?></span></a>
                        </div>
                    </div>

                    <div class="woocommerce-widget size-list-widget">
                        <h3 class="woocommerce-widget-title"><?php echo FA_LC['size']; ?></h3>

                        <ul class="size-list-row">
                            <?php echo $strFilterSize; ?>
                        </ul>
                    </div>

                    <div class="woocommerce-widget color-list-widget">
                        <h3 class="woocommerce-widget-title"><?php echo FA_LC['color']; ?></h3>

                        <ul class="color-list-row">
                            <?php echo $strFilterColors; ?>
                        </ul>
                    </div>

                    <div class="woocommerce-widget brands-list-widget">
                        <h3 class="woocommerce-widget-title"><?php echo FA_LC['type']; ?></h3>

                        <ul class="brands-list-row">

                            <?php echo $strFilterType; ?>

                        </ul>
                    </div>


                </div>
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="products-filter-options">
                    <div class="row align-items-center">
                        <div class="col-lg-4 col-md-4">
                            <div class="d-lg-flex d-md-flex align-items-center">
                                    <span class="sub-title d-lg-none"><a href="#" data-bs-toggle="modal"
                                                                         data-bs-target="#productsFilterModal"><i
                                                    class='bx bx-filter-alt'></i> <?php echo FA_LC['filter']; ?></a></span>


                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4">
                            <p><?php echo FA_LC['total_count']; ?><?php echo $intCountAllProducts; ?> </p>
                        </div>

                        <div class="col-lg-4 col-md-4">
                            <div class="products-ordering-list">
                                <select id="normalsort">
                                    <option value="<?php echo $ActualPageLink . "&filter=lowprice"; ?>"><?php echo FA_LC["product_low_to_high"]; ?></option>
                                    <option value="<?php echo $ActualPageLink . "&filter=popular"; ?>"><?php echo FA_LC["product_sort_by_popularity"]; ?></option>
                                    <option value="<?php echo $ActualPageLink . "&filter=latest"; ?>"><?php echo FA_LC["product_sort_by_latest"]; ?></option>
                                    <option value="<?php echo $ActualPageLink . "&filter=highprice"; ?>"><?php echo FA_LC["product_high_to_low"]; ?></option>
                                    <option value="<?php echo $ActualPageLink . "&filter=sale"; ?>"><?php echo FA_LC["product_sort_by_sale"]; ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="products-collections-filter" class="row">


                    <?php echo($MainCategorySelected); ?>


                </div>

                <div class="pagination-area text-center">
                    <?php echo $strPaging; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Products Area -->


<?php


include "./controller/Adver/Facility.php";
include "./view/Adver/Instagram.php";
include "./view/GlobalPage/ModalParts.php";
include "./view/GlobalPage/FooterArea.php";
?>
<!-- scripts part -->
<script>
    $('#normalsort').change(function () {
        window.location = $(this).val();
    });
</script>


