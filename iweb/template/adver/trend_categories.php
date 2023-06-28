<?php
///template/adver/trend_categories.php
if (get_adver_category(@$_SESSION['gender'])) {
  ?>
  <div class="container-md my-5">
    <h4 class="h4 fw-semibold">
      <?php echo $gender_category_title; ?>
    </h4>
    <div class="row row-cols-md-4 row-cols-2 mt-4 lh-lg text-truncate b-animate b-dark">
      <?php $counter = 0;
      if (get_adver_category($_SESSION['gender'])) {
        foreach (get_adver_category($_SESSION['gender']) as $Category) {
          if ($counter == 0 or $counter % 4 == 0) { ?>
            <div class="col">
            <?php } ?>
        <a class="nav-link" href="?trend=<?php echo $Category->ProductType; ?>">
          <?php echo $Category->ProductType; ?>
        </a>
        <?php if ($counter == 0 or $counter % 4 == 0) { ?>
          </div>
        <?php } ?>

    <?php }
      } // ?>
    </div>
  </div>
<?php } ?>