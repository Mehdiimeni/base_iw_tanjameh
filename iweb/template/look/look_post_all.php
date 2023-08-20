<?php
///template/look/look_post_all.php

if (isset($_POST['look_post'])) {
    $user_look_result = @user_look_post($_FILES, $_POST);
    if ($user_look_result->stat) {


        switch ($user_look_result->stat_detials) {
            case '20':
                JavaTools::JsAlertWithRefresh(_LANG['user_look_post_add'], 0, './?user=myaccount_look');
                break;

        }

    } else {

        switch ($user_look_result->stat_detials) {
            case '12':
                echo "<script>alert('" . _LANG['user_look_form_null'] . "');</script>";
                break;

            case '13':
                echo "<script>alert('" . _LANG['user_look_error_exist'] . "');</script>";
                break;

            case '14':
                echo "<script>alert('" . _LANG['enter_format_file_error'] . "');</script>";
                break;

            case '15':
                echo "<script>alert('" . _LANG['enter_size_file_error'] . "');</script>";
                break;
        }

    }


}
?>
<!-- side right -->
<div class="col-12 col-lg-9">
  <div>
    <h3 class="fw-bold mb-0">پست ها</h3>
    <h6 class="mb-4">پست های خود را در اینجا   مدیریت کنید.</h6>
    <!-- Add Addresses -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-3">
      <!-- add new address -->

      <?php foreach(look_creator_all() as $post_look){ ?>
        <div class="col">
          <div class="p-4 border border-1">


            <ol class="list-unstyled mb-5">
              <li>
              <img class="rounded-0 "
                  src='<?php echo($post_look->images_address); ?>' alt="<?php echo($post_look->user_id); ?>">
                  <?php if(!empty(is_look_reg_post($post_look->post_id)->admin_comment)){?>

                (پیام مدیر)

            <?php } ?>
              </li>
              
              
            </ol>


            <div class="hstack gap-2">
              <button class="btn btn-outline-dark fw-bold btn-lg border-2 rounded-0" data-bs-toggle="modal"
                data-bs-target="#removeAddressModal"><i class="fa-regular fa-trash-can"></i></button>
              <button
                class="btn btn-lg w-100 btn-outline-dark rounded-0 border-2 d-flex justify-content-center align-items-center"
                data-bs-toggle="modal" data-bs-target="#editAddressModal"><i
                  class="fa fa-pen me-2"></i><span>ویرایش</span></button>
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
                  <form class="needs-validation" method="post" action="" enctype="multipart/form-data" novalidate>
        <input name="post_id" value="" type="hidden">
        <div class="my-5 col-12 col-sm-9 col-md-9 col-lg-9 m-auto">
            <div class="mb-4 b-animate b-purple">
                <h2 class="fw-bold">ویرایش </h2>
            </div>
            <?php if(!empty(is_look_reg_post($post_look->post_id)->admin_comment)){?>
            <div class="mb-4 w-100">
                <label for="personalNumber" class="form-label m-0 p-1 border border-bottom-0 border-dark">
                    <span>  توضیحات مدیر لطفا به موارد دقت کامل داشته باشید </span>
                </label>
                <div class="input-group position-relative">
                <textarea readonly  class="form-control" rows="3"><?php echo is_look_reg_post($post_look->post_id)->admin_comment; ?></textarea>
      
                    
                </div>
            </div>
            <?php } ?>
            <div class="mb-4">
                <label for="personalFamily" class="form-label m-0 p-1 border border-bottom-0 border-dark">تصویر اول
                </label>
                <div class="input-group">
                    <input type="file" name="image1" class="form-control form-control-lg fs-6 rounded-0 border-dark"
                        id="personalFamily" required>
                    <div class="invalid-feedback">
                        تصویر اول
                    </div>
                    <button type="button" class="btn p-0 d-inline-block position-absolute end-0 top-0 m-2 mt-3"
                        data-bs-toggle="modal" data-bs-target="#LookPostFirstImage">
                        <i class="fa fa-info-circle fs-5"></i>
                    </button>
                </div>
            </div>
            <div class="mb-4">
                <label for="personalFamily" class="form-label m-0 p-1 border border-bottom-0 border-dark">تصویر دوم
                </label>
                <div class="input-group">
                    <input type="file" name="image2" class="form-control form-control-lg fs-6 rounded-0 border-dark"
                        id="personalFamily" required>
                    <div class="invalid-feedback">
                        تصویر دوم
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <label for="personalFamily" class="form-label m-0 p-1 border border-bottom-0 border-dark">تصویر سوم
                </label>
                <div class="input-group">
                    <input type="file" name="image3" class="form-control form-control-lg fs-6 rounded-0 border-dark"
                        id="personalFamily" required>
                    <div class="invalid-feedback">
                        تصویر سوم
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <label for="personalFamily" class="form-label m-0 p-1 border border-bottom-0 border-dark">تصویر چهارم
                </label>
                <div class="input-group">
                    <input type="file" name="image4" class="form-control form-control-lg fs-6 rounded-0 border-dark"
                        id="personalFamily">
                    <div class="invalid-feedback">
                        تصویر چهارم
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <label for="personalFamily" class="form-label m-0 p-1 border border-bottom-0 border-dark">آیتم اول
                </label>
                <div class="input-group">
                    <select name="itemm1" class="form-select form-select-lg rounded-0 border-dark selectpicker"
                        data-live-search="true" id="AddTitle">
                        <option value="" selected></option>
                        <?php foreach (user_look_item() as $item1) { ?>
                            <option data-tokens="<?php echo ($item1->product_name); ?>"
                                value="<?php echo ($item1->product_id); ?>"><?php echo ($item1->product_name); ?>
                            </option>
                        <?php } ?>
                    </select>
                    یا مشابه
                    <input name="iteml1" type="text" class="form-control form-control-lg fs-6 rounded-0 border-dark"
                        id="AddZipcode" required>
                    <div class="invalid-feedback">
                        آیتم اول
                    </div>
                    <button type="button" class="btn p-0 d-inline-block position-absolute end-0 top-0 m-2 mt-3"
                        data-bs-toggle="modal" data-bs-target="#LookPostItem">
                        <i class="fa fa-info-circle fs-5"></i>
                    </button>
                </div>
            </div>
            <div class="mb-4">
                <label for="personalFamily" class="form-label m-0 p-1 border border-bottom-0 border-dark">آیتم دوم
                </label>
                <div class="input-group">
                    <select name="itemm2" class="form-select form-select-lg rounded-0 border-dark selectpicker"
                        data-live-search="true" id="AddTitle">
                        <option value="" selected></option>
                        <?php foreach (user_look_item() as $item2) { ?>
                            <option data-tokens="<?php echo ($item2->product_name); ?>"
                                value="<?php echo ($item2->product_id); ?>"><?php echo ($item2->product_name); ?>
                            </option>
                        <?php } ?>
                    </select>
                    یا مشابه
                    <input name="iteml2" type="text" class="form-control form-control-lg fs-6 rounded-0 border-dark"
                        id="AddZipcode" required>
                    <div class="invalid-feedback">
                        آیتم دوم
                    </div>
                    <button type="button" class="btn p-0 d-inline-block position-absolute end-0 top-0 m-2 mt-3"
                        data-bs-toggle="modal" data-bs-target="#LookPostItem">
                        <i class="fa fa-info-circle fs-5"></i>
                    </button>
                </div>
            </div>
            <div class="mb-4">
                <label for="personalFamily" class="form-label m-0 p-1 border border-bottom-0 border-dark">آیتم سوم
                </label>
                <div class="input-group">
                    <select name="itemm3" class="form-select form-select-lg rounded-0 border-dark selectpicker"
                        data-live-search="true" id="AddTitle">
                        <option value="" selected></option>
                        <?php foreach (user_look_item() as $item3) { ?>
                            <option data-tokens="<?php echo ($item3->product_name); ?>"
                                value="<?php echo ($item3->product_id); ?>"><?php echo ($item3->product_name); ?>
                            </option>
                        <?php } ?>
                    </select>
                    یا مشابه
                    <input name="iteml3" type="text" class="form-control form-control-lg fs-6 rounded-0 border-dark"
                        id="AddZipcode" required>
                    <div class="invalid-feedback">
                        آیتم سوم
                    </div>
                    <button type="button" class="btn p-0 d-inline-block position-absolute end-0 top-0 m-2 mt-3"
                        data-bs-toggle="modal" data-bs-target="#LookPostItem">
                        <i class="fa fa-info-circle fs-5"></i>
                    </button>
                </div>
            </div>
            <div class="mb-4">
                <label for="personalFamily" class="form-label m-0 p-1 border border-bottom-0 border-dark">آیتم چهارم
                </label>
                <div class="input-group">
                    <select name="itemm4" class="form-select form-select-lg rounded-0 border-dark selectpicker"
                        data-live-search="true" id="AddTitle">
                        <option value="" selected></option>
                        <?php foreach (user_look_item() as $item4) { ?>
                            <option data-tokens="<?php echo ($item4->product_name); ?>"
                                value="<?php echo ($item4->product_id); ?>"><?php echo ($item4->product_name); ?>
                            </option>
                        <?php } ?>
                    </select>
                    یا مشابه
                    <input name="iteml4" type="text" class="form-control form-control-lg fs-6 rounded-0 border-dark"
                        id="AddZipcode" required>
                    <div class="invalid-feedback">
                        آیتم چهارم
                    </div>
                    <button type="button" class="btn p-0 d-inline-block position-absolute end-0 top-0 m-2 mt-3"
                        data-bs-toggle="modal" data-bs-target="#LookPostItem">
                        <i class="fa fa-info-circle fs-5"></i>
                    </button>
                </div>
            </div>
            <div class="mb-4">
                <label for="personalFamily" class="form-label m-0 p-1 border border-bottom-0 border-dark"> دسته بندی
                </label>
                <div class="input-group">
                    <select name="look_gender" class=" form-select form-select-lg rounded-0 border-dark">
                        <option value="men">مردانه</option>
                        <option value="women">زنانه</option>
                    </select>

                    <div class="invalid-feedback">
                        دسته بندی
                    </div>

                </div>
            </div>

            <div class="mb-4">
                <label for="personalFamily" class="form-label m-0 p-1 border border-bottom-0 border-dark"> دسته بندی
                </label>
                <div class="input-group">
                    <select name="look_group" 
                        class=" form-select form-select-lg rounded-0 border-dark">
                        <?php foreach (get_look_group() as $group) { ?>
                            <option value="<?php echo ($group->id); ?>"><?php echo ($group->name); ?></option>
                        <?php } ?>
                    </select>

                    <div class="invalid-feedback">
                        گروه
                    </div>

                </div>
            </div>
            <div class="modal fade" id="LookPostFirstImage" tabindex="-1" aria-labelledby="LookPostFirstImageLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-sm modal-dialog-centered">
                    <div class="modal-content rounded-0">
                        <div class="modal-header border-0">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            این تصویر به عنوان تصویر اصلی ذخیره میشود
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="LookPostItem" tabindex="-1" aria-labelledby="LookPostItemLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-sm modal-dialog-centered">
                    <div class="modal-content rounded-0">
                        <div class="modal-header border-0">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            انتخاب از محصولات خریداری شده به عنوان آیتم اصلی و اضافه کردن کد محصول ( داخل جزییات صفحه هر
                            محصول )به عنوان کالای مشابه
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" name="look_post" value="1"
                class="btn btn-dark btn-lg fw-bold fs-6 py-3 rounded-0 d-flex align-items-center">
                <i class="fa-regular fa-envelope me-2 fs-4"></i>
                <span>ثبت پست جدید</span>
            </button>

        </div>

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