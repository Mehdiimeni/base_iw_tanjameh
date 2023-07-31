<?php
///template/user/cart.php
if (!empty(get_cart_info())) {
  ?>
  <div class="container-md basket">
    <div class="basket-exists row bg-gainsboro-light px-md-3 pb-3">
      <div class="col-12 col-md-8 p-0">
        <!-- items -->
        <div class="bg-white mt-3 p-3">
          <ul class="p-0">
            <!-- items product -->
            <?php foreach ((array) get_cart_info() as $product) { ?>
              <form method="post" action="">
                <li class="product hstack gap-3 align-items-start li-item border-bottom border-secondary-subtle py-3">
                  <div class="product-image">
                    <img src='<?php echo $product->images_address; ?>' width="86" alt="">
                  </div>
                  <div class="w-100">
                    <div class="d-block d-sm-flex">
                      <div>
                        <a href="<?php echo ($product->product_page_url); ?>"
                          class="product-details d-inline-block text-decoration-none text-dark">
                          <div class="product-brand lh-sm">
                            <?php echo ($product->name); ?>
                          </div>
                          <div class="product-title text-body-secondary">
                            <?php echo ($product->product_type); ?>
                          </div>
                        </a>
                        <p class="text-body-secondary m-0">رنگ: <span>
                            <?php echo ($product->colour); ?>
                          </span></p>
                        <p class="text-body-secondary">اندازه: <span>
                            <?php echo ($product->size); ?>
                          </span></p>
                      </div>
                      <div class="product-quantity d-inline-block ms-sm-auto mb-3 mb-sm-0">
                        <?php if ($product->sizeOrder > 0) { ?>
                          <select id="mySelect" name="<?php echo ($product->product_id); ?>"
                            class="form-select rounded-0 border-dark-subtle width-87">
                            <?php for ($counter = 1; $counter < $product->sizeOrder; $counter++) {
                              $product->qty == $counter ? $selected = "selected" : $selected = "";

                              ?>
                              <option <?php echo $selected; ?> data-product-id="<?php echo ($product->product_id); ?>"
                                data-product-price="<?php echo ($product->price); ?>" value="<?php echo ($counter); ?>">
                                <?php echo ($counter); ?></option>
                            <?php } ?>
                          </select>
                        <?php } else { ?>
                          <div class="fw-semibold ms-auto d-inline-block text-danger">اتمام کالا</div>
                        <?php } ?>
                      </div>
                    </div>
                    <div class="d-block d-sm-flex align-items-start">
                      <div class="d-flex font-x-s align-items-center">
                        <div class="product-removal">
                          <a href='?user=cart&delitem=<?php echo ($product->product_id); ?>&cartid=<?php echo ($product->cart_id); ?>'
                            class='remove-product d-flex align-items-center text-decoration-none text-body-tertiary'>
                            <i class="fa-regular fa-trash-can me-2"></i>
                            <span>حذف مورد</span>
                          </a>
                        </div>
                      </div>
                      <div class="d-inline-block ms-sm-auto my-3 my-sm-0">
                        <?php if ($product->sizeOrder > 0) { ?>
                          <div class="product-price" hidden>
                            <?php echo ($product->price); ?>
                          </div>
                          <?php if ($product->discount_persent) { ?>
                            <del class="me-2">
                              <?php echo ($product->old_price); ?>
                            </del>
                          <?php } ?>
                          <div class="product-line-price fw-semibold ms-auto d-inline-block text-danger">
                            <?php echo ($product->price); ?>
                          </div>&nbsp;<span class="text-danger">
                            <?php echo ($product->name_currency); ?>
                          </span>
                          <?php if ($product->discount_persent) { ?>
                            <p class="font-x-s text-danger">شما
                              <?php echo ($product->discount_persent); ?>% پس انداز می کنید
                            </p>
                          <?php }
                        } ?>
                      </div>
                    </div>
                  </div>
                </li>
              <?php } ?>
          </ul>
          <!-- notice -->
          <p class="text-primary-emphasis font-x-s opacity-75 d-flex align-items-baseline gap-2 my-3">
            <i class="fa fa-info-circle"></i>
            <span>اقلام قرار داده شده در این کیف رزرو نمی شود.</span>
          </p>
        </div>
        <!-- delivery -->
        <div class="bg-white mt-3 p-3">
          <h4 class="fw-bold mb-4">تحویل تخمینی</h4>
          <p>25 روز کاری</p>
        </div>
        <!-- accept -->
        <div class="bg-white mt-3 p-3">
          <h4 class="fw-bold mb-4">ما می پذیریم</h4>
          <ul class="hstack gap-2 list-unstyled">
            <li>

              <img class="rounded-2" src="./itemplates/iweb/media/sep.jpg" alt="">

            </li>
            <li>


              <img class="rounded-2" src="./itemplates/iweb/media/shaparak.jpg" alt="">

            </li>
            <li>
              <svg xmlns="http://www.w3.org/2000/svg" width="48" height="32" viewBox="0 0 48 32" aria-hidden="true">
                <g fill="none">
                  <path fill="#FFF"
                    d="M4 1.333h40c1.467 0 2.667 1.2 2.667 2.667v24c0 1.467-1.2 2.667-2.667 2.667H4A2.675 2.675 0 0 1 1.333 28V4c0-1.467 1.2-2.667 2.667-2.667z">
                  </path>
                  <path fill="#DDD"
                    d="M44 1.333c1.467 0 2.667 1.2 2.667 2.667v24c0 1.467-1.2 2.667-2.667 2.667H4A2.675 2.675 0 0 1 1.333 28V4c0-1.467 1.2-2.667 2.667-2.667h40zM44 0H4C1.733 0 0 1.733 0 4v24c0 2.267 1.733 4 4 4h40c2.267 0 4-1.733 4-4V4c0-2.267-1.733-4-4-4z">
                  </path>
                  <path fill="#253B80"
                    d="M18.533 13.467H16.4a.287.287 0 0 0-.267.266l-.8 5.334c0 .133 0 .266.134.266h.933a.287.287 0 0 0 .267-.266l.266-1.467c0-.133.134-.267.267-.267h.667c1.333 0 2.133-.666 2.4-2 .133-.533 0-1.066-.267-1.333-.133-.4-.667-.533-1.467-.533zm.267 2c-.133.8-.667.8-1.2.8h-.267l.267-1.334c0-.133.133-.133.133-.133h.134c.4 0 .666 0 .933.267 0-.134.133.133 0 .4zm6-.134h-.933c-.134 0-.134 0-.134.134v.266L23.6 15.6c-.267-.267-.667-.4-1.2-.4-1.067 0-2 .8-2.267 2-.133.533 0 1.2.4 1.467.267.4.8.533 1.2.533.934 0 1.334-.533 1.334-.533v.266c0 .134 0 .267.133.267h.933a.287.287 0 0 0 .267-.267l.533-3.466s0-.134-.133-.134zm-1.333 2c-.134.534-.534.934-1.067.934-.267 0-.533-.134-.667-.267-.133-.133-.266-.4-.133-.667.133-.533.533-.933 1.067-.933.266 0 .533.133.666.267.134.133.134.4.134.666zm6.666-2h-1.066c-.134 0-.134 0-.267.134l-1.333 2-.534-2a.287.287 0 0 0-.266-.267h-.934c-.133 0-.266.133-.133.267l1.067 3.2-1.067 1.466c-.133.134 0 .267.133.267h.934c.133 0 .133 0 .266-.133l3.334-4.8c.133.133 0-.134-.134-.134z">
                  </path>
                  <path fill="#179BD7"
                    d="M33.467 13.467h-2.134a.287.287 0 0 0-.266.266l-.8 5.334c0 .133 0 .266.133.266h1.067c.133 0 .133-.133.133-.133l.267-1.467c0-.133.133-.266.266-.266h.667c1.333 0 2.133-.667 2.4-2 .133-.534 0-1.067-.267-1.334-.266-.533-.8-.666-1.466-.666zm.133 2c-.133.8-.667.8-1.2.8h-.267l.267-1.334c0-.133.133-.133.133-.133h.134c.4 0 .666 0 .933.267.133-.134.133.133 0 .4zm6-.134h-.933c-.134 0-.134 0-.134.134v.266L38.4 15.6c-.267-.267-.667-.4-1.2-.4-1.067 0-2 .8-2.267 2-.133.533 0 1.2.4 1.467.267.4.8.533 1.2.533.934 0 1.334-.533 1.334-.533v.266c0 .134 0 .267.133.267h.933a.287.287 0 0 0 .267-.267l.533-3.466c.134 0 0-.134-.133-.134zm-1.333 2c-.134.534-.534.934-1.067.934-.267 0-.533-.134-.667-.267-.133-.133-.266-.4-.133-.667.133-.533.533-.933 1.067-.933.266 0 .533.133.666.267.134.133.134.4.134.666zM40.8 13.6l-.8 5.467c0 .133 0 .266.133.266h.8a.287.287 0 0 0 .267-.266l.8-5.334c0-.133 0-.266-.133-.266h-.934s-.133 0-.133.133z">
                  </path>
                  <path fill="#253B80"
                    d="m6.8 20.267.133-1.067H4.8L6 11.733h2.8c.933 0 1.6.134 2 .534.133.133.267.4.267.533V13.867L11.2 14c.133.133.267.133.267.267.4.133.533.4.533.533v.8c-.133.4-.133.667-.4.933-.133.267-.267.4-.533.667-.267.133-.4.267-.8.4-.267.133-.534.133-.934.133H9.2c-.133 0-.267 0-.4.134-.133.133-.267.266-.267.4v.133l-.266 1.733c-.134.134-1.467.134-1.467.134z">
                  </path>
                  <path fill="#179BD7"
                    d="M11.6 13.733v.134C11.2 15.733 10 16.4 8.267 16.4h-.934c-.266 0-.4.133-.4.4l-.4 2.667-.133.8c0 .133.133.266.267.266h1.466c.134 0 .267-.133.4-.266v-.134L8.8 18.4v-.133c0-.134.133-.267.4-.267h.133c1.467 0 2.534-.533 2.934-2.267.133-.666 0-1.333-.267-1.733-.133-.133-.267-.133-.4-.267z">
                  </path>
                  <path fill="#222D65"
                    d="M11.2 13.6H7.733c-.133 0-.133.133-.133.267l-.533 3.066v.134c0-.134.266-.4.4-.4h.8c1.6 0 2.933-.667 3.333-2.534V14c-.133-.267-.267-.4-.4-.4z">
                  </path>
                  <path fill="#253B80"
                    d="M7.467 13.733c0-.133.133-.266.133-.266h3.6c.133 0 .267.133.267.133.133-.667 0-1.2-.4-1.6-.267-.4-1.067-.533-2.134-.533h-2.8c-.266 0-.4.133-.4.4l-1.2 7.466c0 .134.134.267.267.267h1.733l.4-2.8.534-3.067z">
                  </path>
                </g>
              </svg>
            </li>
          </ul>
        </div>
      </div>
      <div class="col-12 col-md-4 mt-3 ps-md-3 p-0">
        <div class="sticky-top">
          <div class="totals bg-white p-3">
            <!-- notice -->
            <p class="text-primary-emphasis bg-body-secondary font-x-s p-3 d-flex align-items-baseline gap-2 my-3">
              <i class="fa fa-info-circle"></i>
              <span> وزن بسته بندی هرکدام 2 کیلو می باشند </span>
            </p>
            <!-- total 
            <div class="d-flex align-items-baseline mb-3">
              <h3 class="fw-bold">جمع</h3>
              <p class="font-x-s ms-auto">(قیمت بر حسب تومان میباشد)</p>
            </div>
            <div class="totals-item d-flex mb-3">
              <label>جمع فرعی</label>
              <div class="totals-value ms-auto" id="cart-subtotal">25.98</div>
            </div>
            <div class="totals-item d-flex mb-3">
              <label>ارزش افزوده (9%)</label>
              <div class="totals-value ms-auto" id="cart-tax">1.30</div>
            </div>
            <div class="totals-item d-flex mb-3">
              <label>تحویل</label>
              <div class="totals-value ms-auto" id="cart-shipping">15.00</div>
            </div>
            <div class="summary-promo mb-3 d-none">
              <label>تخفیف</label>
              <div class="promo-value final-value ms-auto" id="basket-promo"></div>
            </div>
            <div class="totals-item totals-item-total d-flex fw-semibold border-top border-secondary-subtle py-2">
              <label>کل (با احتساب مالیات بر ارزش افزوده)</label>
              <div class="totals-value ms-auto" id="cart-total">42.28</div>
            </div>
                      -->
            <button type="submit" name="SubmitM" value="A"
              class="checkout my-3 w-100 btn text-white btn-next border-0 rounded-0 bg-orange fw-semibold">رفتن به صفحه
              پرداخت</button>
          </div>
          <!-- promotion code -->
          <div class="accordion accordion-flush bg-white p-3 mt-3" id="promoFlushExample">
            <div class="accordion-item">
              <h2 class="accordion-header" id="flush-headingOne">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                  data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                  افزودن کوپن (اختیاری)
                </button>
              </h2>
              <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne"
                data-bs-parent="#promoFlushExample">
                <div class="accordion-body">
                  <label for="promo-code">وارد نمودن کد تخفیف</label>
                  <input id="promo-code" type="text" name="promo-code" maxlength="5" class="promo-code-field form-control"
                    placeholder="10off">
                  <button class="promo-code-cta btn btn-white border-orange text-orange w-100 rounded-0 mt-3"
                    style="display: none;">اعمال</button>
                  <p class="result-promo-code font-x-s text-orange mt-1"></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- show this when basket is null -->
    <div class="basket-null row bg-gainsboro-light px-md-3 pb-3" style="display: none;">
      <div class="bg-white text-center p-3 mt-3">
        <svg xmlns="http://www.w3.org/2000/svg" width="276px" height="160px" viewBox="0 0 120 160">
          <g style="isolation:isolate">
            <g id="Layer_2" data-name="Layer 2">
              <g id="Layer_1-2" data-name="Layer 1">
                <polygon
                  points="86.097 135.121 9.013 135.121 1.458 57.873 12.888 42.869 82.222 42.869 93.653 57.873 86.097 135.121"
                  fill="#fff"></polygon>
                <path
                  d="M86.65033,133.49211h-73.089c-.99267,0-2.65646-.34923-3.57771,0-.86546.32809.10958-.8397.41348.93616a5.141,5.141,0,0,1-.12068-1.234c.46644-4.50938-.97629-9.98275-1.41591-14.47787L4.31292,72.21646c-.42887-4.38525-.24176-9.39881-1.33674-13.6684-.0924-.36029.01173-.80091-.11258-1.15119.395,1.11305-1.35429,1.75644.00719.70931C5.43256,56.13588,7.5,52.0294,9.45661,49.46089l2.98618-3.92c1.23479-1.62092,1.66354-1.18-.08967-1.0428,1.10216-.08626,2.246,0,3.35037,0h61.101a22.18579,22.18579,0,0,1,4.40719,0c.98432.21721-.44746-.43878.03177-.13093.93753.60226,1.79695,2.35848,2.46406,3.23406l6.68207,8.77017c.64733.84962,1.409,1.68354,1.97425,2.59119.16781.26946-.04505-1.56414-.1524-.28037-2.13876,25.57788-5.00008,51.11384-7.499,76.65948-.22291,2.27872,2.59773,1.30843,2.76889-.44118L93.24872,75.9424,94.60565,62.071c.16269-1.66316.8003-3.89652.18181-5.49186-.54041-1.39395-2.25035-2.95357-3.14042-4.12178l-5.67151-7.44381c-1.65372-2.17049-2.081-3.543-4.64106-3.77348-9.74821-.87764-19.9828,0-29.76458,0H17.78048c-1.80977,0-4.202-.47183-5.7129.61822-1.19611.86295-2.26341,2.9712-3.1399,4.12178L3.25711,53.42392C1.76021,55.38892.15072,56.816.14524,59.29534c-.007,3.17723.6345,6.48784.94339,9.64629L7.622,135.747c.04036.41272.34119,1.0031.83732,1.0031h77.084C87.13749,136.75009,88.39021,133.49211,86.65033,133.49211Z"
                  fill="#424242"></path>
                <line x1="28.40545" y1="57.1719" x2="28.40545" y2="43.8574" fill="none" stroke="#cfd8d8"
                  stroke-linecap="round" stroke-linejoin="round" stroke-width="4.5986" style="mix-blend-mode:multiply">
                </line>
                <line x1="66.70625" y1="43.8574" x2="66.70625" y2="57.1719" fill="none" stroke="#cfd8d8"
                  stroke-linecap="round" stroke-linejoin="round" stroke-width="4.5986" style="mix-blend-mode:multiply">
                </line>
                <line x1="93.65345" y1="57.873" x2="1.56945" y2="57.873" fill="#fff"></line>
                <path
                  d="M93.72517,56.16957H1.64118c-1.9962,0-2.31944,3.40685-.14345,3.40685h92.084c1.9962,0,2.31944-3.40685.14345-3.40685Z"
                  fill="#424242"></path>
                <path
                  d="M23.66536,63.851c0-6.17471-.50026-12.454,2.28643-18.18536A23.6134,23.6134,0,0,1,49.47727,32.89331a24.66238,24.66238,0,0,1,20.17685,15.07c2.2893,5.664,1.79222,11.76083,1.79222,17.73848,0,3.20243,4.219.57288,4.219-1.85076,0-7.77034.30017-15.235-3.73417-22.23287A27.71543,27.71543,0,0,0,46.465,27.888,29.01157,29.01157,0,0,0,22.61019,43.73639c-3.54214,6.99445-3.16385,14.37816-3.16385,21.96539,0,3.20243,4.219.57288,4.219-1.85076Z"
                  fill="#424242"></path>
                <line x1="47.61055" y1="14.7305" x2="47.61055" y2="2" fill="none" stroke="#424242" stroke-linecap="round"
                  stroke-linejoin="round" stroke-width="4"></line>
                <line x1="26.61835" y1="20.1621" x2="20.41515" y2="9.0469" fill="none" stroke="#424242"
                  stroke-linecap="round" stroke-linejoin="round" stroke-width="4"></line>
                <line x1="36.91325" y1="16.0664" x2="33.75305" y2="3.7344" fill="none" stroke="#424242"
                  stroke-linecap="round" stroke-linejoin="round" stroke-width="4"></line>
                <line x1="68.60466" y1="20.1621" x2="74.80775" y2="9.0469" fill="none" stroke="#424242"
                  stroke-linecap="round" stroke-linejoin="round" stroke-width="4"></line>
                <line x1="58.30975" y1="16.0664" x2="61.46985" y2="3.7344" fill="none" stroke="#424242"
                  stroke-linecap="round" stroke-linejoin="round" stroke-width="4"></line>
                <path
                  d="M61.45235,91.2266a35.31194,35.31194,0,0,0-9.59969-7.9278l-.01751-.0078A35.26745,35.26745,0,0,0,40.171,78.9414c-2.2129-.3594-3.2715.0566-3.7519.3359-.48049.2774-1.3711.9844-2.168,3.0821a35.28305,35.28305,0,0,0-2.06449,12.2754v.0195a35.28305,35.28305,0,0,0,2.06449,12.2754c.7969,2.0976,1.68751,2.8047,2.168,3.082.4804.2793,1.539.6953,3.7519.336a35.2234,35.2234,0,0,0,11.6641-4.3497l.01751-.0078a35.31,35.31,0,0,0,9.59969-7.9277c1.416-1.7383,1.5839-2.8613,1.5839-3.418s-.1679-1.6797-1.5839-3.4179"
                  fill="#ff6900" stroke="#ff6900" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"
                  style="mix-blend-mode:multiply"></path>
              </g>
            </g>
          </g>
        </svg>
        <h5 class="fw-bold my-3">برو آن را با تمام امیدها و رویاهای مد خود پر کن.</h5>
        <a href="#"
          class="my-3 col-10 col-sm-5 col-md-3 btn text-white btn-next border-0 rounded-0 bg-orange fw-semibold">رفتن به
          فروشگاه</a>
      </div>
    </div>
  </div>
  </form>
<?php } ?>