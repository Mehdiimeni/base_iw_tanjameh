<?php
///template/user/myaccount_addresses.php
if (isset($_POST['addressL'])) {
  $user_address_result = @user_adress($_POST);
  if ($user_address_result->stat) {

    switch ($user_address_result->stat_detials) {
      case '22':
        echo "<script>window.location.href = './?user=myaccount-addresses';</script>";
        break;
    }

  } else {

    switch ($user_address_result->stat_detials) {
      case '14':
        echo "<script>alert('" . _LANG['user_address_form_null'] . "');</script>";
        break;

      case '15':
        echo "<script>alert('" . _LANG['user_address_error_exist'] . "');</script>";
        break;
    }

  }

}
?>
<!-- side right -->
<div class="col-12 col-lg-9">
  <div>
    <h3 class="fw-bold mb-0">آدرس ها</h3>
    <h6 class="mb-4">آدرس‌های خود را در اینجا اضافه یا مدیریت کنید.</h6>
    <!-- Add Addresses -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-3">
      <!-- add new address -->
      <div class="col">
        <div class="h-100 border border-1 p-4">
          <button class="btn fs-5 text-mediumpurple fw-bold w-100 h-100" data-bs-toggle="modal"
            data-bs-target="#addAddressModal"><i class="fa fa-add bg-mediumpurple text-white p-1"></i><br><span>افزودن
              آدرس</span></button>
          <!-- Modal Add Address -->
          <div class="modal fade" id="addAddressModal" tabindex="-1" aria-labelledby="addAddressModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-fullscreen-md-down modal-lg">
              <div class="modal-content rounded-0">
                <div class="modal-header border-0">
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                  <form method="post" action="" novalidate name="from_address">
                    <h2 class="fw-bold mb-4">
                      اضافه کردن آدرس
                    </h2>

                    <div class="mb-4 col-12 col-md-6">
                      <label for="AddZipcode" class="form-label m-0 p-1 border border-bottom-0 border-dark">عنوان
                        *</label>
                      <div class="input-group">
                        <input name="NicName" type="text"
                          class="form-control form-control-lg fs-6 rounded-0 border-dark" id="AddZipcode" required>
                      </div>
                    </div>
                    <div class="mb-4 col-12 col-md-6">
                      <label for="AddTitle" class="form-label m-0 p-1 border border-bottom-0 border-dark">جنسیت
                        *</label>
                      <select name="gender" class="form-select form-select-lg rounded-0 border-dark" id="AddTitle">
                        <option value="men">آقا</option>
                        <option value="women">خانم</option>
                      </select>
                    </div>
                    <div class="d-block d-md-flex gap-md-3">
                      <div class="mb-4 col-12 col-md-6">
                        <label for="AddName" class="form-label m-0 p-1 border border-bottom-0 border-dark">نام *</label>
                        <div class="input-group">
                          <input name="name" type="text" class="form-control form-control-lg fs-6 rounded-0 border-dark"
                            id="AddName" required>
                        </div>
                      </div>
                      <div class="mb-4 col-12 col-md-6 pe-md-3">
                        <label for="AddFamily" class="form-label m-0 p-1 border border-bottom-0 border-dark">نام
                          خانوادگی *</label>
                        <div class="input-group">
                          <input name="family" type="text"
                            class="form-control form-control-lg fs-6 rounded-0 border-dark" id="AddFamily" required>
                        </div>
                      </div>
                    </div>
                    <hr>
                    <div class="mb-3">
                      <h6 class="fw-bold m-0">کشور</h6>
                      <select name="iw_country_id" class="form-select form-select-lg rounded-0 border-dark"
                        id="AddTitle">
                        <?php foreach (get_countreis() as $country) { ?>
                          <option value="<?php echo $country->id; ?>"><?php echo $country->Name; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="mb-4 col-12 col-md-6">
                      <label for="AddZipcode" class="form-label m-0 p-1 border border-bottom-0 border-dark">کد پستی
                        *</label>
                      <div class="input-group">
                        <input name="PostCode" type="text"
                          class="form-control form-control-lg fs-6 rounded-0 border-dark" id="AddZipcode" required>
                      </div>
                    </div>

                    <div class="mb-4 col-12 col-md-6">
                      <label for="OtherTel" class="form-label m-0 p-1 border border-bottom-0 border-dark">شماره
                        اضطراری</label>
                      <div class="input-group">
                        <input name="OtherTel" type="text"
                          class="form-control form-control-lg fs-6 rounded-0 border-dark" id="OtherTel">
                      </div>
                    </div>
                    <div class="mb-4 col-12 col-md-6">
                      <label for="AddCity" class="form-label m-0 p-1 border border-bottom-0 border-dark">شهر *</label>
                      <div class="input-group">
                        <input name="city" type="text" class="form-control form-control-lg fs-6 rounded-0 border-dark"
                          id="AddCity" required>
                      </div>
                    </div>
                    <div class="mb-4 col-12 col-md-6">
                      <label for="AddAddress" class="form-label m-0 p-1 border border-bottom-0 border-dark">آدرس
                        *</label>
                      <div class="input-group">
                        <textarea name="Address" type="text"
                          class="form-control form-control-lg fs-6 rounded-0 border-dark" id="AddAddress"
                          required></textarea>
                      </div>
                    </div>

                    <div class="mb-4 col-12 col-md-6">
                      <label for="AddDescription" class="form-label m-0 p-1 border border-bottom-0 border-dark"> توضیحات
                        اضافه</label>
                      <div class="input-group">
                        <textarea name="Description" type="text"
                          class="form-control form-control-lg fs-6 rounded-0 border-dark"
                          id="AddDescription"></textarea>
                      </div>
                    </div>
                    <div class="form-check mb-4">
                      <input name="is_default" class="form-check-input rounded-0" type="checkbox" value="1"
                        id="checkDelivery">
                      <label class="form-check-label mt-1" for="checkDelivery">
                        آدرس تحویل پیش فرض
                      </label>
                    </div>
                    <button type="submit"  name="addressL"
                      class="btn btn-dark btn-lg fw-bold fs-6 w-100 rounded-0">ذخیره</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- edit adress exists -->
      <?php foreach (get_user_address() as $address) { ?>
        <div class="col">
          <div class="p-4 border border-1">

            <h6 class="fw-bold mb-4">
              <?php echo $address->NicName; ?>
            </h6>
            <h4 class="mb-4">
              <?php echo $address->city; ?>
            </h4>
            <ol class="list-unstyled mb-5">
              <li>
                <?php echo $address->Address; ?>
              </li>
              <li>
                <?php echo $address->PostCode; ?>
              </li>
              <li>
                <?php echo $address->iw_country_id; ?>
              </li>
            </ol>
            <div class="mb-4 text-secondary-emphasis">
              <?php if ($address->is_default) { ?>
                <i class="fa fa-check me-3"></i>

                <span>آدرس تحویل پیش فرض</span>
              <?php } ?>
            </div>

            <div class="hstack gap-2">
              <button class="btn btn-outline-dark fw-bold btn-lg border-2 rounded-0" data-bs-toggle="modal"
                data-bs-target="#removeAddressModal"><i class="fa-regular fa-trash-can"></i></button>
              <button
                class="btn btn-lg w-100 btn-outline-dark rounded-0 border-2 d-flex justify-content-center align-items-center"
                data-bs-toggle="modal" data-bs-target="#editAddressModal"><i
                  class="fa fa-pen me-2"></i><span>ویرایش</span></button>
            </div>

            <!-- Modal Remove Address -->
            <div class="modal fade" id="removeAddressModal" tabindex="-1" aria-labelledby="removeAddressModalLabel"
              aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content rounded-0">
                  <div class="modal-header border-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <h4 class="fw-bold mb-1">آدرس حذف شود؟</h4>
                    <h6 class="mb-4">با حذف این مورد، آن را از آدرس‌های ذخیره‌شده‌تان هنگام تسویه‌حساب حذف می‌کنید.</h6>
                    <h6 class="fw-bold mb-4">
                      <?php echo $address->NicName; ?>
                    </h6>
                    <h4 class="mb-4">
                      <?php echo $address->city; ?>
                    </h4>
                    <ol class="list-unstyled mb-5">
                      <li>
                        <?php echo $address->Address; ?>
                      </li>
                      <li>
                        <?php echo $address->PostCode; ?>
                      </li>
                      <li>
                        <?php echo $address->iw_country_id; ?>
                      </li>
                    </ol>
                    <button type="submit" class="btn btn-dark btn-lg fw-bold fs-6 w-100 rounded-0">حذف</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- Modal Edit Address -->
            <div class="modal fade" id="editAddressModal" tabindex="-1" aria-labelledby="editAddressModalLabel"
              aria-hidden="true">
              <div class="modal-dialog modal-dialog-scrollable modal-fullscreen-md-down modal-lg">
                <div class="modal-content rounded-0">
                  <div class="modal-header border-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body p-4">
                    <form method="post" action="" novalidate name="from_address">
                      <h2 class="fw-bold mb-4">
                        ویرایش کردن آدرس
                      </h2>

                      <div class="mb-4 col-12 col-md-6">
                        <label for="AddZipcode" class="form-label m-0 p-1 border border-bottom-0 border-dark">عنوان
                          *</label>
                        <div class="input-group">
                          <input value="<?php echo $address->NicName; ?>" name="NicName" type="text"
                            class="form-control form-control-lg fs-6 rounded-0 border-dark" id="AddZipcode" required>
                        </div>
                      </div>
                      <div class="mb-4 col-12 col-md-6">
                        <label for="AddTitle" class="form-label m-0 p-1 border border-bottom-0 border-dark">جنسیت
                          *</label>
                        <select name="gender" class="form-select form-select-lg rounded-0 border-dark" id="AddTitle">
                          <option value="men">آقا</option>
                          <option value="women">خانم</option>
                        </select>
                      </div>
                      <div class="d-block d-md-flex gap-md-3">
                        <div class="mb-4 col-12 col-md-6">
                          <label for="AddName" class="form-label m-0 p-1 border border-bottom-0 border-dark">نام *</label>
                          <div class="input-group">
                            <input value="<?php echo $address->name; ?>" name="name" type="text" class="form-control form-control-lg fs-6 rounded-0 border-dark"
                              id="AddName" required>
                          </div>
                        </div>
                        <div class="mb-4 col-12 col-md-6 pe-md-3">
                          <label for="AddFamily" class="form-label m-0 p-1 border border-bottom-0 border-dark">نام
                            خانوادگی *</label>
                          <div class="input-group">
                            <input value="<?php echo $address->family; ?>" name="family" type="text"
                              class="form-control form-control-lg fs-6 rounded-0 border-dark" id="AddFamily" required>
                          </div>
                        </div>
                      </div>
                      <hr>
                      <div class="mb-3">
                        <h6 class="fw-bold m-0">کشور</h6>
                        <select name="iw_country_id" class="form-select form-select-lg rounded-0 border-dark"
                          id="AddTitle">
                          <?php foreach (get_countreis() as $country) { ?>
                            <option value="<?php echo $country->id; ?>"><?php echo $country->Name; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                      <div class="mb-4 col-12 col-md-6">
                        <label for="AddZipcode" class="form-label m-0 p-1 border border-bottom-0 border-dark">کد پستی
                          *</label>
                        <div class="input-group">
                          <input value="<?php echo $address->PostCode; ?>" name="PostCode" type="text"
                            class="form-control form-control-lg fs-6 rounded-0 border-dark" id="AddZipcode" required>
                        </div>
                      </div>

                      <div class="mb-4 col-12 col-md-6">
                        <label for="OtherTel" class="form-label m-0 p-1 border border-bottom-0 border-dark">شماره
                          اضطراری</label>
                        <div class="input-group">
                          <input value="<?php echo $address->OtherTel; ?>" name="OtherTel" type="text"
                            class="form-control form-control-lg fs-6 rounded-0 border-dark" id="OtherTel">
                        </div>
                      </div>
                      <div class="mb-4 col-12 col-md-6">
                        <label for="AddCity" class="form-label m-0 p-1 border border-bottom-0 border-dark">شهر *</label>
                        <div class="input-group">
                          <input value="<?php echo $address->city; ?>" name="city" type="text" class="form-control form-control-lg fs-6 rounded-0 border-dark"
                            id="AddCity" required>
                        </div>
                      </div>
                      <div class="mb-4 col-12 col-md-6">
                        <label for="AddAddress" class="form-label m-0 p-1 border border-bottom-0 border-dark">آدرس
                          *</label>
                        <div class="input-group">
                          <textarea name="Address" type="text"
                            class="form-control form-control-lg fs-6 rounded-0 border-dark" id="AddAddress"
                            required><?php echo $address->Address; ?></textarea>
                        </div>
                      </div>

                      <div class="mb-4 col-12 col-md-6">
                        <label for="AddDescription" class="form-label m-0 p-1 border border-bottom-0 border-dark"> توضیحات
                          اضافه</label>
                        <div class="input-group">
                          <textarea name="Description" type="text"
                            class="form-control form-control-lg fs-6 rounded-0 border-dark"
                            id="AddDescription"><?php echo $address->Description; ?></textarea>
                        </div>
                      </div>
                      <div class="form-check mb-4">
                        <input name="is_default" class="form-check-input rounded-0" type="checkbox" value="1"
                          id="checkDelivery"  <?php if($address->is_default == 1){ echo 'checked';} ?> >
                        <label class="form-check-label mt-1" for="checkDelivery">
                          آدرس تحویل پیش فرض
                        </label>
                      </div>
                      <button type="submit" type="submit" name="addressL"
                        class="btn btn-dark btn-lg fw-bold fs-6 w-100 rounded-0">ذخیره</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</div>
</div>
</div>
<!-- end section -->