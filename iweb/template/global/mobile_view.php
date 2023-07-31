<?php
///template/global/mobile_view.php
?>

<div class="offcanvas offcanvas-start cat-offcanvas" tabindex="-1" id="offcanvasHome"
  aria-labelledby="offcanvasHomeLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasHomeLabel">تن جامه</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <hr class="m-0">
  <div class="offcanvas-body p-0 overflow-y-scroll overflow-x-hidden">
    <nav>
      <div class="nav nav-pills nav-justified" id="nav-tab" role="tablist">
        <?php if (get_nav()) {
          $int_tab = 1;
          foreach (get_nav() as $Nav) {

            $int_tab == 1 ? $active = 'active' : $active = '';

            ?>
            <button class="nav-link <?php echo ($active); ?>  text-black-50 rounded-0" id="nav-tab-<?php echo $int_tab ?>"
              data-bs-toggle="tab" data-bs-target="#nav-<?php echo $int_tab ?>" type="button" role="tab"
              aria-controls="nav-<?php echo $int_tab ?>" aria-selected="true"><?php echo @$Nav->LocalName ?></button>
            <div class="vr"></div>
            <?php $int_tab++;
          }
        } ?>

      </div>
    </nav>
    <div class="tab-content shadow-sm" id="nav-tabContent">
      <?php
      if (get_nav()) {
        $int_tab = 1;
        foreach (get_nav() as $Nav) {

          $int_tab == 1 ? $active = 'show active' : $active = '';
          ?>
          <div class="tab-pane fade <?php echo ($active); ?> " id="nav-<?php echo $int_tab ?>" role="tabpanel"
            aria-labelledby="nav-tab-<?php echo $int_tab ?>" tabindex="0">
            <div class="col-6">
              <?php



              if (get_menu(@$Nav->Name)) {

                foreach (get_menu(@$Nav->Name) as $Category) { ?>
                  <div class="row g-2">


                    <div class="card rounded-0 border-0">
                      <a href="./?gender=<?php echo @$Nav->Name ?>&category=<?php echo @$Category->Name ?>"
                        class="text-dark text-decoration-none">
                        <div class="card-body">
                          <p class="card-text">
                            <?php echo @$Category->LocalName ?>
                          </p>
                        </div>
                      </a>
                    </div>
                  </div>

                  <?php

                }
              }
              ?>
            </div>

          </div>
          <?php $int_tab++;
        }
      } ?>
    </div>
    <div class="bg-body-secondary py-3">
      <?php if (get_user_acl()) { ?>
        <div class="card py-2 px-4 shadow-sm rounded-0">
          <a href="?user=myaccount" class="fs-5 text-decoration-none text-dark">
            <span class="">صفحه کاربری</span>
            <i class="fa-solid fa-arrow-left float-end"></i>
          </a>
        </div>
        <div class="card py-2 px-4 shadow-sm rounded-0">
          <a href="?user=cart" class="fs-5 text-decoration-none text-dark">
            <span class="">سفارشاتم</span>
            <i class="fa-solid fa-arrow-left float-end"></i>
          </a>
        </div>
        <div class="card py-2 px-4 shadow-sm mt-3 rounded-0">
          <a href="?user=exit" class="fs-5 text-decoration-none text-dark">
            <span class="">خروج</span>
          </a>
        </div>
      <?php } ?>
      <?php if (!get_user_acl()) { ?>
        <div class="card py-2 px-4 shadow-sm rounded-0">
          <a href="?user=login" class="fs-5 text-decoration-none text-dark">
            <span class="">ورود</span>
            <i class="fa-solid fa-arrow-left float-end"></i>
          </a>
        </div>
        <div class="card py-2 px-4 shadow-sm rounded-0">
          <a href="?user=login" class="fs-5 text-decoration-none text-dark">
            <span class="">عضویت</span>
            <i class="fa-solid fa-arrow-left float-end"></i>
          </a>
        </div>
      <?php } ?>
    </div>
  </div>
</div>