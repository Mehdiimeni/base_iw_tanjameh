<?php
///template/look/look_creator.php
if (look_creator_info($_GET['look'])) {
  $look_id = $_GET['look'];

  ?>
  <div class="container-md">
    <h3 class="fw-semibold mt-3 mt-md-4 mb-4">خلاقیت های لباس من</h3>
    <div class="row row-cols-1 row-cols-md-3">
      <?php foreach(look_creator_info($look_id) as $post_look){ ?>
      <div class="col">
        <div class="position-relative mb-3">
          <div class="position-absolute top-0 z-1 mt-2">
            <!-- add class like or dislike -->
            <button type="button" class="btn btn-light rounded-0 btn-heart dislike lh-1 p-2 fs-5"><i
                class="fa-regular fa-heart" aria-hidden="true"></i></button>
          </div>
          <a href="./?look=<?php echo($look_id); ?>&name=<?php echo($_GET['name']); ?>&post=<?php echo($post_look->post_id); ?>" class="text-decoration-none">
            <div class=" text-dark rounded-0 border-0 bg-transparent placeholder-glow">
              <div class="position-relative pt-144 bg-dark-subtle w-100 placeholder">
                <img class="card-img rounded-0 position-absolute top-0 lazy-image"
                  data-src='<?php echo($post_look->images_address); ?>' alt="<?php echo($post_look->look_page_name); ?>">
              </div>
            </div>
          </a>
        </div>
      </div>
      <?php } ?>

    </div>
    <!-- Feeling inspired -->
  <?php } ?>