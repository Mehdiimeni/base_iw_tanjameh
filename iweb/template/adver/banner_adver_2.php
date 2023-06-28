<?php
///template/adver/banner_adver_1.php
$position_order = 2;
if (get_banner_adver_data($_SESSION['page_name_system'], $position_order)) {
  ?>
  <div class="text-dark"
    style="background-color: <?php echo (@get_banner_adver_data($_SESSION['page_name_system'], $position_order)[0]->main_color); ?>;">
    <div class="container-md">
      <div class="row pt-5 ps-4 ps-md-0 position-relative placeholder-glow">
        <div class="col-12 col-md-6 py-3">
          <h3 class="fw-semibold">
            <?php echo (@get_banner_adver_data($_SESSION['page_name_system'], $position_order)[0]->title); ?>
          </h3>
          <h4 class="mb-4">
            <?php echo (@get_banner_adver_data($_SESSION['page_name_system'], $position_order)[0]->content); ?>
          </h4>
          <a href="<?php echo (@get_banner_adver_data($_SESSION['page_name_system'], $position_order)[0]->bottom_link); ?>" class="text-decoration-none text-dark fw-semibold stretched-link">
            <?php echo (@get_banner_adver_data($_SESSION['page_name_system'], $position_order)[0]->bottom_caption); ?><i
              class="fa-solid fa-arrow-left"></i>
          </a>
        </div>
        <div class="col-12 col-md-6 card p-0 rounded-0 border-0">
          <div class="position-relative pt-48 bg-dark-subtle placeholder">
            <img class="lazy-image position-absolute top-0 w-100"
              data-src="./irepository/img/adver_banner/<?php echo (@get_banner_adver_data($_SESSION['page_name_system'], $position_order)[0]->image); ?>"
              alt="<?php echo (@get_banner_adver_data($_SESSION['page_name_system'], $position_order)[0]->title); ?>">
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- carousel center nonloop -->
  <div class="container-fluid py-5"
    style="background-color: <?php echo (@get_banner_adver_data($_SESSION['page_name_system'], $position_order)[0]->second_color); ?>;">
    <div class="row">
      <div class="col-0 col-md-1"></div>
      <div class="col-12 col-md-11 position-relative overflow-hidden">
        <div class="container position-absolute bottom-50 z-2">
          <div class="position-relative index-owl-nav"></div>
        </div>
        <div class="owl-center-nonloop owl-carousel">
          <?php if (get_banner_adver_product($_SESSION['page_name_system'], $position_order)) {
            foreach (get_banner_adver_product($_SESSION['page_name_system'], $position_order) as $Product) { ?>
              <div class="item position-relative">
                <div class="position-absolute top-0 z-1 mt-2">
                  <!-- add class like or dislike -->

                  <button type="button" class="btn btn-light rounded-0 btn-heart dislike lh-1 p-2 fs-5"><i
                      class="fa-regular fa-heart" aria-hidden="true"></i></button>
                </div>
                <a href="<?php echo $Product->product_page_url; ?>" class="text-decoration-none">
                  <div class="card text-dark rounded-0 border-0 bg-transparent">
                    <div class="position-relative">
                      <?php echo $Product->image; ?>
                      <div class="position-absolute bottom-0 end-0 hstack gap-1">
                        <?php echo $Product->offer1;  ?>
                      </div>
                    </div>
                    <div class="card-body p-0 py-2">
                      <h6 class="m-0 text-truncate">
                        <?php echo $Product->name; ?>
                      </h6>
                      <h6 class="m-0 text-truncate">
                        <?php echo $Product->product_content; ?>
                      </h6>
                    </div>
                    <section>
                      <div class="hstack gap-3">
                        <?php echo $Product->str_price; ?>
                      </div>
                    </section>
                    <?php if (isset($Product->note1) and false) { ?>
                      <section class="hstack gap-1">
                        <svg class="zds-icon RC794g X9n9TI DlJ4rT _5Yd-hZ KJcyNx weHhRC H3jvU7" height="1.5em" width="1.5em"
                          focusable="false" fill="currentColor" viewBox="0 0 24 24" aria-labelledby="truck-long-distance-133"
                          role="img" aria-hidden="false">
                          <title id="truck-long-distance-133">truck-long-distance</title>
                          <path
                            d="M20.395 7.738a.891.891 0 0 0-.661-.294h-3.212V4.58c0-.492-.4-.891-.891-.891H9.503a5.6 5.6 0 0 0 .407-2.114c0-.043-.017-.08-.025-.121h.236a.714.714 0 1 0 0-1.43H1.563a.714.714 0 1 0 0 1.43h.236c-.008.04-.025.078-.025.12 0 1.982.894 3.566 2.576 4.66-1.621 1.056-2.5 2.57-2.561 4.453h-.226a.714.714 0 1 0 0 1.429h.696v4.236c0 .49.4.891.892.891h1.288c.014 1.653 1.36 2.995 3.017 2.995s3.004-1.342 3.018-2.995h6.006c.014 1.653 1.36 2.995 3.017 2.995s3.004-1.342 3.018-2.995h.606c.492 0 .892-.4.892-.891v-4.693l-3.618-3.92zM3.203 1.574c0-.043-.017-.08-.025-.121h5.328c-.008.04-.025.078-.025.12 0 1.732-.895 3.027-2.639 3.866-1.744-.839-2.64-2.134-2.64-3.865zm2.639 5.455c1.672.804 2.555 2.032 2.625 3.657h-5.25c.07-1.626.952-2.853 2.625-3.657zm1.614 11.708c-.838 0-1.52-.681-1.52-1.52 0-.838.682-1.52 1.52-1.52s1.52.682 1.52 1.52c0 .839-.681 1.52-1.52 1.52zm7.566-2.995h-4.947c-.519-.917-1.492-1.545-2.619-1.545s-2.1.628-2.619 1.545H3.76v-3.627h6.362a.714.714 0 1 0 0-1.429h-.226c-.06-1.882-.94-3.397-2.562-4.452.477-.31.891-.659 1.237-1.046h6.452v10.554zm4.475 2.995c-.838 0-1.52-.681-1.52-1.52a1.521 1.521 0 0 1 3.04 0c0 .839-.68 1.52-1.52 1.52zm3.016-2.995h-.396c-.52-.917-1.493-1.545-2.62-1.545s-2.1.628-2.618 1.545h-.357V8.944h2.944l3.047 3.3v3.498z">
                          </path>
                        </svg>
                        <?php echo $Product->note1; ?>
                      </section>
                    <?php } ?>
                  </div>
                </a>
              </div>
            <?php }
          } //?>
        </div>
      </div>
    </div>
  </div>
<?php } ?>