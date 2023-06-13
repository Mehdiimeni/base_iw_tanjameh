<?php
///template/global/top.php

?>
<!-- scroll back to top -->
<a id="back-to-top" href="#" class="btn btn-dark btn-sm rounded-0 back-to-top" role="button"><i
    class="fa-solid fa-chevron-up"></i><span class="d-none d-md-block"> برو بالا</span></a>
<!-- top bar -->
<div class="bg-body-secondary d-none d-lg-flex position-relative">
  <div class="container d-flex font-x-s">
    <a href="mailto:<?php  echo (@get_website_data()[0]->email); ?>"
      class="p-1 flex-fill text-muted text-decoration-none fw-semibold"><?php echo (_LANG['email']); ?></a>
    <a href="tel:<?php echo (@get_website_data()[0]->main_phone); ?>"
      class="p-1 text-center flex-fill text-muted text-decoration-none fw-semibold"><?php echo (_LANG['main_phone_contact']); ?></a>
    <a href="./contact_us" class="p-1 text-end flex-fill text-muted text-decoration-none fw-semibold">
      <?php echo (_LANG['contact_us']); ?>
    </a>
  </div>
</div>
<!-- alert top web view -->
<div class="alert fade show rounded-0 position-absolute top-0 w-100 p-0 bg-orange d-none d-md-block" role="alert">
  <div class="container text-center text-truncate">
    <a href="#" class="text-decoration-none text-white font-x-s">
      <?php echo (@get_website_alert('top')[0]->alert_content); ?>
    </a>
    <button type="button" class="btn-close btn-close-white p-0 float-end mt-1" data-bs-dismiss="alert"
      aria-label="Close"></button>
  </div>
</div>
<!-- alert top mobile view -->
<div class="alert fade show rounded-0 top-0 w-100 p-0 bg-orange d-md-none" role="alert">
  <div class="container text-center text-truncate">
    <a href="#" class="text-decoration-none text-white font-x-s">
      <?php echo (@get_website_alert('top_mobile')[0]->alert_content); ?>
    </a>
    <button type="button" class="btn-close btn-close-white p-0 float-end mt-1" data-bs-dismiss="alert"
      aria-label="Close"></button>
  </div>
</div>