<?php
//Search.php


include IW_ASSETS_FROM_PANEL . "include/PageUnity.php";
include "./view/GlobalPage/TopPages.php";
include "./controller/GlobalPage/MenuPart.php";


?>

<!-- Start Page Title -->
<div class="page-title-area">
    <div class="container">
        <div class="page-title-content">
            <h2><?php echo $strSearch; ?></h2>
            <ul>

                <li><?php echo FA_LC["search"]; ?></a></li>
                <li><a href="./"><?php echo FA_LC["home_page"]; ?></a></li>

            </ul>
        </div>
    </div>
</div>
<!-- End Page Title -->

<!-- Start Products Area -->
<main class="page-wrapper">

    <!-- used for shop templates with filters on top-->

    <div class="container pb-5 mb-2 mb-md-4">
        <!-- Toolbar-->
        <div class="bg-light shadow-lg rounded-3 p-4 mt-n5 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div class="dropdown me-2"><a class="btn btn-outline-secondary dropdown-toggle" href="#shop-filters"
                                              data-bs-toggle="collapse"><i
                                class="ci-filter me-2"></i><?php echo FA_LC["filter"]; ?></a></div>

            </div>
            <!-- Toolbar with expandable filters-->
            <div class="collapse" id="shop-filters">
                <div class="row pt-4">

                    <div class="col-lg-4 col-sm-12">
                        <!-- Filter by Size-->
                        <div class="card mb-grid-gutter">
                            <div class="card-body px-4">
                                <div class="widget widget-filter">
                                    <h3 class="widget-title"><?php echo FA_LC['type']; ?></h3>
                                    <div class="input-group input-group-sm mb-2">
                                        <input class="widget-filter-search form-control rounded-end pe-5" type="text"
                                               placeholder="<?php echo FA_LC['search']; ?>"><i
                                                class="ci-search position-absolute top-50 end-0 translate-middle-y fs-sm me-3"></i>
                                    </div>
                                    <ul class="widget-list widget-filter-list list-unstyled pt-1"
                                        style="max-height: 11.5rem;" data-simplebar data-simplebar-auto-hide="false">
                                        <?php echo $strFilterType; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-4 col-sm-12">
                        <!-- Filter by Size-->
                        <div class="card mb-grid-gutter">
                            <div class="card-body px-4">
                                <div class="widget widget-filter">
                                    <h3 class="widget-title"><?php echo FA_LC['brand']; ?></h3>
                                    <div class="input-group input-group-sm mb-2">
                                        <input class="widget-filter-search form-control rounded-end pe-5" type="text"
                                               placeholder="<?php echo FA_LC['search']; ?>"><i
                                                class="ci-search position-absolute top-50 end-0 translate-middle-y fs-sm me-3"></i>
                                    </div>
                                    <ul class="widget-list widget-filter-list list-unstyled pt-1"
                                        style="max-height: 11.5rem;" data-simplebar data-simplebar-auto-hide="false">
                                        <?php echo $strFilterBrands; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-4 col-sm-12">
                        <!-- Filter by Size-->
                        <div class="card mb-grid-gutter">
                            <div class="card-body px-4">
                                <div class="widget widget-filter">
                                    <h3 class="widget-title"><?php echo FA_LC['size']; ?></h3>
                                    <div class="input-group input-group-sm mb-2">
                                        <input class="widget-filter-search form-control rounded-end pe-5" type="text"
                                               placeholder="<?php echo FA_LC['search']; ?>"><i
                                                class="ci-search position-absolute top-50 end-0 translate-middle-y fs-sm me-3"></i>
                                    </div>
                                    <ul class="widget-list widget-filter-list list-unstyled pt-1"
                                        style="max-height: 11.5rem;" data-simplebar data-simplebar-auto-hide="false">
                                        <?php echo $strFilterSize; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <!-- Filter by Size-->
                        <div class="card mb-grid-gutter">
                            <div class="card-body px-4">
                                <div class="widget widget-filter">
                                    <h3 class="widget-title"><?php echo FA_LC['sort']; ?></h3>
                                    <div class="input-group input-group-sm mb-2">
                                        <input class="widget-filter-search form-control rounded-end pe-5" type="text"
                                               placeholder="<?php echo FA_LC['search']; ?>"><i
                                                class="ci-search position-absolute top-50 end-0 translate-middle-y fs-sm me-3"></i>
                                    </div>
                                    <ul class="widget-list widget-filter-list list-unstyled pt-1"
                                        style="max-height: 11.5rem;" data-simplebar data-simplebar-auto-hide="false">
                                        <?php echo $strFilterSort; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <!-- Filter by Size-->
                        <div class="card mb-grid-gutter">
                            <div class="card-body px-4">
                                <div class="widget widget-filter">
                                    <h3 class="widget-title"><?php echo FA_LC['color']; ?></h3>
                                    <div class="input-group input-group-sm mb-2">
                                        <input class="widget-filter-search form-control rounded-end pe-5" type="text"
                                               placeholder="<?php echo FA_LC['search']; ?>"><i
                                                class="ci-search position-absolute top-50 end-0 translate-middle-y fs-sm me-3"></i>
                                    </div>
                                    <ul class="widget-list widget-filter-list list-unstyled pt-1"
                                        style="max-height: 11.5rem;" data-simplebar data-simplebar-auto-hide="false">
                                        <?php echo $strFilterColors; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>


        <!-- Products grid-->


        <section class="products-area pt-25 pb-70">
            <div class="container">
                <div class="row">

                    <div class="col-lg-12 col-md-12">

                        <div class="row filter_data">

                            <div id="products-collections-filter" class="row">

                                <?php echo($MainCategorySelected); ?>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Products grid-->

        <hr class="my-3">
        <!-- Pagination-->
        <nav class="d-flex justify-content-between pt-2" aria-label="Page navigation">

            <ul class="pagination">
                <?php echo $strPaging; ?>
            </ul>

        </nav>
    </div>
</main>

<!-- End Products Area -->
<?php
include "./controller/Adver/Facility.php";
include "./view/Adver/Instagram.php";
include "./view/GlobalPage/ModalParts.php";
include "./view/GlobalPage/FooterArea.php";
?>
<script src="<?php echo(IW_PANEL_JSON_FROM_PANEL); ?>jquery-ui.js"></script>


