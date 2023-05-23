<?php
///template/adver/banner_adver_1.php

?>
<div class="text-dark" style="background-color: <?php echo (@get_banner_adver_data($_SESSION['page_name_system'],1)[0]->main_color); ?>;">
  <div class="container-md">
    <div class="row pt-5 ps-4 ps-md-0 position-relative placeholder-glow">
      <div class="col-12 col-md-6 py-3">
        <h3 class="fw-semibold"><?php echo (@get_banner_adver_data($_SESSION['page_name_system'],1)[0]->title); ?></h3>
        <h4 class="mb-4"><?php echo (@get_banner_adver_data($_SESSION['page_name_system'],1)[0]->content); ?></h4>
        <a href="products.html" class="text-decoration-none text-dark fw-semibold stretched-link"><?php echo (@get_banner_adver_data($_SESSION['page_name_system'],1)[0]->bottom_caption); ?><i
            class="fa-solid fa-arrow-left"></i></a>
      </div>
      <div class="col-12 col-md-6 card p-0 rounded-0 border-0">
        <div class="position-relative pt-48 bg-dark-subtle placeholder">
          <img class="lazy-image position-absolute top-0 w-100" data-src="./irepository/img/adver_banner/<?php echo (@get_banner_adver_data($_SESSION['page_name_system'],1)[0]->image); ?>" alt="<?php echo (@get_banner_adver_data($_SESSION['page_name_system'],1)[0]->title); ?>">
        </div>
      </div>
    </div>
  </div>
</div>
<!-- carousel center nonloop -->
<div class="container-fluid py-5" style="background-color: <?php echo (@get_banner_adver_data($_SESSION['page_name_system'],1)[0]->second_color); ?>;">
  <div class="row">
    <div class="col-0 col-md-1"></div>
    <div class="col-12 col-md-11 position-relative overflow-hidden">
      <div class="container position-absolute bottom-50 z-2">
        <div class="position-relative index-owl-nav"></div>
      </div>
      <div class="owl-center-nonloop owl-carousel">
      <?php foreach (get_banner_adver_product($_SESSION['page_name_system'],1) as $Product) { ?>
        <div class="item position-relative">
          <div class="position-absolute top-0 z-1 mt-2">
            <!-- add class like or dislike -->
            <button type="button" class="btn btn-light rounded-0 btn-heart dislike lh-1 p-2 fs-5"><i
                class="fa-regular fa-heart" aria-hidden="true"></i></button>
          </div>
          <a href="product-detail.html" class="text-decoration-none">
            <div class="card text-dark rounded-0 border-0 bg-transparent">
              <div class="position-relative">
                <?php echo $objShowFile->ShowImage('', $objShowFile->FileLocation("attachedimage"), @$objArrayImage[0], $Product->ProductId, 314, 'class="card-img rounded-0 owl-lazy"'); ?>
                <img data-src="media/men/men-a1.webp" class="card-img rounded-0 owl-lazy" alt="...">
                <div class="position-absolute bottom-0 end-0 hstack gap-1">
                  <div class="text-bg-light p-1 mb-2"><small>جدید</small></div>
                  <div class="text-bg-danger p-1 mb-2"><small>تا ۳۰٪ تخفیف</small></div>
                </div>
              </div>
              <div class="card-body p-0 py-2">
                <h6 class="m-0 text-truncate"><?php echo $Product->Name; ?></h6>
                <h6 class="m-0 text-truncate"><?php echo $Product->PGroup; ?></h6>
              </div>
              <section>
                <h6>۵،۴۰۰،۰۰۰ تومان</h6>
              </section>
            </div>
          </a>
        </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>