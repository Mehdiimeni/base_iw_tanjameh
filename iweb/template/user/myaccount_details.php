<?php
///template/user/myaccount_details.php
?>

    <!-- side right -->
    <div class="col-12 col-lg-9">
      <div>
        <h3 class="fw-bold mb-0">جزئیات شخصی</h3>
        <h6>جزئیات خود را در اینجا مشاهده و به روز کنید. گزینه های ورود و رمز عبور خود را در اینجا مدیریت کنید.</h6>
        <!-- Personal details -->
      <div class="d-block d-md-flex justify-content-md-between align-items-md-center my-5">
        <div>
          <div class="hstack gap-5 align-items-start">
            <div>
              <svg class="zds-icon RC794g X9n9TI DlJ4rT _5Yd-hZ _7BKUw3 FxZV-M pVrzNP" height="2em" width="2em" focusable="false" fill="currentColor" viewBox="0 0 24 24" aria-labelledby="avatar-a-54193" role="img" aria-hidden="false"><title id="avatar-a-54193">avatar-a</title><path d="M21.645 22.866a28.717 28.717 0 0 0-6.46-7.817c-2.322-1.892-4.048-1.892-6.37 0a28.74 28.74 0 0 0-6.46 7.817.75.75 0 0 0 1.294.76 27.264 27.264 0 0 1 6.113-7.413A3.98 3.98 0 0 1 12 15.125a3.81 3.81 0 0 1 2.236 1.088 27.252 27.252 0 0 1 6.115 7.412.75.75 0 1 0 1.294-.76zM12 12.002A6.01 6.01 0 0 0 18.003 6 6.003 6.003 0 1 0 12 12.002zm0-10.505a4.502 4.502 0 1 1 0 9.005 4.502 4.502 0 0 1 0-9.005z"></path></svg>
            </div>
            <div class="d-block d-sm-flex gap-sm-5">
            <div>
              <div class="mb-5">
                <h5 class="fw-semibold mb-1">
                  نام
                </h5>
                <h6>Seyed Shirazi</h6>
              </div>
              <div>
                <h5 class="mb-1">
                  پرفرنس مد
                </h5>
                <h6>بدون پرفرنس</h6>
              </div>
            </div>
            <div class="mt-5 mt-sm-0">
              <div class="mb-5">
                <h5 class="fw-semibold mb-1 d-inline-block">
                  شماره موبایل
                </h5>
                <!-- Button Mobile number modal -->
                <button type="button" class="btn p-0" data-bs-toggle="modal" data-bs-target="#MobileNumberModal">
                  <i class="fa fa-info-circle fs-5"></i>
                </button>
                <!-- Modal Mobile number -->
                <div class="modal fade" id="MobileNumberModal" tabindex="-1" aria-labelledby="MobileNumberModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-sm">
                    <div class="modal-content rounded-0">
                      <div class="modal-header border-0">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        ما فقط در صورت لزوم با شما تماس خواهیم گرفت - برای مثال، به‌روزرسانی مهمی در مورد سفارش شما وجود دارد یا به درخواست مراقبت از مشتری شما پاسخ می‌دهیم. و ما هیچ اطلاعات شخصی را با اشخاص ثالث به اشتراک نمی گذاریم، مگر اینکه پیک ما باشد که بسته شما را تحویل می دهد.
                      </div>
                    </div>
                  </div>
                </div>
                <h6>0911111</h6>
              </div>
              <div>
                <h5 class="mb-1">
                  تاریخ تولد
                </h5>
                <h6>23/08/1982</h6>
              </div>
            </div>
          </div>
          </div>
        </div>
        <div class="col-12 col-md-5">
          <button class="btn btn-lg fs-6 fw-bold w-100 btn-outline-dark rounded-0 border-2 d-flex justify-content-center align-items-center" data-bs-toggle="modal" data-bs-target="#personalDetailModal"><i class="fa fa-pen me-2"></i><span>ویرایش</span></button>
          <!-- Modal Personal Detail -->
          <div class="modal fade" id="personalDetailModal" tabindex="-1" aria-labelledby="personalDetailModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-fullscreen-md-down modal-lg">
              <div class="modal-content rounded-0">
                <div class="modal-header">
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form>
                  <div class="col-12 col-md-10 col-lg-7">
                    <h2 class="fw-bold mb-5">بروزرسانی مشخصات من</h2>
                    <div class="mb-4">
                      <label for="personalName" class="form-label m-0 p-1 border border-bottom-0 border-dark">نام</label>
                      <div class="input-group">
                        <input type="text" class="form-control form-control-lg rounded-0 border-dark" id="personalName" required>
                      </div>
                    </div>
                    <div class="mb-4">
                      <label for="personalFamily" class="form-label m-0 p-1 border border-bottom-0 border-dark">نام خانوادگی</label>
                      <div class="input-group">
                        <input type="text" class="form-control form-control-lg rounded-0 border-dark" id="personalFamily" required>
                      </div>
                    </div>
                    <div class="mb-4">
                      <label for="personalBirth" class="form-label m-0 p-1 border border-bottom-0 border-dark">تاریخ تولد</label>
                      <div class="input-group">
                        <input type="date" class="form-control form-control-lg rounded-0 border-dark" id="personalBirth">
                      </div>
                    </div>
                    <div class="mb-4">
                      <h5 class="fw-bold">ترجیهات مد</h5>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="Fashionpreference" id="FashionRadios1" value="option1">
                        <label class="form-check-label fs-5" for="FashionRadios1">
                          مد زنانه
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="Fashionpreference" id="FashionRadios2" value="option2">
                        <label class="form-check-label fs-5" for="FashionRadios2">
                          مد مردانه
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="Fashionpreference" id="FashionRadios3" value="option3" checked>
                        <label class="form-check-label fs-5" for="FashionRadios3">
                          بدون ترجیهات
                        </label>
                      </div>
                    </div>
                    <div>
                      <h5 class="fw-bold">شماره موبایل</h5>
                      <div class="hstack gap-2">
                      <select class="form-select form-select-lg rounded-0 border-dark w-25">
                        <option value="1">ایران(98+)</option>
                      </select>
                      <input type="tel" class="form-control form-control-lg rounded-0 border-dark w-75">
                      </div>
                    </div>
                    </div>
                    <button class="btn btn-lg rounded-0 btn-dark w-100 fs-6 fw-bold my-5">ذخیره</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <hr>
    <!-- Personal email -->
    <div class="d-block d-md-flex justify-content-md-between align-items-md-start my-5">
      <div>
        <div class="hstack gap-5 align-items-start">
          <div>
            <svg class="zds-icon RC794g X9n9TI DlJ4rT _5Yd-hZ _7BKUw3 FxZV-M pVrzNP" height="2em" width="2em" focusable="false" fill="currentColor" viewBox="0 0 24 24" aria-labelledby="email-632277" role="img" aria-hidden="false"><title id="email-632277">email</title><path d="M21 3H3a3.004 3.004 0 0 0-3 3v12a3.004 3.004 0 0 0 3 3h18a3.004 3.004 0 0 0 3-3V6a3.004 3.004 0 0 0-3-3zm0 1.5c.318 0 .597.122.84.291l-8.816 8.229a1.505 1.505 0 0 1-2.048 0L2.16 4.79c.243-.17.522-.29.84-.291h18zm0 15H3c-.828 0-1.5-.672-1.5-1.5V6.225l8.454 7.89A2.988 2.988 0 0 0 12 14.92a2.987 2.987 0 0 0 2.046-.804l8.454-7.89V18c0 .828-.672 1.5-1.5 1.5z"></path></svg>
          </div>
          <div>
            <div class="">
              <h5 class="fw-semibold mb-1">
                ایمیل شما
              </h5>
              <h6>amirh.moein@hotmail.com</h6>
            </div>
        </div>
        </div>
      </div>
      <div class="col-12 col-md-5">
        <button class="btn btn-lg fs-6 fw-bold w-100 btn-outline-dark rounded-0 border-2 d-flex justify-content-center align-items-center" data-bs-toggle="modal" data-bs-target="#personalEmailModal"><i class="fa fa-pen me-2"></i><span>ویرایش</span></button>
        <!-- Modal Personal Email -->
        <div class="modal fade" id="personalEmailModal" tabindex="-1" aria-labelledby="personalEmailModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-scrollable modal-fullscreen-md-down modal-lg">
            <div class="modal-content rounded-0">
              <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form class="form-validation" novalidate>
                  <h2 class="fw-bold ">
                    آدرس ایمیل خود را تغییر دهید
                  </h2>
                  <h6 class="mb-5">
                    ما مطمئن خواهیم شد که همه نامه‌های مهم Tanjameh به آدرس ایمیل جدید شما ارسال می‌شوند.
                  </h6>
                  <h5 class="fw-bold">ایمیل فعلی:</h5>
                  <h6 class="mb-3">amirh.moein@hotmail.com</h6>
                <div class="col-12 col-md-10 col-lg-7">
                  <div class="mb-4">
                    <label for="personalNewEmail" class="form-label m-0 p-1 border border-bottom-0 border-dark">ایمیل جدید</label>
                    <div class="input-group">
                      <input type="email" class="form-control form-control-lg fs-6 rounded-0 border-dark" placeholder="آدرس ایمیل" id="personalNewEmail" required>
                      <div class="invalid-feedback">
                        لطفا ایمیل جدید را وارد نمایید
                      </div>
                    </div>
                  </div>
                  <div class="mb-4">
                    <label for="personalConfirmNewEmail" class="form-label m-0 p-1 border border-bottom-0 border-dark">نوشتن دوباره ایمیل جدید</label>
                    <div class="input-group">
                      <input type="email" class="form-control form-control-lg fs-6 rounded-0 border-dark" placeholder="آدرس ایمیل" id="personalConfirmNewEmail" required>
                      <div class="invalid-feedback">
                        لطفا ایمیل جدید را وارد نمایید
                      </div>
                    </div>
                  </div>
                  <div>
                  <label for="password" class="form-label m-0 p-1 border border-bottom-0 border-dark">رمز عبور</label>
                  <div class="input-group">
                    <input class="password form-control form-control-lg fs-6 rounded-0 border-dark border-end-0" type="password" name="password" placeholder="رمز عبور" value="" required>
                    <span class="input-group-text bg-white border-dark rounded-0 border-start-0">
                      <i class="fa fa-eye togglePassword" id="" 
                     style="cursor: pointer"></i>
                     </span>
                     <div class="invalid-feedback">
                      لطفا رمز فعلی خود را وارد نمایید
                    </div>
                  </div>
                </div>
                  </div>
                  <button class="btn btn-lg rounded-0 btn-dark w-100 fs-6 fw-bold my-5" onclick="validateForm()">ذخیره</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <hr>
    <!-- Personal password -->
    <div class="d-block d-md-flex justify-content-md-between align-items-md-start my-5">
      <div>
        <div class="hstack gap-5 align-items-start">
          <div>
            <svg class="zds-icon RC794g X9n9TI DlJ4rT _5Yd-hZ _7BKUw3 FxZV-M pVrzNP" height="2em" width="2em" focusable="false" fill="currentColor" viewBox="0 0 24 24" aria-labelledby="lock-closed-632279" role="img" aria-hidden="false"><title id="lock-closed-632279">lock-closed</title><path d="M18.75 7.532V6.75a6.75 6.75 0 1 0-13.5 0v.782A2.994 2.994 0 0 0 2.566 10.5V21a3.004 3.004 0 0 0 3 3h12.868a3.004 3.004 0 0 0 3-3V10.5a2.993 2.993 0 0 0-2.684-2.968zM12 1.5c2.9 0 5.25 2.35 5.25 5.25v.75H6.75v-.75C6.75 3.85 9.1 1.5 12 1.5zM19.934 21c-.001.828-.672 1.5-1.5 1.5H5.566c-.828 0-1.499-.672-1.5-1.5V10.5c.001-.828.672-1.5 1.5-1.5H18.434c.828 0 1.5.672 1.5 1.5V21z"></path><path d="M12 11.999a2.616 2.616 0 0 0-.75 5.128v1.623a.75.75 0 1 0 1.5 0v-1.624a2.62 2.62 0 0 0 1.875-2.502A2.625 2.625 0 0 0 12 11.999zm0 3.75a1.125 1.125 0 1 1 0-2.25 1.125 1.125 0 0 1 0 2.25z"></path></svg>
          </div>
          <div>
            <div class="">
              <h5 class="fw-semibold mb-1">
                رمز عبور شما
              </h5>
              <h6>***************</h6>
            </div>
        </div>
        </div>
      </div>
      <div class="col-12 col-md-5">
        <button class="btn btn-lg fs-6 fw-bold w-100 btn-outline-dark rounded-0 border-2 d-flex justify-content-center align-items-center" data-bs-toggle="modal" data-bs-target="#personalPasswordModal"><i class="fa fa-pen me-2"></i><span>ویرایش</span></button>
        <!-- Modal Personal Email -->
        <div class="modal fade" id="personalPasswordModal" tabindex="-1" aria-labelledby="personalPasswordModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-scrollable modal-fullscreen-md-down modal-lg">
            <div class="modal-content rounded-0">
              <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form class="form-validation" novalidate>
                  <h2 class="fw-bold ">
                    رمزعبور خود را تغییر دهید
                  </h2>
                  <h6 class="mb-5">
                    هرزمان خواستید رمز عبور خود را به روز کنید تا حساب Tanjameh خود را ایمن نگه دارید.
                  </h6>
                <div class="col-12 col-md-10 col-lg-7">
                <div class="mb-4">
                  <label for="password1" class="form-label m-0 p-1 border border-bottom-0 border-dark">رمز عبور فعلی</label>
                  <div class="input-group">
                    <input class="password form-control form-control-lg fs-6 rounded-0 border-dark border-end-0" type="password" id="password1" name="password" placeholder="رمز عبور" required>
                    <span class="input-group-text bg-white border-dark rounded-0 border-start-0">
                      <i class="fa fa-eye togglePassword" 
                     style="cursor: pointer"></i>
                     </span>
                     <div class="invalid-feedback">
                      لطفا رمز فعلی خود را وارد نمایید
                    </div>
                  </div>
                </div>
                <div class="mb-4">
                  <label for="password2" class="form-label m-0 p-1 border border-bottom-0 border-dark">رمز عبور جدید</label>
                  <div class="input-group">
                    <input class="password form-control form-control-lg fs-6 rounded-0 border-dark border-end-0" type="password" id="password2" name="password" placeholder="رمز عبور" required>
                    <span class="input-group-text bg-white border-dark rounded-0 border-start-0">
                      <i class="fa fa-eye togglePassword" 
                     style="cursor: pointer"></i>
                     </span>
                     <div class="invalid-feedback">
                      لطفا رمز جدید را وارد نمایید
                    </div>
                  </div>
                </div>
                <div class="mb-4">
                  <label for="password2" class="form-label m-0 p-1 border border-bottom-0 border-dark">بازنویسی رمز عبور جدید</label>
                  <div class="input-group">
                    <input class="password form-control form-control-lg fs-6 rounded-0 border-dark border-end-0" type="password" id="password2" name="password" placeholder="تایید رمز عبور" required>
                    <span class="input-group-text bg-white border-dark rounded-0 border-start-0">
                      <i class="fa fa-eye togglePassword" 
                     style="cursor: pointer"></i>
                     </span>
                     <div class="invalid-feedback">
                      لطفا رمز جدید را وارد نمایید
                    </div>
                  </div>
                </div>
                  </div>
                  <button class="btn btn-lg rounded-0 btn-dark w-100 fs-6 fw-bold my-5" onclick="validateForm()">ذخیره</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <hr class="mb-5">
  </div>
  </div>
</div>
</div>