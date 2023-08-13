<?php
///template/look/look.php

$gender = str_ireplace('%20', ' ', $_SESSION['gender']);
$category = str_ireplace('%20', ' ', $_SESSION['category']);
$group = str_ireplace('%20', ' ', $_SESSION['group']);
$page_offcet_nu = 30;

(isset($_GET['page']) and $_GET['page'] > 1) ? $str_limit = ($_GET['page'] - 1) * $page_offcet_nu . '  , ' . $page_offcet_nu : $str_limit = $page_offcet_nu;

$page_condition = "order by id DESC LIMIT " . $str_limit;

if (get_look_info($gender, $category, $group)) {
    ?>
    <div class="container-md pt-5">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">

        </nav>
        <h1 class="fw-semibold mb-5">
            <?php echo get_look_info($gender, $category, $group)[0]->group_name; ?>
        </h1>
        <div class="row my-4">

            <div class="col-12 col-lg-12">
                <!-- filter box -->
                <div class="div-filter">
                    <div class="dropdown d-inline-block mt-1">
                        <button type="button" class="btn btn-outline-dark border-2 rounded-0 dropdown-toggle fw-bold lh-lg"
                            data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                            <?php echo (_LANG['ordering']); ?>
                        </button>
                        <form class="dropdown-menu rounded-0" action="">
                            <button name="order" value="most_popular" type="submit"
                                class="btn btn-outline-light text-dark rounded-0 w-100  py-3"><span
                                    class="float-start"><?php echo (_LANG['most_popular']); ?></span></button>
                            <hr class="ms-3 m-0 border-dark-subtle">
                            <button name="order" value="the_newest" type="submit"
                                class="btn btn-outline-light text-dark rounded-0 w-100 py-3 fw-bold"><span
                                    class="float-start"><?php echo (_LANG['the_newest']); ?></span><i
                                    class="fa-solid fa-check float-end"></i></button>
                        </form>
                    </div>

                </div>
                <div class="hstack gap-2 text-muted my-3">
                    <h6>
                        <?php echo get_look_info($gender, $category, $group)[0]->total ?>
                    </h6>
                </div>
                <!-- products -->
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 gx-3 gy-4">

                    <?php
                    foreach (get_look_info($gender, $category, $group) as $look_data) { ?>
                        <div class="col">
                            <div class="position-relative">
                                <div class="position-absolute top-0 z-1 mt-2">
                                    <!-- add class like or dislike -->
                                    <button type="button" class="btn btn-light rounded-0 btn-heart dislike lh-1 p-2 fs-5"><i
                                            class="fa-regular fa-heart" aria-hidden="true"></i></button>
                                </div>
                                <a href="?look=<?php echo($look_data->look_page_id); ?>&name=<?php echo($look_data->look_page_name); ?>&post=<?php echo($look_data->post_id); ?>" class="text-decoration-none">
                                    <div class="card text-dark rounded-0 border-0 bg-transparent placeholder-glow">
                                        <div class="position-relative pt-144 bg-dark-subtle w-100 placeholder">
                                            <img class="card-img rounded-0 position-absolute top-0 lazy-image"
                                            data-src='<?php echo($look_data->images_address); ?>' alt="<?php echo($look_data->look_page_name); ?>">
                                        </div>
                                        <div class="card-body hstack gap-2 p-0 py-2 placeholder-glow">
                                            <div class="width-42 bg-dark-subtle placeholder">
                                                <img class="rounded-0 w-100 lazy-image"
                                                    data-src='<?php echo($look_data->look_page_profile); ?>' alt="<?php echo($look_data->look_page_name); ?>">
                                            </div>
                                            <div class="b-animate b-dark">
                                                <a href="?look=<?php echo($look_data->look_page_id); ?>&name=<?php echo($look_data->look_page_name); ?>"
                                                    class="m-0 text-truncate text-decoration-none text-dark d-block"><?php echo($look_data->look_page_name); ?></a
                                                   >
                                              <!--  <h6 class="m-0 text-truncate">10 محصول</h6> -->
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php }
                    //?>
                </div>

                <!-- pagination -->
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center mt-5">
                        <?php
                        echo look_paging($page_offcet_nu, get_look_info($gender, $category, $group)[0]->total, $_SESSION['actual_link']);
                        ?>
                    </ul>
                </nav>


            <?php } ?>
            <!-- end section -->