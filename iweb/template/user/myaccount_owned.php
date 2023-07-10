<?php
///template/user/myaccount_owned.php
?>
<!-- start section -->
<div class="container-lg pt-4">
  <div class="row">
    <!-- items -->
      <div class="mb-3">
        <div class="b-animate b-purple mb-3">
          <a href="wish-list.html" class="text-decoration-none text-mediumpurple d-inline-block">
            <i class="fa fa-arrow-right me-1"></i>
            <span>برگشت</span>
          </a>
        </div>
        <h3 class="fw-bold mb-5">اقلام متعلق به</h3>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3">
          <div class="col item">
              <div class="card text-dark rounded-0 border-0 bg-transparent placeholder-glow">
                <div class="position-relative bg-secondary-subtle placeholder">
                <img data-src="media/women-carousel-b3.webp" class="card-img rounded-0 lazy-image" alt="...">
                <a href="#" class="stretched-link"></a>
                <div class="d-flex flex-column-reverse position-absolute end-0 bottom-0 z-1 mb-2">
                  <div class="bg-white p-1 font-x-s text-danger">فروخته شده</div>
                </div>
                <div class="d-flex flex-column-reverse position-absolute start-0 bottom-0 z-1 mb-2">
                  <button type="button" class="btnNotification unNotify btn btn-lg rounded-0 btn-alarm fs-4" ><i class="fa-regular fa-bell" aria-hidden="true"></i></button>
                  <!-- Button items modal -->
                  <button class="btn btn-light btn-lg rounded-0" data-bs-toggle="modal" data-bs-target="#itemModal1"><i class="fa-solid fa-ellipsis"></i></button>
                </div>
                  <!-- modal items -->
                  <div class="modal fade" id="itemModal1" tabindex="-1" aria-labelledby="itemModal1Label" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content rounded-0">
                        <div class="modal-header border-0">
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <div class="row placeholder-glow">
                            <div class="col-5 bg-secondary-subtle placeholder">
                              <img class="lazy-image w-100" data-src="media/women-carousel-b3.webp" alt="">
                            </div>
                            <div class="col-7">
                              <h4 class="fw-bold mb-4">سویشرت مشکی</h4>
                              <hr class="mb-0 border-secondary">
                              <div class="boxModalOwned d-flex flex-column flex-grow-1">
                                <a href="review.html" class="btn btn-lg nav-hover py-3 fs-6 rounded-0 border-bottom d-flex justify-content-between align-items-center">
                                  <span>نظردهی محصول</span>
                                  <i class="fa fa-chevron-left"></i>
                                </a>
                                <button class="btnAnotherSize btn btn-lg nav-hover py-3 fs-6 rounded-0 border-bottom d-flex justify-content-between align-items-center">
                                  <span>در سایز دیگر خرید کنید</span>
                                  <i class="fa fa-chevron-left"></i>
                                </button>
                                <a href="myaccount-order-detail.html" class="btn btn-lg nav-hover py-3 fs-6 rounded-0 border-bottom d-flex justify-content-between align-items-center">
                                  <span>مشاهده سفارش</span>
                                  <i class="fa fa-chevron-left"></i>
                                </a>
                                <a href="#" class="btn btn-lg nav-hover py-3 fs-6 rounded-0 border-bottom d-flex justify-content-between align-items-center">
                                  <span>مشاهده موارد مشابه</span>
                                  <i class="fa fa-chevron-left"></i>
                                </a>
                                <button class="btnRemoveItem btn btn-lg nav-hover py-3 fs-6 rounded-0 border-bottom d-flex justify-content-between align-items-center text-danger" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                  <span>حذف</span>
                                  <i class="fa fa-chevron-left"></i>
                                </button>
                              </div>
                              <div class="boxAnotherSize">
                                <button class="btnRequestSize btn btn-lg nav-hover py-3 fs-6 rounded-0 border-bottom d-flex justify-content-between align-items-center" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                  <div><p class="fw-bold d-inline-block fs-5 m-0">xl</p><small class="text-danger ms-2">125040 تومان</small></div>
                                  <span class="text-mediumpurple">درخواست اندازه</span>
                                </button>
                                <button class="btnRequestSize btn btn-lg nav-hover py-3 fs-6 rounded-0 border-bottom d-flex justify-content-between align-items-center" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                  <div><p class="fw-bold d-inline-block fs-5 m-0">xl</p><small class="text-body-tertiary ms-2">125040 تومان</small></div>
                                  <span></span>
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-body p-0 py-2">
                  <h6 class="m-0 text-truncate">HOSBJERG</h6>
                  <h6 class="m-0 text-truncate">شلوار ALEXA CUFF - شلوار - آبی</h6>
                </div>
                <section>
                  <article class="d-flex small gap-2">
                    <h6 class="text-danger">۱،۳۵۰،۰۰۰ تومان</h6>
                    <del>۱،۵۵۰،۰۰۰</del>
                  </article>
                </section>
                <div class="text-body-tertiary small">اندازه: xl</div>
                <div class="text-body-tertiary">4 ماه پیش خریدم</div>
              </div>
          </div>
        </div>
      </div>
</div>
</div>