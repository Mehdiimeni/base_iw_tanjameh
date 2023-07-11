<?php
///template/adver/related_adver_3.php
$adver_related = 'price';
if (get_related_adver_data($_SESSION['page_name_system'], $_SESSION['item'], $adver_related)) {
    ?>
    <div class="container-fluid py-5">
        <div class="container-md">
            <h2 class="fw-semibold">
                <?php echo (@get_related_adver_data($_SESSION['page_name_system'], $_SESSION['item'], $adver_related)->title); ?>
            </h2>
            <div class="hstack align-items-center mb-3">
                <h3>
                    <?php echo (@get_related_adver_data($_SESSION['page_name_system'], $_SESSION['item'], $adver_related)->content); ?>
                </h3>
            </div>
        </div>
        <div class="row">
            <div class="col-0 col-md-1"></div>
            <div class="col-12 col-md-11 position-relative overflow-hidden">
                <div class="container position-absolute bottom-50 z-2">
                    <div class="position-relative index-owl-nav"></div>
                </div>
                <div class="owl-center-nonloop owl-carousel">
                    <?php if (get_related_adver_product($_SESSION['page_name_system'], $_SESSION['item'], $adver_related)) {
                        foreach (get_related_adver_product($_SESSION['page_name_system'], $_SESSION['item'], $adver_related) as $Product) { ?>
                            <div class="item position-relative">
                                <div class="position-absolute top-0 z-1 mt-2">
                                    <!-- add class like or dislike -->
                                    
                                    <button type="button" value="<?php echo $Product->id; ?>" class="btn btn-light rounded-0 btn-heart dislike lh-1 p-2 fs-5"><i
                                            class="fa-regular fa-heart" aria-hidden="true"></i></button>
                                </div>
                                <a href="<?php echo $Product->product_page_url; ?>" class="text-decoration-none">
                                    <div class="card text-dark rounded-0 border-0 bg-transparent">
                                        <div class="position-relative">
                                            <?php echo $Product->image; ?>
                                            <?php echo $Product->offer1; ?>
                                        </div>
                                        <div class="card-body p-0 py-2">
                                            <h6 class="m-0 text-truncate">
                                                <?php echo $Product->name; ?>
                                            </h6>
                                            <h6 class="m-0 text-truncate">
                                                <?php if (!in_array($Product->product_type, _PRODUCT)) {
                                                    echo $Product->product_type;
                                                } else {
                                                    echo array_search($Product->product_type, _PRODUCT);
                                                } ?>
                                                -
                                                <?php echo $Product->brand_name; ?>
                                            </h6>
                                        </div>
                                        <section>
                                            <h6>
                                                <?php echo $Product->str_price; ?>
                                            </h6>
                                        </section>
                                    </div>
                                </a>
                            </div>
                        <?php }
                    } // ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>