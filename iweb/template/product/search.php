<?php
///template/product/search.php

$search = $_SESSION['search'];
$page_offcet_nu = 15;
(isset($_GET['page']) and $_GET['page'] > 1) ? $str_limit = ($_GET['page'] - 1) * $page_offcet_nu . '  , ' . $page_offcet_nu : $str_limit = $page_offcet_nu;

$page_condition = "order by id DESC LIMIT " . $str_limit;
?>
<div class="container-md pt-5">
  <!-- Breadcrumb -->

  <h1 class="fw-semibold mb-5">
    <?php echo get_search_info($search)->search_name; ?>
  </h1>
  <div class="row my-4">
    <div class="col-12 col-lg-3 b-animate b-dark brand-cat lh-lg">
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
          <form class="dropdown-menu rounded-0">
            <button type="submit" class="btn btn-outline-light text-dark rounded-0 w-100  py-3"><span
                class="float-start"><?php echo (_LANG['most_popular']); ?></span></button>
            <hr class="ms-3 m-0 border-dark-subtle">
            <button type="submit" class="btn btn-outline-light text-dark rounded-0 w-100 py-3 fw-bold"><span
                class="float-start"><?php echo (_LANG['the_newest']); ?></span><i
                class="fa-solid fa-check float-end"></i></button>
            <hr class="ms-3 m-0 border-dark-subtle">
            <button type="submit" class="btn btn-outline-light text-dark rounded-0 w-100 py-3"><span
                class="float-start"><?php echo (_LANG['the_lowest_price']); ?></span></button>
            <hr class="ms-3 m-0 border-dark-subtle">
            <button type="submit" class="btn btn-outline-light text-dark rounded-0 w-100 py-3"><span
                class="float-start"><?php echo (_LANG['the_highest_price']); ?></span></button>
            <hr class="ms-3 m-0 border-dark-subtle">
            <button type="submit" class="btn btn-outline-light text-dark rounded-0 w-100 py-3"><span
                class="float-start"><?php echo (_LANG['sales']); ?></span></button>
          </form>
        </div>
        <div class="dropdown d-inline-block mt-1">
          <button type="button" class="btn btn-outline-dark border-1 rounded-0 dropdown-toggle lh-lg"
            data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
            <?php echo (_LANG['size']); ?>
          </button>
          <form class="dropdown-menu p-0 rounded-0">
            <div class="content-filter overflow-y-scroll overflow-x-hidden">
              <ul id="ul_search_filter" class="list-unstyled pt-2">
                <li class="border-bottom">
                  <div class="form-check form-check-inline d-flex align-items-center">
                    <label class="form-check-label flex-grow-1 text-start" for="1.5k">1.5k</label>
                    <input class="form-check-input" type="checkbox" id="1.5k">
                  </div>
                </li>

              </ul>
            </div>
            <div class="d-flex overflow-hidden border-top">
              <button type="submit" class="btn btn-secondary p-3 rounded-0 flex-grow-1">
                <?php echo (_LANG['actions']); ?>
              </button>
              <button type="reset" class="btn btn-light p-3 rounded-0 flex-grow-1">
                <?php echo (_LANG['clear']); ?>
              </button>
            </div>
          </form>
        </div>
        <div class="dropdown d-inline-block mt-1">
          <button type="button" class="btn btn-outline-dark border-1 rounded-0 dropdown-toggle lh-lg"
            data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
            <?php echo (_LANG['color']); ?>
          </button>
          <form class="dropdown-menu p-0 rounded-0">
            <div class="content-filter overflow-y-scroll overflow-x-hidden">
              <ul id="ul_search_filter" class="list-unstyled pt-2">
                <li class="border-bottom">
                  <div class="form-check form-check-inline d-flex align-items-center">
                    <span class="badge bg-dark-900 p-2 rounded-0"> </span>
                    <label class="form-check-label flex-grow-1 text-start" for="colorID1">مشکی</label>
                    <input class="form-check-input" type="checkbox" id="colorID1">
                  </div>
                </li>

              </ul>
            </div>
            <div class="d-flex overflow-hidden border-top">
              <button type="submit" class="btn btn-secondary p-3 rounded-0 flex-grow-1">
                <?php echo (_LANG['actions']); ?>
              </button>
              <button type="reset" class="btn btn-light p-3 rounded-0 flex-grow-1">
                <?php echo (_LANG['clear']); ?>
              </button>
            </div>
          </form>
        </div>
        <div class="dropdown d-inline-block mt-1">
          <button type="button" class="btn btn-outline-dark border-1 rounded-0 dropdown-toggle lh-lg"
            data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
            <?php echo (_LANG['price']); ?>
          </button>
          <form class="dropdown-menu p-0 rounded-0">
            <div class="content-filter overflow-y-scroll overflow-x-hidden">
              <div class="range-slider m-3">
                <span class="rangeValues"></span>
                <input value="50000" min="1000" max="50000" step="500" type="range">
                <input value="1000" min="1000" max="50000" step="500" type="range">
              </div>
            </div>
            <div class="d-flex overflow-hidden border-top">
              <button type="submit" class="btn btn-secondary p-3 rounded-0 flex-grow-1">
                <?php echo (_LANG['actions']); ?>
              </button>
              <button type="reset" class="btn btn-light p-3 rounded-0 flex-grow-1">
                <?php echo (_LANG['clear']); ?>
              </button>
            </div>
          </form>
        </div>
      </div>
      <div class="hstack gap-2 text-muted my-3">
        <h6>
          <?php echo get_search_info($search)->total . " " . _LANG['product']; ?>
        </h6>
      </div>
      <!-- products -->
      <div class="row row-cols-2 row-cols-sm-3 g-3">

        <?php if (search_product_details($search, $page_condition)) {
          foreach (search_product_details($search, $page_condition) as $product_data) { ?>
            <div class="col card rounded-0 border-0">
              <div class="position-relative d-inline-block product">
                <div class="position-absolute top-0 z-1 mt-2">
                  <!-- add class like or dislike -->
                  <button type="button" value="<?php echo $product_data->id; ?>" class="btn btn-light rounded-0 btn-heart dislike lh-1 p-2 fs-5"><i
                      class="fa-regular fa-heart" aria-hidden="true"></i></button>
                </div>
                <a href="<?php echo $product_data->product_page_url; ?>" class="text-decoration-none">
                  <div class="card text-dark rounded-0 border-0 bg-transparent">
                    <div class="position-relative placeholder-glow">
                      <div class="product-img position-relative pt-144 bg-dark-subtle w-100 placeholder">
                        <img class="card-img rounded-0 position-absolute top-0 lazy-image"
                          data-src='<?php echo $product_data->image_one_address; ?>'
                          onmouseover="this.src='<?php echo $product_data->image_two_address; ?>';"
                          onmouseout="this.src='<?php echo $product_data->image_one_address; ?>';" alt="">
                      </div>
                      <div class="position-absolute bottom-0 end-0 hstack gap-1">
                        <?php echo $product_data->offer1; ?>
                      </div>
                      <div class="wrapper position-absolute bottom-0 w-100 bg-body">
                        <ul class="product-size d-flex scroll-y-nowrap list-unstyled gap-3 text-body mb-0 pt-1">
                          <?php $arr_size = explode(",", $product_data->size);
                          foreach ($arr_size as $size) { ?>
                            <li>
                              <?php echo $size; ?>
                            </li>
                          <?php } ?>
                        </ul>
                      </div>
                    </div>
                    <div class="card-body p-0 py-2">
                      <h6 class="m-0 text-truncate">
                        <?php echo ($product_data->name); ?>
                      </h6>
                      <h6 class="m-0 text-truncate product-detail">
                        <?php if (!in_array($product_data->product_type, _PRODUCT)) {
                          echo $product_data->product_type;
                        } else {
                          echo array_search($product_data->product_type, _PRODUCT);
                        } ?>
                        -
                        <?php echo $product_data->brand_name; ?>
                      </h6>
                    </div>
                    <section>
                      <h6 class="fw-semibold text-danger"><span class="product-price">
                          <?php echo ($product_data->str_price); ?>
                        </span></h6>
                      <?php if ($product_data->str_old_price != 0 and $product_data->str_old_price != $product_data->str_price) { ?>
                        <?php echo ($product_data->str_old_price); ?>
                      <?php } ?>
                    </section>
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
          <?php if (search_product_details($search, $page_condition)) {
            echo search_product_paging($page_offcet_nu, get_search_info($search)->total_en,$_SESSION['actual_link']);
          } ?>
        </ul>
      </nav>



      <!-- end section -->