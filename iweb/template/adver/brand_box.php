<?php
///template/adver/brand_box.php
if (get_brand(@$_SESSION['gender'])) {
  ?>
  <div class="container-md my-5">
    <h4 class="h4 fw-semibold">
      <?php echo $gender_title; ?>
    </h4>
    <div class="row row-cols-md-4 row-cols-2 mt-4 lh-lg text-truncate b-animate b-dark">
      <?php $counter = 0;
      if (get_brand($_SESSION['gender'])) {
        foreach (get_brand($_SESSION['gender']) as $Brand) {
          if ($counter == 0 or $counter % 4 == 0) { ?>
            <div class="col">
            <?php } ?>
        <a class="nav-link" href="?brand=<?php echo $Brand->name; ?>&id=<?php echo $Brand->id; ?>">
          <?php echo $Brand->name; ?>
        </a>
        <?php if ($counter == 0 or $counter % 4 == 0) { ?>
          </div>
        <?php } ?>

    <?php }
      } //?>
    </div>
  </div>
<?php } ?>