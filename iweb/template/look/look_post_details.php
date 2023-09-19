<?php
///template/look/look_post_details.php
if (look_post_details($_GET['post'])) {
  $post_id = $_GET['post'];
  ?>
  <div class="container-md">
    <!-- back page -->
    <a href="?look=<?php echo ($_GET['look']); ?>&name=<?php echo ($_GET['name']); ?>"
      class="text-decoration-none text-dark mt-4 d-block">
      <i class="fa-solid fa-chevron-right me-2 fs-6"></i>
      <span class="fw-semibold">بازگشت</span>
    </a>
    <div class="row mt-4 product">
      <!-- zoom product -->
      <div class="col-12 col-md-6">
        <div class="sticky-md-top">
          <ul id="glasscase" class="gc-start">
            <li><img src="<?php echo (look_post_details($post_id)->image_b1_address); ?>"
                alt="<?php echo (look_post_details($post_id)->look_page_name); ?>"></li>
            <li><img src="<?php echo (look_post_details($post_id)->image_b2_address); ?>"
                alt="<?php echo (look_post_details($post_id)->look_page_name); ?>"></li>
            <li><img src="<?php echo (look_post_details($post_id)->image_b3_address); ?>"
                alt="<?php echo (look_post_details($post_id)->look_page_name); ?>"></li>
            <li><img src="<?php echo (look_post_details($post_id)->image_b4_address); ?>"
                alt="<?php echo (look_post_details($post_id)->look_page_name); ?>"></li>

          </ul>
        </div>
      </div>
      <!-- details product -->
      <div class="col-12 col-md-5 offset-md-1 mt-4 mt-md-0 placeholder-glow">
        <div class="hstack gap-2 p-0 py-2">
          <a href="./?look=<?php echo ($_GET['look']); ?>&name=<?php echo ($_GET['name']); ?>" class="width-57 placeholder">
            <img class="lazy-image rounded-0 w-100"
              data-src='<?php echo (look_post_details($post_id)->look_page_profile); ?>'
              alt="<?php echo (look_post_details($post_id)->look_page_name); ?>">
          </a>
          <div class="b-animate b-dark">
            <h4 class="m-0 text-truncate fw-bold">Get the Look</h4>
            <a href="/?look=<?php echo ($_GET['look']); ?>&name=<?php echo ($_GET['name']); ?>"
              class="m-0 text-truncate text-decoration-none text-dark d-block"><?php echo (look_post_details($post_id)->look_page_name); ?></a>
          </div>
        </div>
        <hr class="mb-0 mt-4 border-secondary">
        <article class="border-bottom">
          <div class="row">
            <div class="col-3">
              <a href="./?item=<?php echo (look_post_details($post_id)->product_id1); ?>&luid=<?php echo(look_post_details($post_id)->user_id); ?>">
                <figure class="position-relative m-0 pt-144 bg-dark-subtle w-100 placeholder">
                  <img class="img-look position-absolute top-0 lazy-image"
                    data-src="<?php echo (look_post_details($post_id)->image_product_address1); ?>"
                    alt="<?php echo (look_post_details($post_id)->product_name1); ?>">
                </figure>
              </a>
            </div>
            <div class="col-7 pt-2">
              <a href="./?item=<?php echo (look_post_details($post_id)->product_id1); ?>&luid=<?php echo(look_post_details($post_id)->user_id); ?>"
                class="text-decoration-none text-dark">
                <header>
                  <small>
                    <?php echo (look_post_details($post_id)->brand_name1); ?>
                  </small>
                  <small class="mb-2 d-block text-truncate">
                    <?php echo (look_post_details($post_id)->product_name1); ?>
                    <?php echo (look_post_details($post_id)->product_type_name1); ?> /
                    <?php echo (look_post_details($post_id)->product_color1); ?>
                  </small>
                </header>
                <p class="fw-bold small text-danger m-0">
                  <?php echo (look_post_details($post_id)->price1); ?>
                </p>
                <p class="small mb-1">
                  <?php if (look_post_details($post_id)->discount_persent1 > 0) { ?>
                    <span class="text-danger fw-bold">
                      <?php echo (look_post_details($post_id)->discount_persent1); ?>٪ تخفیف
                    </span>
                  <?php } ?>
                </p>

              </a>
            </div>
            <div class="col-2">
              <!-- add class like or dislike -->
              <button type="button" value="<?php echo (look_post_details($post_id)->product_id1); ?>" class="btn btn-white rounded-0 btn-heart dislike lh-1 p-2 fs-4"><i
                  class="fa-regular fa-heart" aria-hidden="true"></i></button>
            </div>
          </div>
        </article>
        <article class="border-bottom">
          <div class="row">
            <div class="col-3">
              <a href="./?item=<?php echo (look_post_details($post_id)->product_id2); ?>&luid=<?php echo(look_post_details($post_id)->user_id); ?>">
                <figure class="position-relative m-0 pt-144 bg-dark-subtle w-100 placeholder">
                  <img class="img-look position-absolute top-0 lazy-image"
                    data-src="<?php echo (look_post_details($post_id)->image_product_address2); ?>"
                    alt="<?php echo (look_post_details($post_id)->product_name2); ?>">
                </figure>
              </a>
            </div>
            <div class="col-7 pt-2">
              <a href="./?item=<?php echo (look_post_details($post_id)->product_id2); ?>&luid=<?php echo(look_post_details($post_id)->user_id); ?>"
                class="text-decoration-none text-dark">
                <header>
                  <small>
                    <?php echo (look_post_details($post_id)->brand_name2); ?>
                  </small>
                  <small class="mb-2 d-block text-truncate">
                    <?php echo (look_post_details($post_id)->product_name2); ?>
                    <?php echo (look_post_details($post_id)->product_type_name2); ?> /
                    <?php echo (look_post_details($post_id)->product_color2); ?>
                  </small>
                </header>
                <p class="fw-bold small text-danger m-0">
                  <?php echo (look_post_details($post_id)->price2); ?>
                </p>
                <p class="small mb-1">
                  <?php if (look_post_details($post_id)->discount_persent2 > 0) { ?>
                    <span class="text-danger fw-bold">
                      <?php echo (look_post_details($post_id)->discount_persent2); ?>٪ تخفیف
                    </span>
                  <?php } ?>
                </p>

              </a>
            </div>
            <div class="col-2">
              <!-- add class like or dislike -->
              <button type="button" value="<?php echo (look_post_details($post_id)->product_id2); ?>" class="btn btn-white rounded-0 btn-heart dislike lh-1 p-2 fs-4"><i
                  class="fa-regular fa-heart" aria-hidden="true"></i></button>
            </div>
          </div>
        </article>
        <article class="border-bottom">
          <div class="row">
            <div class="col-3">
              <a href="./?item=<?php echo (look_post_details($post_id)->product_id3); ?>&luid=<?php echo(look_post_details($post_id)->user_id); ?>">
                <figure class="position-relative m-0 pt-144 bg-dark-subtle w-100 placeholder">
                  <img class="img-look position-absolute top-0 lazy-image"
                    data-src="<?php echo (look_post_details($post_id)->image_product_address3); ?>"
                    alt="<?php echo (look_post_details($post_id)->product_name3); ?>">
                </figure>
              </a>
            </div>
            <div class="col-7 pt-2">
              <a href="./?item=<?php echo (look_post_details($post_id)->product_id3); ?>&luid=<?php echo(look_post_details($post_id)->user_id); ?>"
                class="text-decoration-none text-dark">
                <header>
                  <small>
                    <?php echo (look_post_details($post_id)->brand_name3); ?>
                  </small>
                  <small class="mb-2 d-block text-truncate">
                    <?php echo (look_post_details($post_id)->product_name3); ?>
                    <?php echo (look_post_details($post_id)->product_type_name3); ?> /
                    <?php echo (look_post_details($post_id)->product_color3); ?>
                  </small>
                </header>
                <p class="fw-bold small text-danger m-0">
                  <?php echo (look_post_details($post_id)->price3); ?>
                </p>
                <p class="small mb-1">
                  <?php if (look_post_details($post_id)->discount_persent3 > 0) { ?>
                    <span class="text-danger fw-bold">
                      <?php echo (look_post_details($post_id)->discount_persent3); ?>٪ تخفیف
                    </span>
                  <?php } ?>
                </p>

              </a>
            </div>
            <div class="col-2">
              <!-- add class like or dislike -->
              <button type="button" value="<?php echo (look_post_details($post_id)->product_id3); ?>" class="btn btn-white rounded-0 btn-heart dislike lh-1 p-2 fs-4"><i
                  class="fa-regular fa-heart" aria-hidden="true"></i></button>
            </div>
          </div>
        </article>
        <article class="border-bottom">
          <div class="row">
            <div class="col-3">
              <a href="./?item=<?php echo (look_post_details($post_id)->product_id4); ?>&luid=<?php echo(look_post_details($post_id)->user_id); ?>">
                <figure class="position-relative m-0 pt-144 bg-dark-subtle w-100 placeholder">
                  <img class="img-look position-absolute top-0 lazy-image"
                    data-src="<?php echo (look_post_details($post_id)->image_product_address4); ?>"
                    alt="<?php echo (look_post_details($post_id)->product_name4); ?>">
                </figure>
              </a>
            </div>
            <div class="col-7 pt-2">
              <a href="./?item=<?php echo (look_post_details($post_id)->product_id4); ?>&luid=<?php echo(look_post_details($post_id)->user_id); ?>"
                class="text-decoration-none text-dark">
                <header>
                  <small>
                    <?php echo (look_post_details($post_id)->brand_name4); ?>
                  </small>
                  <small class="mb-2 d-block text-truncate">
                    <?php echo (look_post_details($post_id)->product_name4); ?>
                    <?php echo (look_post_details($post_id)->product_type_name4); ?> /
                    <?php echo (look_post_details($post_id)->product_color4); ?>
                  </small>
                </header>
                <p class="fw-bold small text-danger m-0">
                  <?php echo (look_post_details($post_id)->price4); ?>
                </p>
                <p class="small mb-1">
                  <?php if (look_post_details($post_id)->discount_persent4 > 0) { ?>
                    <span class="text-danger fw-bold">
                      <?php echo (look_post_details($post_id)->discount_persent4); ?>٪ تخفیف
                    </span>
                  <?php } ?>
                </p>

              </a>
            </div>
            <div class="col-2">
              <!-- add class like or dislike -->
              <button type="button" value="<?php echo (look_post_details($post_id)->product_id4); ?>" class="btn btn-white rounded-0 btn-heart dislike lh-1 p-2 fs-4"><i
                  class="fa-regular fa-heart" aria-hidden="true"></i></button>
            </div>
          </div>
        </article>
      </div>
    </div>
  </div>
<?php } ?>