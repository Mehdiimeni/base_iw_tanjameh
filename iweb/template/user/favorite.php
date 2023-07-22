<?php
///template/user/favorite.php

$page_offcet_nu = 15;
(isset($_GET['page']) and $_GET['page'] > 1) ? $str_limit = ($_GET['page'] - 1) * $page_offcet_nu . '  , ' . $page_offcet_nu : $str_limit = $page_offcet_nu;

$page_condition = "order by id DESC LIMIT " . $str_limit;
?>
<div class="container-md pt-5">
  <!-- Breadcrumb -->

  <h1 class="fw-semibold mb-5">
    این موارد را پسندیده اید
  </h1>
  <div class="row my-4">
    <div class="col-12 col-lg-3 b-animate b-dark brand-cat lh-lg">
      <hr class="d-lg-none">
    </div>
    <div class="col-12 col-lg-9">

      <!-- products -->
      <div class="row row-cols-2 row-cols-sm-3 g-3">
        <?php if (favorite_product_details($page_condition)) {
          foreach (favorite_product_details($page_condition) as $product_data) { ?>
            <div class="col card rounded-0 border-0">
              <div class="position-relative d-inline-block product">
                <div class="position-absolute top-0 z-1 mt-2">
                  <!-- add class like or dislike -->
                  <button type="button" value="<?php echo $product_data->id; ?>"
                    class="btn btn-light rounded-0 btn-heart dislike lh-1 p-2 fs-5"><i class="fa-regular fa-heart"
                      aria-hidden="true"></i></button>
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

    </div>
  </div>
</div>


<!-- end section -->