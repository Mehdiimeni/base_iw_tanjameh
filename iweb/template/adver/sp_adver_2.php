<?php
///template/adver/sp_adver_2.php
$position_order = 2;
if (get_sp_adver_data($_SESSION['page_name_system'], $position_order)) {
  ?>
  <div class="container-fluid py-5">
    <div class="row">
      <div class="col-0 col-md-1"></div>
      <div class="col-12 col-md-11 position-relative overflow-hidden">
        <h3 class="fw-semibold">
          <?php echo (@get_sp_adver_data($_SESSION['page_name_system'], $position_order)[0]->title); ?>
        </h3>
        <div class="hstack b-animate b-dark">
          <h4>
            <?php echo (@get_sp_adver_data($_SESSION['page_name_system'], $position_order)[0]->content); ?>
          </h4>
          <a href="#" class="ms-auto text-decoration-none text-mediumpurple">
            <?php echo (@get_sp_adver_data($_SESSION['page_name_system'], $position_order)[0]->bottom_caption); ?><i
              class="fa-solid fa-arrow-left"></i>
          </a>
        </div>
        <div class="container position-absolute bottom-50 z-2">
          <div class="position-relative index-owl-nav"></div>
        </div>
        <div class="owl-center-nonloop owl-carousel">
          <?php if (get_sp_adver_product($_SESSION['page_name_system'], $position_order)) {
            foreach (get_sp_adver_product($_SESSION['page_name_system'], $position_order) as $Product) { ?>
              <div class="item position-relative">
                <div class="position-absolute top-0 z-1 mt-2">
                  <!-- add class like or dislike -->
                  <button type="button" class="btn btn-light rounded-0 btn-heart dislike lh-1 p-2 fs-5"><i
                      class="fa-regular fa-heart" aria-hidden="true"></i></button>
                </div>
                <a href="#" class="text-decoration-none">
                  <div class="card text-dark rounded-0 border-0 bg-transparent">
                    <div class="position-relative">
                      <?php echo get_product_details($Product->IdRow)->image; ?>

                      <div class="text-bg-dark p-1 mb-2 position-absolute bottom-0 end-0">
                        <?php //echo get_product_details($Product->IdRow)->offer1;  ?>
                      </div>
                    </div>
                    <div class="card-body p-0 py-2">
                      <h6 class="m-0 text-truncate">
                        <?php echo get_product_details($Product->IdRow)->name; ?>
                      </h6>
                      <h6 class="m-0 text-truncate">
                        <?php echo get_product_details($Product->IdRow)->product_content; ?>
                      </h6>
                    </div>
                    <section>
                      <h6>
                        <?php echo get_product_details($Product->IdRow)->str_price; ?>
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
  <?php } ?>