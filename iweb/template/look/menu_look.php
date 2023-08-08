<?php
///template/user/menu_look.php
?>
<div class="container-lg pt-4">
  <div class="row">
    <!-- side left -->
    <div class="col-12 col-lg-3 b-animate b-dark brand-cat lh-lg">
      <ul class="list-unstyled d-flex d-lg-block scroll-y-nowrap">
        <li>
          <span class="d-none d-lg-block text-dark-900 fw-bold">حساب شما</span>
          <ul class="list-unstyled ms-0 ms-lg-2">
            <li class="list-active d-inline-block d-lg-block b-purple">
              <a href="?user=myaccount" class="text-decoration-none text-mediumpurple d-inline-block d-lg-block">بررسی
                اجمالی</a>
            </li>
          </ul>
        </li>
        <li>
          <span class="d-none d-lg-block text-dark-900 fw-bold">لوک</span>
          <ul class="list-unstyled ms-0 ms-lg-2">
            <?php if (!is_look_reg_doc()->stat) { ?>
              <li class="list-active d-inline-block d-lg-block">
                <a href="?user=look_user"
                  class="text-decoration-none text-dark-emphasis d-inline-block d-lg-block">اطلاعات من</a>
              </li>
            <?php } else { ?>
              <li class="list-active d-inline-block d-lg-block">
                <a href="?user=look_page" class="text-decoration-none text-dark-emphasis d-inline-block d-lg-block">صفحه
                  من</a>
              </li>
              <li class="list-active d-inline-block d-lg-block">
                <a href="?user=look_post" class="text-decoration-none text-dark-emphasis d-inline-block d-lg-block">پست
                  های من</a>
              </li>
            <?php } ?>
          </ul>
        </li>

        <li>
          <span class="d-none d-lg-block text-dark-900 fw-bold">پیام ها</span>
          <ul class="list-unstyled ms-0 ms-lg-2">
            <li class="list-active d-inline-block d-lg-block">
              <a href="#" class="text-decoration-none text-dark-emphasis d-inline-block d-lg-block">پیام های من</a>
            </li>
          </ul>
        </li>
        <li>
          <span class="d-none d-lg-block text-dark-900 fw-bold">حسابداری</span>
          <ul class="list-unstyled ms-0 ms-lg-2">
            <li class="list-active d-inline-block d-lg-block">
              <a href="#" class="text-decoration-none text-dark-emphasis d-inline-block d-lg-block">در آمد من</a>
            </li>
          </ul>
        </li>
      </ul>
      <hr class="d-lg-none">
    </div>