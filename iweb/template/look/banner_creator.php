<?php
///template/look/banner_creator.php
if(banner_creator_info($_GET['look'])){
    $look_id = $_GET['look'];
?>
<div class=" text-dark" style="background-color: <?php echo banner_creator_info($look_id)->look_page_color; ?>">
    <div class="container-md">
        <div class="row pt-5" style="height: 294px;">
            <div class="col-12 col-md-4">
                <div class="hstack gap-3 align-items-center placeholder-glow">
                    <div class="width-70 height-70 object-fit-cover placeholder">
                        <img class="lazy-image rounded-0 w-100" data-src='<?php echo banner_creator_info($look_id)->look_page_profile; ?>' alt="">
                    </div>
                    <div>
                        <h4 class="m-0 text-truncate fw-bold"><?php echo banner_creator_info($look_id)->look_page_name; ?></h4>
                        <p class="text-truncate m-0"><?php echo banner_creator_info($look_id)->count_look; ?> لباس</p>
                    </div>
                </div>
                <h6 class="mt-4">
                <?php echo banner_creator_info($look_id)->look_page_description; ?>
                </h6>
            </div>
            <div class="col-12 offset-md-1 col-md-7">
                <div class="creator-cover w-100 h-100" style="background-image: url(<?php echo banner_creator_info($look_id)->look_page_banner; ?>);">
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>