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
            <span class="position-absolute top-0 end-0 bg-white p-1 m-2 font-x-s">
              <?php echo get_product_info($item)->offer1; ?>
            </span>
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
              <a href="?brand=<?php echo get_product_info($item)->brand_name; ?>&id=<?php echo get_product_info($item)->brand_id; ?>"
                class="text-decoration-none text-dark d-block product-brand"><?php echo get_product_info($item)->brand_name; ?></a>
            </h3>
            <h2>
              <?php echo str_replace(get_product_info($item)->brand_name, "", get_product_info($item)->name); ?>
            </h2>
            <h3 class="fw-semibold product-title">

              <?php if (!in_array(get_product_info($item)->product_type, _PRODUCT)) {
                echo get_product_info($item)->product_type;
              } else {
                echo array_search(get_product_info($item)->product_type, _PRODUCT);
              } ?>


            </h3>
            <?php if (get_product_info($item)->discount_persent) { ?>
              <p class="font-x-s m-0">
                <?php echo get_product_info($item)->discount_persent; ?>%
                <?php echo _LANG['discount']; ?>
              </p>
            <?php } ?>
            <h3 class="fw-semibold product-price"> <?php echo get_product_info($item)->str_price; ?></h3>
            <?php if (get_product_info($item)->discount_persent) { ?>
              <?php echo get_product_info($item)->str_old_price; ?>
            <?php } ?>
          </div>
          <!-- rate -->
          <a href="#reviews" class="my-5 d-block text-decoration-none text-dark">
            <div class="my-rating-readOnly d-inline-block" data-rating="<?php echo get_product_info($item)->score; ?>"
              style="direction: initial;"></div>
            <span>
              <?php echo get_product_info($item)->score; ?>
            </span>
          </a>
          <!-- color box -->
          <!-- sizing -->
          <div class="size-box position-relative">
            <div class="d-grid">
              <button id="btnSize" class="dropbtn form-select form-select-lg rounded-0 border-dark text-start"
                type="button" value="false" onclick="myDropdown()">
                <?php echo _LANG['select_size']; ?>
              </button>
            </div>
            <div id="myDropdown" class="mydropdown-content position-absolute box-shadow w-100 p-1 bg-white">
              <nav class="cat-offcanvas">
                <div class="nav nav-pills border-bottom" id="nav-tab" role="tablist">
                  <div class="vr"></div>
                  <button class="nav-link text-black-50 rounded-0" id="nav-size2-tab" data-bs-toggle="tab"
                    data-bs-target="#nav-size2-pane" type="button" role="tab" aria-controls="nav-men"
                    aria-selected="true"><?php echo _LANG['factory_size']; ?></button>
                </div>
              </nav>
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="nav-size1-pane" role="tabpanel" aria-labelledby="nav-size1"
                  tabindex="0">
                  <!-- list size -->
                  <div class="list-group list-group-flush list-size">
                    <?php  foreach ((array)get_product_info($item)->all_size as $id=>$size) {
                      if ($size == '')
                        continue; ?>
                      <button type="button" value="<?php echo $id; ?>"  class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between">
                          <h5 class="mb-1 available">
                            <?php echo $size; ?>
                          </h5>
                          <small class="text-muted"></small>
                        </div>
                      </button>
                    <?php } ?>
                    <!-- not available size's product -->
                    <?php foreach ((array)get_product_info($item)->all_disabled_size as $id=>$disabled_size) {
                      if ($disabled_size == '')
                        continue; ?>
                      <button type="button" class="list-group-item list-group-item-action" aria-current="true"
                        data-bs-toggle="modal" data-bs-target="#notifyMe1">
                        <div class="d-flex w-100 justify-content-between text-body-tertiary">
                          <h5 class="mb-1">
                            <?php echo $disabled_size; ?>
                          </h5>
                          <small class="text-mediumpurple fw-semibold">
                            <?php echo _LANG['let_me_know']; ?>
                          </small>
                        </div>
                      </button>
                    <?php } ?>
                    <!-- Modal -->
                    <div class="modal fade" id="notifyMe1" tabindex="-1" aria-labelledby="notifyMe1Label"
                      aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content rounded-0">
                          <div class="modal-header border-0">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body px-5">
                            <h3 class="fw-semibold">
                              <?php echo _LANG['done']; ?>
                            </h3>
                            <h6>
                              <?php echo _LANG['when_exist_product_note']; ?>
                            </h6>
                            <form class="formNotifyMe form-validation mt-4" role="form" method="POST" novalidate>
                              <div>
                                <label for="validationEmail"
                                  class="form-label m-0 p-1 border border-bottom-0 border-dark">
                                  <?php echo _LANG['your_email']; ?> :
                                </label>
                                <div class="input-group">
                                  <input type="email" class="form-control rounded-0 border-dark"
                                    placeholder="example@email.com" id="validationEmail" required>
                                  <div class="invalid-feedback">
                                    <?php echo _LANG['enter_email_note']; ?>
                                  </div>
                                </div>
                              </div>
                              <button class="btn btn-lg btn-dark w-100 my-3 rounded-0" type="submit"
                                onclick="validateForm()">
                                <?php echo _LANG['let_me_know']; ?>
                              </button>
                            </form>
                            <div class="resultNotify">
                              <div class="alert alert-secondary d-flex align-items-center rounded-0 border-0"
                                role="alert">
                                <i class="fa-solid fa-circle-check text-success me-2"></i>
                                <div>
                                  <?php echo _LANG['We_have_received_your_request']; ?>
                                </div>
                              </div>
                              <button class="btn btn-lg w-100 my-3 btn-outline-dark rounded-0" type="button"
                                data-bs-dismiss="modal" aria-label="Close">
                                <?php echo _LANG['continue_shopping']; ?>
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- end not available -->


                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- cart & wishlist -->
          <!-- cart show in small device -->
          <div class="cartSm d-md-none position-fixed top-0 start-0 p-3 w-100 bg-white z-3 border-bottom">
            <span class="items-basket position-absolute top-0 badge rounded-circle bg-orange p-1 font-x-s"></span>
            <svg height="1.5em" width="1.5em" focusable="false" fill="currentColor" viewBox="0 0 24 24"
              aria-labelledby="your-bag-8883411" role="img" aria-hidden="false">
              <title id="your-bag-8883411">
                <?php echo _LANG['cart']; ?>
              </title>
              <path
                d="M20.677 13.654a5.23 5.23 0 0 0 1.073-3.194c-.01-2.632-1.968-4.78-4.5-5.137V5.25a5.25 5.25 0 0 0-10.5 0v.059a5.224 5.224 0 0 0-2.444 1.014 5.23 5.23 0 0 0-.983 7.33A5.623 5.623 0 0 0 6.375 24h11.25a5.623 5.623 0 0 0 3.052-10.346zM12 1.5a3.75 3.75 0 0 1 3.75 3.75h-7.5A3.75 3.75 0 0 1 12 1.5zm5.625 21H6.375a4.122 4.122 0 0 1-1.554-7.942.75.75 0 0 0 .214-1.256A3.697 3.697 0 0 1 3.75 10.5a3.755 3.755 0 0 1 3-3.674V9a.75.75 0 0 0 1.5 0V6.75h7.5V9a.75.75 0 1 0 1.5 0V6.826a3.755 3.755 0 0 1 3 3.674c0 1.076-.47 2.1-1.285 2.802a.75.75 0 0 0 .213 1.256 4.122 4.122 0 0 1-1.553 7.942z">
              </path>
            </svg>
            <div class="d-grid">
              <a href="#" class="btn btn-dark my-3">
                <?php echo _LANG['enter_to_basket']; ?>
              </a>
            </div>
          </div>
          <!-- end cart small -->
          <div class="d-flex">
            <button id="addToCart" class="btn btn-lg btn-dark w-100 my-2 rounded-0 me-2">
              <?php echo _LANG['add_to_basket']; ?>
            </button>
            <button id="btnWishlist" value="<?php echo get_product_info($item)->id; ?>" type="button" class="btn btn-outline-dark my-2 rounded-0 btn-heart dislike fs-4"><i
                class="fa-regular fa-heart" aria-hidden="true"></i></button>
          </div>
          <!-- delivery -->
          <ul class="border border-1 rounded-0 p-0 my-4">
            <li class="border-bottom d-flex justify-content-between align-items-start py-3">
              <div class="ps-2 pe-auto">
                <h6 class="mt-2">
                  <?php echo _LANG['tanjameh_shipping_note1']; ?>
                </h6>
              </div>
            </li>
            <li class="border-bottom d-flex justify-content-between align-items-start py-3">
              <div class="ms-2 me-auto">
                <i class="fa-solid fa-truck"></i>
                <div class="fw-bold">
                  <?php echo _LANG['25_working_days']; ?>
                </div>
                <?php echo _LANG['standard_delivery']; ?>
              </div>
              <span class="me-2">
                <?php echo (get_product_info($item)->shipping_price); ?>
              </span>
            </li>
            <li class="border-bottom d-flex justify-content-between align-items-start py-3">
              <div class="ms-2 me-auto">
                <div class="fw-bold">
                  <svg class="zds-icon RC794g X9n9TI DlJ4rT _5Yd-hZ RkQYXx pVrzNP H3jvU7" height="1.5em" width="1.5em"
                    focusable="false" fill="currentColor" viewBox="0 0 24 24" aria-labelledby="box-transit-23640"
                    role="img" aria-hidden="false">
                    <title id="box-transit-23640">box-transit</title>
                    <path
                      d="m16.5 14.5-4.2-1.9c-.2-.1-.4-.1-.6 0l-4.2 1.9V6.9l2-5.6h5l2 5.9v7.3zM9 7.3v4.9l2.1-.9c.6-.3 1.2-.3 1.8 0l2.1.9V7.3l-1.6-4.5h-2.9L9 7.3z">
                    </path>
                    <path
                      d="M20.5 22.8h-17c-1.2 0-2.2-1-2.2-2.2V19c0-.4.3-.8.8-.8s.8.3.8.8v1.5c0 .4.3.8.8.8h17c.4 0 .8-.3.8-.8V7.3c0-.1 0-.2-.1-.3l-1.5-3.8c-.1-.3-.4-.5-.7-.5H5c-.3 0-.6.2-.7.5L2.8 7c0 .1-.1.2-.1.3V10c0 .4-.3.8-.8.8s-.7-.4-.7-.8V7.3c0-.3.1-.6.2-.8l1.5-3.8c.4-.9 1.2-1.5 2.1-1.5h14c.9 0 1.7.6 2.1 1.4l1.5 3.8c.1.3.2.5.2.8v13.2c0 1.3-1.1 2.4-2.3 2.4z">
                    </path>
                    <path
                      d="M2 7h20v1.5H2zM4.8 13.8h-4c-.5 0-.8-.4-.8-.8s.3-.8.8-.8h4c.4 0 .8.3.8.8s-.4.8-.8.8zM4.8 16.8h-4c-.5 0-.8-.4-.8-.8s.3-.8.8-.8h4c.4 0 .8.3.8.8-.1.4-.4.8-.8.8z">
                    </path>
                  </svg>
                  <span class="ms-2">
                    <?php echo _LANG['approximate_weight']; ?>
                    <?php echo (get_product_info($item)->shipping_weight); ?>
                  </span>
                </div>
              </div>
            </li>
          </ul>
          <!-- accordion description -->
          <div class="accordion accordion-flush" id="accordionDescription">
            <div class="accordion-item">
              <h2 class="accordion-header" id="flush-headingOne">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                  data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                  <?php echo _LANG['care']; ?>
                </button>
              </h2>
              <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne">
                <div class="accordion-body">
                  <ul class="list-unstyled">
                    <li><strong>
                        <?php echo (get_product_info($item)->careInfo); ?>
                      </strong> </li>

                  </ul>
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="flush-headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                  data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                  <?php echo _LANG['details']; ?>
                </button>
              </h2>
              <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo">
                <div class="accordion-body">
                  <ul class="list-unstyled">
                    <li><strong>
                        <?php echo (get_product_info($item)->aboutMe); ?>
                      </strong> </li>
                      <li><strong><br>
                      <?php echo ("کد محصول  : "); ?><?php echo ($item); ?>
                      </strong> </li>

                  </ul>
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="flush-headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                  data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                  <?php echo _LANG['size_and_fit']; ?>
                </button>
              </h2>
              <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree">
                <div class="accordion-body">
                  <ul class="list-unstyled">
                    <li><strong>
                        <?php echo (get_product_info($item)->sizeAndFit); ?>
                      </strong> </li>
                  </ul>
                  <!-- Button trigger modal -->
                  <button type="button" class="btn btn-dark rounded-0" data-bs-toggle="modal"
                    data-bs-target="#sizeGuidModal">
                    راهنمای اندازه
                  </button>

                  <!-- Modal -->
                  <div class="modal fade" id="sizeGuidModal" tabindex="-1" aria-labelledby="sizeGuidModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable">
                      <div class="modal-content rounded-0">
                        <div class="modal-header">
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body px-4">
                          <h4 class="fw-semibold">راهنمای اندازه</h4>
                          <p>
                            با راهنمای تبدیل مفید ما، اندازه خود را در کشورهای مختلف بیابید. بهتر است از این به عنوان یک
                            قاعده کلی استفاده کنید، زیرا اندازه ها و اندازه ها می تواند از برندی به برند دیگر متفاوت باشد.
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
                          <h6 class="mb-4">نوار اندازه گیری را زیر بغل خود بیاورید و کامل ترین قسمت سینه خود را اندازه
                            بگیرید</h6>
                          <h6 class="fw-semibold m-0">کمر</h6>
                          <h6 class="mb-4">نوار اندازه گیری را دور کمر طبیعی خود بیاورید و بین بالاترین قسمت استخوان لگن و
                            دنده های پایینی خود اندازه بگیرید.</h6>
                          <h6 class="fw-semibold m-0">Hip</h6>
                          <h6 class="mb-4">نوار اندازه گیری را دور باسن خود بیاورید و کامل ترین قسمت پایین بدن خود را
                            اندازه بگیرید</h6>
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
            <div class="bg-light"><a
                href="?brand=<?php echo get_product_info($item)->brand_name; ?>&id=<?php echo get_product_info($item)->brand_id; ?>"
                class="text-decoration-none text-dark d-block product-brand"><?php echo get_product_info($item)->brand_name; ?></a></div>
            <div class="bg-light ms-auto">
              <button
                class="btn border-1 rounded-0 btn-outline-dark m-auto d-flex align-items-center clike-follow notfollow"><i
                  class="fa-solid fa-plus me-2"></i><span>
                  <?php echo _LANG['follow']; ?>
                </span></button>
            </div>
          </div>
          <!-- reviews -->
        </div>
      </div>
    </div>
  </div>
<?php } ?>