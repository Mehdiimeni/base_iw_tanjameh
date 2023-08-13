<?php
///template/look/look.php

$gender = str_ireplace('%20', ' ', $_SESSION['gender']);
$category = str_ireplace('%20', ' ', $_SESSION['category']);
$group = str_ireplace('%20', ' ', $_SESSION['group']);
$page_offcet_nu = 15;

(isset($_GET['page']) and $_GET['page'] > 1) ? $str_limit = ($_GET['page'] - 1) * $page_offcet_nu . '  , ' . $page_offcet_nu : $str_limit = $page_offcet_nu;

$page_condition = "order by id DESC LIMIT " . $str_limit;

if (get_look_info($gender, $category, $group)) {
    ?>
    <div class="container-md pt-5">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb b-animate b-dark">
                <li class="breadcrumb-item"><a
                        href="./?gender=<?php echo get_look_info($gender, $category, $group)->gender_name; ?>"
                        class="text-decoration-none text-dark fw-semibold d-inline-block"><?php echo get_look_info($gender, $category, $group)->gender_local_name; ?></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <?php echo get_look_info($gender, $category, $group)->category_local_name; ?>
                </li>
            </ol>
        </nav>
        <h1 class="fw-semibold mb-5">
            <?php echo get_look_info($gender, $category, $group)->look_local_name; ?>
        </h1>
        <div class="row my-4">
            <div class="col-12 col-lg-3 b-animate b-dark brand-cat lh-lg">
                <ul class="list-unstyled">
                    <li>
                        <span class="text-mediumpurple fw-bold">
                            <?php echo get_look_info($gender, $category, $group)->category_local_name; ?>
                        </span>
                    </li>
                </ul>
                <hr class="d-lg-none">
            </div>
            <div class="col-12 col-lg-9">
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
                        <?php echo get_look_info($gender, $category, $group)->total . " " . _LANG['product']; ?>
                    </h6>
                </div>
                <!-- products -->
                <div class="row row-cols-2 row-cols-sm-3 g-3">

                    <?php if (look_details($gender, $page_condition)) {
                        foreach (look_details($gender, $page_condition) as $product_data) { ?>
                            <div class="col card rounded-0 border-0">
                                <div class="position-relative d-inline-block product">
                                    <div class="position-absolute top-0 z-1 mt-2">
                                        <!-- add class like or dislike -->
                                        <input type="hidden" name="product_id" value="<?php echo $product_data->id; ?>">

                                        <button type="button" value="<?php echo $product_data->id; ?>"
                                            class="btn btn-light rounded-0 btn-heart dislike lh-1 p-2 fs-5"><i
                                                class="fa-regular fa-heart" aria-hidden="true"></i></button>
                                    </div>
                                    <a href="<?php echo $product_data->product_page_url; ?>" class="text-decoration-none">
                                        <div class="card text-dark rounded-0 border-0 bg-transparent">
                                            <div class="position-relative placeholder-glow">
                                                <div class="product-img position-relative pt-144 bg-dark-subtle w-100 placeholder">
                                                    <img class="card-img rounded-0 position-absolute top-0 lazy-image"
                                                        data-src='<?php echo $product_data->image_one_address; ?>'
                                                        onmouseover="this.src='<?php echo $product_data->image_two_address; ?>';"
                                                        onmouseout="this.src='<?php echo $product_data->image_one_address; ?>';"
                                                        alt="">
                                                </div>
                                            </div>
                                            <div class="b-animate b-dark">
                                                <a href="#" class="m-0 text-truncate text-decoration-none text-dark d-block">حنا</a
                                                    href="#">
                                                <h6 class="m-0 text-truncate">10 محصول</h6>
                                            </div>

                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php }
                    } //?>
                </div>

                <!-- pagination -->
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center mt-5">
                        <?php if (look_details($gender, $page_condition)) {
                            echo look_paging($page_offcet_nu, get_look_info($gender, $category, $group)->total_en, $_SESSION['actual_link']);
                        } ?>
                    </ul>
                </nav>


            <?php } ?>
            <!-- end section -->