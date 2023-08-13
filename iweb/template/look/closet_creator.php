<?php
///template/look/closet_creator.php
if (closet_creator_info($_GET['look'])) {
    $look_id = $_GET['look'];

    ?>
    <div class="container-fluid py-5">
        <div class="container-md">
            <div class="hstack align-items-center mb-3">
                <h3 class="fw-semibold">در کمد من چیست؟ </h3>
                <!--<a href="#" class="text-decoration-none text-mediumpurple ms-auto d-flex align-items-center fw-semibold">برو
                تو کمد کامل<i class="fa-solid fa-arrow-left-long ms-2"></i></a>-->
            </div>
            <!-- option menu -->
            <div class="hstack gap-2 scroll-y-nowrap my-4">
                <a href="#" class="btn btn-outline-dark rounded-0 text-decoration-none lh-lg fw-bold box-shadow">همه</a>
                <a href="#" class="btn btn-outline-dark rounded-0 text-decoration-none lh-lg">لباس ها</a>
                <a href="#" class="btn btn-outline-dark rounded-0 text-decoration-none lh-lg">کفش ها</a>
                <a href="#" class="btn btn-outline-dark rounded-0 text-decoration-none lh-lg">لباس زیر</a>
            </div>
        </div>
        <div class="row">
            <div class="col-0 col-md-1"></div>
            <div class="col-12 col-md-11 position-relative overflow-hidden">
                <div class="container position-absolute bottom-50 z-2">
                    <div class="position-relative index-owl-nav"></div>
                </div>
                <div class="owl-center-nonloop owl-carousel">

                    <?php foreach (closet_creator_info($look_id) as $all_closet) { ?>
                        <div class="item position-relative">
                            <div class="position-absolute top-0 z-1 mt-2">
                                <!-- add class like or dislike -->
                                <button type="button" class="btn btn-light rounded-0 btn-heart dislike lh-1 p-2 fs-5"><i
                                        class="fa-regular fa-heart" aria-hidden="true"></i></button>
                            </div>
                            <a href="./?item=<?php echo ($all_closet->product_id); ?>" class="text-decoration-none">
                                <div class="card text-dark rounded-0 border-0 bg-transparent">
                                    <div class="position-relative">
                                        <img data-src="<?php echo ($all_closet->images_address); ?>"
                                            class="card-img rounded-0 owl-lazy" alt="<?php echo ($all_closet->product_name); ?>">
                                        <div class="position-absolute bottom-0 end-0 hstack gap-1">
                                            <div class="text-bg-light p-1 mb-2"><small>
                                                    <?php echo ($all_closet->colour); ?>
                                                </small></div>
                                            <div class="text-bg-danger p-1 mb-2"><small>
                                                    <?php echo ($all_closet->size_text); ?>
                                                </small></div>
                                        </div>
                                    </div>
                                    <div class="card-body p-0 py-2">
                                        <h6 class="m-0 text-truncate">
                                            <?php echo ($all_closet->product_name); ?>
                                        </h6>
                                    </div>
                                </div>
                            </a>
                        </div>

                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>