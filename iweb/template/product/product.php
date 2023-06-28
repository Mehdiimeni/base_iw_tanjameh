<?php
///template/product/product.php
$item = $_SESSION['item'];
if (get_product_info($item)) {
    ?>
      <!-- start section -->
      <div class="container-md">
        <div class="row mt-4 product">
          <!-- zoom product -->
          <div class="col-12 col-md-6">
            <div class="sticky-md-top">
              <div class="position-relative z-1020">
                <span class="position-absolute top-0 end-0 bg-white p-1 m-2 font-x-s"><?php echo get_product_info($item)->offer1; ?></span>
              </div>
            <ul id="glasscase" class="gc-start">
            <?php foreach (get_product_info($item)->images_address as $image_address) { ?>
                    <li><img src="<?php echo $image_address; ?>" alt="<?php echo get_product_info($item)->name; ?>"></li>
                <?php } ?>
          </ul>
        </div>
          </div>
          <!-- details product -->
          <div class="col-12 col-md-5 offset-md-1 mt-4 mt-md-0">
            <div class="item-detail-product">
              <div class="b-animate b-dark">
                <h3>
                  <a href="#" class="text-decoration-none text-dark d-block product-brand"><?php echo get_product_info($item)->name; ?></a>
                </h3>
                <h3 class="fw-semibold product-title">
                    
                <?php if (!in_array(get_product_info($item)->product_type, _PRODUCT)) {
                    echo get_product_info($item)->product_type;
                } else {
                    echo array_search(get_product_info($item)->product_type, _PRODUCT);
                } ?>
                -
                <?php echo get_product_info($item)->brand_name; ?>
                </h3>
                <?php if (get_product_info($item)->discount_persent) { ?>
                    <p class="font-x-s m-0"><?php echo get_product_info($item)->discount_persent; ?>% <?php echo _LANG['discount']; ?></p>
                <?php } ?>
                <?php echo get_product_info($item)->str_price; ?>
                <?php if (get_product_info($item)->discount_persent) { ?>
                    <?php echo get_product_info($item)->str_old_price; ?>
                <?php } ?>
              </div>
            <!-- rate -->
            <a href="#reviews" class="my-5 d-block text-decoration-none text-dark">
            <div class="my-rating-readOnly d-inline-block" data-rating="<?php echo get_product_info($item)->score; ?>" style="direction: initial;"></div>
              <span><?php echo get_product_info($item)->count_score; ?></span>
            </a>
            <!-- color box -->
             <!-- sizing -->          
            <div class="size-box position-relative">
              <div class="d-grid">
                <button id="btnSize" class="dropbtn form-select form-select-lg rounded-0 border-dark text-start" type="button" value="false" onclick="myDropdown()">
                  <?php echo _LANG['select_size']; ?>
                </button>
                </div>
                <div id="myDropdown" class="mydropdown-content position-absolute box-shadow w-100 p-1 bg-white">
                  <nav class="cat-offcanvas">
                    <div class="nav nav-pills border-bottom" id="nav-tab" role="tablist">
                      <div class="vr"></div>
                      <button class="nav-link text-black-50 rounded-0" id="nav-size2-tab" data-bs-toggle="tab" data-bs-target="#nav-size2-pane" type="button" role="tab" aria-controls="nav-men" aria-selected="true">سایز کارخانه</button>
                    </div>
                  </nav>
                  <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="nav-size1-pane" role="tabpanel" aria-labelledby="nav-size1" tabindex="0">
                      <!-- list size -->
                      <div class="list-group list-group-flush list-size">
                    <?php foreach (get_product_info($item)->all_size as $size) { if($size == '') continue; ?>
                        <button type="button" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                              <h5 class="mb-1 available"><?php echo $size; ?></h5>
                              <small class="text-muted"></small>
                            </div>
                          </button>
                        <?php } ?>
                        <!-- not available size's product -->
                        <?php foreach (get_product_info($item)->all_disabled_size as $disabled_size) { if($disabled_size == '') continue; ?>
                            <button type="button" class="list-group-item list-group-item-action" aria-current="true" data-bs-toggle="modal" data-bs-target="#notifyMe1">
                              <div class="d-flex w-100 justify-content-between text-body-tertiary">
                                <h5 class="mb-1"><?php echo $disabled_size; ?></h5>
                                <small class="text-mediumpurple fw-semibold"><?php echo _LANG['let_me_know']; ?></small>
                              </div>
                            </button>
                        <?php } ?>
                        <!-- Modal -->
                      <div class="modal fade" id="notifyMe1" tabindex="-1" aria-labelledby="notifyMe1Label" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content rounded-0">
                            <div class="modal-header border-0">
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body px-5">
                              <h3 class="fw-semibold"><?php echo _LANG['done']; ?></h3>
                              <h6><?php echo _LANG['when_exist_product_note']; ?></h6>
                              <form class="formNotifyMe form-validation mt-4" role="form" method="POST" novalidate>
                                <div>
                                  <label for="validationEmail" class="form-label m-0 p-1 border border-bottom-0 border-dark"><?php echo _LANG['your_email']; ?> :</label>
                                  <div class="input-group">
                                    <input type="email" class="form-control rounded-0 border-dark" placeholder="example@email.com" id="validationEmail" required>
                                    <div class="invalid-feedback">
                                    <?php echo _LANG['enter_email_note']; ?>
                                </div>
                                  </div>
                                </div>
                                  <button class="btn btn-lg btn-dark w-100 my-3 rounded-0" type="submit" onclick="validateForm()"><?php echo _LANG['let_me_know']; ?></button>
                              </form>
                      <div class="resultNotify">
                        <div class="alert alert-secondary d-flex align-items-center rounded-0 border-0" role="alert">
                          <i class="fa-solid fa-circle-check text-success me-2"></i>
                        <div>
                        <?php echo _LANG['We_have_received_your_request']; ?>
                          </div>
                        </div>
                        <button class="btn btn-lg w-100 my-3 btn-outline-dark rounded-0" type="button" data-bs-dismiss="modal" aria-label="Close"><?php echo _LANG['continue_shopping']; ?></button>
                      </div>
                            </div>
                          </div>
                        </div>
                      </div>
                        <!-- end not available -->
                        
                        
                      </div>
                    </div>
                    <div class="tab-pane fade" id="nav-size2-pane" role="tabpanel" aria-labelledby="nav-size2" tabindex="0">
                      <!-- list size -->
                      <div class="list-group list-group-flush list-size">
                        <!-- not available size's product -->
                        <button type="button" class="list-group-item list-group-item-action" aria-current="true" data-bs-toggle="modal" data-bs-target="#notifyMe2">
                          <div class="d-flex w-100 justify-content-between text-body-tertiary">
                            <h5 class="mb-1">l</h5>
                            <small class="text-mediumpurple fw-semibold">خبرم کن</small>
                          </div>
                        </button>
                        <!-- Modal -->
                      <div class="modal fade" id="notifyMe2" tabindex="-1" aria-labelledby="notifyMe2Label" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content rounded-0">
                            <div class="modal-header border-0">
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body px-5">
                              <h3 class="fw-semibold">تمام شده</h3>
                              <h6>اگر این کالا در انبار بازگردد، ایمیلی دریافت خواهید کرد.</h6>
                              <form class="formNotifyMe form-validation mt-4" role="form" method="POST" novalidate>
                                <div>
                                  <label for="validationEmail" class="form-label m-0 p-1 border border-bottom-0 border-dark">ایمیل شما:</label>
                                  <div class="input-group">
                                    <input type="email" class="form-control rounded-0 border-dark" placeholder="example@email.com" id="validationEmail" required>
                                    <div class="invalid-feedback">
                                      لطفا ایمیل خود را وارد نمایید
                                    </div>
                                  </div>
                                </div>
                                  <button class="btn btn-lg btn-dark w-100 my-3 rounded-0" type="submit" onclick="validateForm()">خبرم کن</button>
                              </form>
                      <div class="resultNotify">
                        <div class="alert alert-secondary d-flex align-items-center rounded-0 border-0" role="alert">
                          <i class="fa-solid fa-circle-check text-success me-2"></i>
                        <div>
                          ما درخواست شما را دریافت کردیم، به زودی با شما در تماس خواهیم بود!
                          </div>
                        </div>
                        <button class="btn btn-lg w-100 my-3 btn-outline-dark rounded-0" type="button" data-bs-dismiss="modal" aria-label="Close">ادامه خرید</button>
                      </div>
                            </div>
                          </div>
                        </div>
                      </div>
                        <!-- end not available -->
                        <button type="button" class="list-group-item list-group-item-action">
                          <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1 available">۲x</h5>
                            <small class="text-muted"></small>
                          </div>
                        </button>
                        <button type="button" class="list-group-item list-group-item-action">
                          <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1 available">۳x</h5>
                            <small class="text-muted">کالای راه دور 3.99 تومان</small>
                          </div>
                        </button>
                      </div>
                    </div>
                   </div>
                </div>
            </div>
            <!-- cart & wishlist -->
            <!-- cart show in small device -->
            <div class="cartSm d-md-none position-fixed top-0 start-0 p-3 w-100 bg-white z-3 border-bottom">
              <span class="items-basket position-absolute top-0 badge rounded-circle bg-orange p-1 font-x-s"></span>
                <svg height="1.5em" width="1.5em" focusable="false" fill="currentColor" viewBox="0 0 24 24" aria-labelledby="your-bag-8883411" role="img" aria-hidden="false"><title id="your-bag-8883411">سبد خرید</title><path d="M20.677 13.654a5.23 5.23 0 0 0 1.073-3.194c-.01-2.632-1.968-4.78-4.5-5.137V5.25a5.25 5.25 0 0 0-10.5 0v.059a5.224 5.224 0 0 0-2.444 1.014 5.23 5.23 0 0 0-.983 7.33A5.623 5.623 0 0 0 6.375 24h11.25a5.623 5.623 0 0 0 3.052-10.346zM12 1.5a3.75 3.75 0 0 1 3.75 3.75h-7.5A3.75 3.75 0 0 1 12 1.5zm5.625 21H6.375a4.122 4.122 0 0 1-1.554-7.942.75.75 0 0 0 .214-1.256A3.697 3.697 0 0 1 3.75 10.5a3.755 3.755 0 0 1 3-3.674V9a.75.75 0 0 0 1.5 0V6.75h7.5V9a.75.75 0 1 0 1.5 0V6.826a3.755 3.755 0 0 1 3 3.674c0 1.076-.47 2.1-1.285 2.802a.75.75 0 0 0 .213 1.256 4.122 4.122 0 0 1-1.553 7.942z"></path></svg>
             <div class="d-grid">
              <a href="#" class="btn btn-dark my-3">ورود به سبد خرید</a>
              </div>
              </div> 
              <!-- end cart small -->
            <div class="d-flex">
                <button id="addToCart" class="btn btn-lg btn-dark w-100 my-2 rounded-0 me-2">افزودن به سبد خرید</button>
                <button id="btnWishlist" type="button" class="btn btn-outline-dark my-2 rounded-0 btn-heart dislike fs-4"><i class="fa-regular fa-heart" aria-hidden="true"></i></button>
            </div>
            <!-- delivery -->
            <ul class="border border-1 rounded-0 p-0 my-4">
              <li class="border-bottom d-flex justify-content-between align-items-start py-3">
                <div class="ps-2 pe-auto">
                  <h6 class="mt-2">فروخته و ارسال شده توسط تن جامه</h6>
                </div>
              </li>
              <li class="border-bottom d-flex justify-content-between align-items-start py-3">
                <div class="ms-2 me-auto">
                  <i class="fa-solid fa-truck"></i>
                  <div class="fw-bold">2-5 روز کاری</div>
                  تحویل استاندارد
                </div>
                <span class="me-2">رایگان</span>
              </li>
              <li class="border-bottom d-flex justify-content-between align-items-start py-3">
                <div class="ms-2 me-auto">
                  <div class="fw-bold">
                    <svg class="zds-icon RC794g X9n9TI DlJ4rT _5Yd-hZ RkQYXx pVrzNP H3jvU7" height="1.5em" width="1.5em" focusable="false" fill="currentColor" viewBox="0 0 24 24" aria-labelledby="box-transit-23640" role="img" aria-hidden="false"><title id="box-transit-23640">box-transit</title><path d="m16.5 14.5-4.2-1.9c-.2-.1-.4-.1-.6 0l-4.2 1.9V6.9l2-5.6h5l2 5.9v7.3zM9 7.3v4.9l2.1-.9c.6-.3 1.2-.3 1.8 0l2.1.9V7.3l-1.6-4.5h-2.9L9 7.3z"></path><path d="M20.5 22.8h-17c-1.2 0-2.2-1-2.2-2.2V19c0-.4.3-.8.8-.8s.8.3.8.8v1.5c0 .4.3.8.8.8h17c.4 0 .8-.3.8-.8V7.3c0-.1 0-.2-.1-.3l-1.5-3.8c-.1-.3-.4-.5-.7-.5H5c-.3 0-.6.2-.7.5L2.8 7c0 .1-.1.2-.1.3V10c0 .4-.3.8-.8.8s-.7-.4-.7-.8V7.3c0-.3.1-.6.2-.8l1.5-3.8c.4-.9 1.2-1.5 2.1-1.5h14c.9 0 1.7.6 2.1 1.4l1.5 3.8c.1.3.2.5.2.8v13.2c0 1.3-1.1 2.4-2.3 2.4z"></path><path d="M2 7h20v1.5H2zM4.8 13.8h-4c-.5 0-.8-.4-.8-.8s.3-.8.8-.8h4c.4 0 .8.3.8.8s-.4.8-.8.8zM4.8 16.8h-4c-.5 0-.8-.4-.8-.8s.3-.8.8-.8h4c.4 0 .8.3.8.8-.1.4-.4.8-.8.8z"></path></svg>
                    <span class="ms-2">ارسال رایگان و مرجوعی رایگان</span>
                  </div>
                </div>
              </li>
              <li class="border-bottom d-flex justify-content-between align-items-start py-3">
                <div class="ms-2 me-auto">
                  <div class="fw-bold">
                    <svg class="zds-icon RC794g X9n9TI DlJ4rT _5Yd-hZ RkQYXx pVrzNP H3jvU7" height="1.5em" width="1.5em" focusable="false" fill="currentColor" viewBox="0 0 24 24" aria-labelledby="returns-23641" role="img" aria-hidden="false"><title id="returns-23641">returns</title><path d="M14.25 4.33H1.939l3.056-3.055A.75.75 0 0 0 3.934.215L.658 3.49a2.252 2.252 0 0 0 0 3.182l3.276 3.275a.75.75 0 0 0 1.06-1.06L1.94 5.83h12.31c4.557 0 8.251 3.694 8.251 8.25S18.806 22.5 14.25 22.5h-12a.75.75 0 0 0 0 1.5h12c5.385 0 9.75-4.534 9.75-9.919s-4.365-9.75-9.75-9.75z"></path></svg>
                    <span class="ms-2">سیاست بازگشت 100 روزه</span>
                  </div>
                </div>
              </li>
            </ul>
            <!-- accordion description -->
            <div class="accordion accordion-flush" id="accordionDescription">
              <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingOne">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                    مواد و مراقبت
                  </button>
                </h2>
                <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne">
                  <div class="accordion-body">
                    <ul class="list-unstyled">
                      <li><strong>مواد بالا: </strong>چرم بدلی/ منسوجات</li>
                      <li><strong>پوشش: </strong>منسوجات</li>
                      <li><strong>کفی: </strong>منسوجات</li>
                     <li><strong>تنها: </strong>مصنوعی</li>
                     <li><strong>پارچه: </strong>چرم مصنوعی</li>
                     </ul>
                </div>
              </div>
              </div>
              <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingTwo">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                    جزئیات
                  </button>
                </h2>
                <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo">
                  <div class="accordion-body">
                    <ul class="list-unstyled">
                      <li><strong>کفی: </strong>منسوجات</li>
                     <li><strong>تنها: </strong>مصنوعی</li>
                     <li><strong>پارچه: </strong>چرم مصنوعی</li>
                     </ul>
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingThree">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                    اندازه و تناسب
                  </button>
                </h2>
                <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree">
                  <div class="accordion-body">
                    <ul class="list-unstyled">
                     <li><strong>کفی: </strong>منسوجات</li>
                    <li><strong>تنها: </strong>مصنوعی</li>
                    <li><strong>پارچه: </strong>چرم مصنوعی</li>
                    </ul>
                    <!-- Button trigger modal -->
<button type="button" class="btn btn-dark rounded-0" data-bs-toggle="modal" data-bs-target="#sizeGuidModal">
  راهنمای اندازه
</button>

<!-- Modal -->
<div class="modal fade" id="sizeGuidModal" tabindex="-1" aria-labelledby="sizeGuidModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content rounded-0">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body px-4">
        <h4 class="fw-semibold">راهنمای اندازه</h4>
        <p>
          با راهنمای تبدیل مفید ما، اندازه خود را در کشورهای مختلف بیابید. بهتر است از این به عنوان یک قاعده کلی استفاده کنید، زیرا اندازه ها و اندازه ها می تواند از برندی به برند دیگر متفاوت باشد.
        </p>
        <h6 class="fw-semibold mt-5 mb-3">تبدیل اندازه</h6>
        <table class="table table-striped text-center">
          <thead>
            <tr>
              <td scope="col">UK</td>
              <td scope="col">INT</td>
              <td scope="col">EU</td>
              <td scope="col">FR</td>
              <td scope="col">IT</td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>4</td>
              <td>XXS</td>
              <td>32</td>
              <td>34</td>
              <td>38</td>
            </tr>
            <tr>
              <td>4</td>
              <td>XXS</td>
              <td>32</td>
              <td>34</td>
              <td>38</td>
            </tr>
          </tbody>
        </table>
        <h6 class="fw-semibold mt-5 mb-3">اندازه بدن</h6>
        <table class="table table-striped text-center">
          <thead>
            <tr>
              <td scope="col">UK</td>
              <td scope="col">INT</td>
              <td scope="col">نیم تنه</td>
              <td scope="col">کمر</td>
              <td scope="col">HIP</td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>4</td>
              <td>XXS</td>
              <td>76</td>
              <td>63</td>
              <td>85</td>
            </tr>
          </tbody>
        </table>
        <p class="fw-semibold mt-5">چگونه خود را اندازه گیری کنیم</p>
        <h6 class="fw-semibold m-0">نیم تنه</h6>
        <h6 class="mb-4">نوار اندازه گیری را زیر بغل خود بیاورید و کامل ترین قسمت سینه خود را اندازه بگیرید</h6>
        <h6 class="fw-semibold m-0">کمر</h6>
        <h6 class="mb-4">نوار اندازه گیری را دور کمر طبیعی خود بیاورید و بین بالاترین قسمت استخوان لگن و دنده های پایینی خود اندازه بگیرید.</h6>
        <h6 class="fw-semibold m-0">Hip</h6>
        <h6 class="mb-4">نوار اندازه گیری را دور باسن خود بیاورید و کامل ترین قسمت پایین بدن خود را اندازه بگیرید</h6>
      </div>
    </div>
  </div>
</div>

                  </div>
                </div>
              </div>
            </div>
            <!-- follow -->
            <div class="hstack border border-start-0 border-end-0 p-3 mb-5">
              <div class="bg-light">Nike Sportswear</div>
              <div class="bg-light ms-auto">
                <button class="btn border-1 rounded-0 btn-outline-dark m-auto d-flex align-items-center clike-follow notfollow"><i class="fa-solid fa-plus me-2"></i><span>دنبال کنید</span></button>
              </div>
            </div>
            <!-- reviews -->
            <div id="reviews">
              <h6 class="fw-semibold">نظرها (2)</h6>
              <div class="hstack mb-3">
                <h4 class="fw-semibold">4.5</h4>
                <div class="ms-auto">
                  <div class="my-rating-readOnly" data-rating="4.5" style="direction: initial;"></div>
                </div>
              </div>
              <!-- progress -->
              <ul class="list-unstyled d-flex flex-column justify-content-between">
                <li class="d-flex align-items-center mb-1">
                  <label class="font-x-s text-dark-emphasis me-3">5</label>
                  <div class="progress rounded-0 flex-grow-1" style="height: 4px;">
                    <div class="progress-bar bg-dark" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </li>
                <li class="d-flex align-items-center mb-1">
                  <label class="font-x-s text-dark-emphasis me-3">2</label>
                  <div class="progress rounded-0 flex-grow-1" style="height: 4px;">
                    <div class="progress-bar bg-dark" role="progressbar" style="width: 15%;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </li>
                <li class="d-flex align-items-center mb-1">
                  <label class="font-x-s text-dark-emphasis me-3">3</label>
                  <div class="progress rounded-0 flex-grow-1" style="height: 4px;">
                    <div class="progress-bar bg-dark" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </li>
                <li class="d-flex align-items-center mb-1">
                  <label class="font-x-s text-dark-emphasis me-3">4</label>
                  <div class="progress rounded-0 flex-grow-1" style="height: 4px;">
                    <div class="progress-bar bg-dark" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </li>
                <li class="d-flex align-items-center mb-1">
                  <label class="font-x-s text-dark-emphasis me-3">1</label>
                  <div class="progress rounded-0 flex-grow-1" style="height: 4px;">
                    <div class="progress-bar bg-dark" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </li>
              </ul>
              <!-- reviews's Button trigger modal -->
              <button type="button" class="btn btn-lg w-100 btn-outline-dark rounded-0 mb-4 fs-6 fw-bold" data-bs-toggle="modal" data-bs-target="#reviewsModal">
                خواندن همه نظرها
              </button>
              <!-- Modal -->
              <div class="modal fade" id="reviewsModal" tabindex="-1" aria-labelledby="reviewsModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-fullscreen-sm-down">
                  <div class="modal-content rounded-0">
                      <button type="button" class="btn-close p-3" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-body">
                      <h2 class="fw-semibold">نظرها (2)</h2>
                      <div class="hstack mb-3">
                        <h3 class="fw-semibold">4.5</h3>
                        <div class="ms-auto">
                          <div class="my-rating-readOnly" data-rating="4.5" style="direction: initial;"></div>
                        </div>
                      </div>
                      <!-- progress -->
                      <ul class="list-unstyled d-flex flex-column justify-content-between">
                        <li class="d-flex align-items-center mb-1">
                          <label class="font-x-s text-dark-emphasis me-3">5</label>
                          <div class="progress rounded-0 flex-grow-1" style="height: 4px;">
                            <div class="progress-bar bg-dark" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                        </li>
                        <li class="d-flex align-items-center mb-1">
                          <label class="font-x-s text-dark-emphasis me-3">2</label>
                          <div class="progress rounded-0 flex-grow-1" style="height: 4px;">
                            <div class="progress-bar bg-dark" role="progressbar" style="width: 15%;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                        </li>
                        <li class="d-flex align-items-center mb-1">
                          <label class="font-x-s text-dark-emphasis me-3">3</label>
                          <div class="progress rounded-0 flex-grow-1" style="height: 4px;">
                            <div class="progress-bar bg-dark" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                        </li>
                        <li class="d-flex align-items-center mb-1">
                          <label class="font-x-s text-dark-emphasis me-3">4</label>
                          <div class="progress rounded-0 flex-grow-1" style="height: 4px;">
                            <div class="progress-bar bg-dark" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                        </li>
                        <li class="d-flex align-items-center mb-1">
                          <label class="font-x-s text-dark-emphasis me-3">1</label>
                          <div class="progress rounded-0 flex-grow-1" style="height: 4px;">
                            <div class="progress-bar bg-dark" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                        </li>
                      </ul>
                      <!-- reviews work -->
                      <div class="b-animate b-purple my-4">
                        <a class="text-mediumpurple d-inline-block text-decoration-none" data-bs-toggle="collapse" href="#reviewsWork" role="button" aria-expanded="false" aria-controls="reviewsWork">
                          نظر ها چگونه کار می کنند?
                        </a>
                        <div class="collapse" id="reviewsWork">
                          <div class="pt-2">
                            فقط مشتریان ثبت‌شده تن جامه که این مورد را خریداری کرده‌اند می‌توانند رتبه‌بندی و نظرات خود را ارسال کنند. امتیاز ستاره (از 5) میانگین همه رتبه ها است. مشتریان همچنین می توانند نظرات خود را کتبی بگذارند. ما نظرات مثبت و منفی را پس از تعدیل آنها منتشر می کنیم.
                          </div>
                        </div>
                      </div>
                      <small class="d-block mb-4 fw-semibold">بر اساس مفید بودن و تاریخ مرتب شده است</small>
                      <ul class="list-unstyled">
                        <li class="border-top py-3">
                          <div class="hstack">
                            <div>
                              <h6 class="fw-semibold">امین</h6>
                            <h6 class="text-body-tertiary">خریداری شده: 1401-02-11</h6>
                            <h6 class="text-body-tertiary">نظردهی شده: 1401-02-21</h6>
                            <div class="my-rating-readOnly" data-rating="4.5" style="direction: initial;"></div>
                            </div>
                            <img src="media/product/review1.webp" class="ms-auto" width="84" alt="">
                          </div>
                          <h6 class="my-4">
                            کاملا مناسب است و زیبا به نظر می رسد. اندازه درست است، نه خیلی کوچک و نه خیلی بزرگ. مواد عالی، شما را گرم نگه می دارد
                          </h6>
                          <button type="button" class="btn btn-outline-dark rounded-0 px-4 btn-helpfull nothelpfull" data-number="1">مفیده ؟</button>
                        </li>
                        <li class="border-top py-3">
                          <div class="hstack">
                            <div>
                              <h6 class="fw-semibold">ساناز</h6>
                            <h6 class="text-body-tertiary">خریداری شده: 1401-01-21</h6>
                            <h6 class="text-body-tertiary">نظردهی شده: 1401-01-29</h6>
                            <div class="my-rating-readOnly" data-rating="3" style="direction: initial;"></div>
                            </div>
                            <img src="media/product/review2.webp" class="ms-auto" width="84" alt="">
                          </div>
                          <h6 class="my-4">
                            کاملا مناسب است و زیبا به نظر می رسد. اندازه درست است، نه خیلی کوچک و نه خیلی بزرگ. مواد عالی، شما را گرم نگه می دارد
                          </h6>
                          <button type="button" class="btn btn-outline-dark rounded-0 px-4 btn-helpfull nothelpfull" data-number="1">مفیده ؟</button>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Button trigger modal -->
            <a type="button" class="text-decoration-none text-mediumpurple" data-bs-toggle="modal" data-bs-target="#howReviewsModal">
              نظرها چگونه کار میکنند ؟
            </a>
            <!-- Modal -->
            <div class="modal fade" id="howReviewsModal" tabindex="-1" aria-labelledby="howReviewsModal" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content rounded-0">
                    <button type="button" class="btn-close p-3" data-bs-dismiss="modal" aria-label="Close"></button>
                  <div class="modal-body">
                    <h3 class="fw-semibold mb-4">نظرها چگونه کار میکنند ؟</h3>
                    <p>
                      فقط مشتریان ثبت‌شده تن جامه که این مورد را خریداری کرده‌اند می‌توانند رتبه‌بندی و نظرات خود را ارسال کنند. امتیاز ستاره (از 5) میانگین همه رتبه ها است.
                    </p>
                    <p>
                      مشتریان همچنین می توانند نظرات خود را کتبی بگذارند. ما نظرات مثبت و منفی را پس از تعدیل آنها منتشر می کنیم.
                    </p>
                  </div>
                </div>
              </div>
            </div>
            </div>
          </div>
          </div>
        </div>
      </div>
      <?php } ?>