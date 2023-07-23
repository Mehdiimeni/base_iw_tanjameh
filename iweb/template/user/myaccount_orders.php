<?php
///template/user/myaccount_orders.php
?>

<!-- side right -->
<div class="col-12 col-lg-9">
  <div>
    <h2 class="mt-4 fw-bold">سفارشات</h2>
  </div>
  <div class="my-4">
    <div class="d-sm-flex align-items-sm-center justify-content-sm-between">
      <div class="col-10 col-sm-8 col-md-6">
        <select class="form-select form-select-lg rounded-0 border-dark">
          <option>۶ ماه گذشته</option>
        </select>
      </div>
      <a href="?user=myaccount" class="btn btn-dark btn-lg rounded-0 w-25 d-none d-md-block">بازگشت</a>
    </div>
  </div>
  <!-- order -->
  <ol class="list-unstyled">
    <li>
      <h2>این ماه</h2>
      <hr>
      <?php if (all_user_order()) {
        foreach (all_user_order() as $user_order) { ?>
          <div class="my-4 d-sm-flex justify-content-sm-between mb-3 mb-sm-0">
            <h4 class="fw-bold">شماره سفارش:<span>
                <?php echo $user_order->id; ?>
              </span></h4>
            <a href="?user=myaccount-order-detail" class="text-decoration-none text-mediumpurple">مشاهده سفارش</a>
          </div>
          <dl class="my-4">
            <div class="d-inline-block me-4">
              <dt>تاریخ سفارش</dt>
              <dd>
                <?php echo $user_order->last_modify; ?>
              </dd>
            </div>
            <div class="d-inline-block me-4">
              <dt>جمع</dt>
              <dd>
                <?php echo $user_order->payment_amount; ?> -
                <?php echo $user_order->currency_name; ?>
              </dd>
            </div>
            <div class="d-inline-block me-4">
              <dt>وضعیت </dt>
              <dd>
                <?php echo $user_order->status_name; ?>
              </dd>
            </div>
          </dl>
          <div class="my-4 d-block d-sm-flex align-items-start">
            <div class="me-0 me-sm-3">
              <h6>
                <?php echo $user_order->address_name; ?>
              </h6>
              <h6 class="fw-bold">
                <?php echo $user_order->address; ?>
              </h6>
              <h6 class="fw-bold">
                <?php echo $user_order->post_code; ?>
              </h6>

            </div>
          </div>
        <?php }
      } ?>
    </li>
  </ol>
</div>
</div>
</div>