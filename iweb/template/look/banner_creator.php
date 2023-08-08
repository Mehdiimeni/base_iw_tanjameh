<?php
///template/look/banner_creator.php
if(banner_creator_info($_GET['look'])){
?>
<div class="bg-gold-700 text-dark">
    <div class="container-md">
        <div class="row pt-5" style="height: 294px;">
            <div class="col-12 col-md-4">
                <div class="hstack gap-3 align-items-center placeholder-glow">
                    <div class="width-70 height-70 object-fit-cover placeholder">
                        <img class="lazy-image rounded-0 w-100" data-src='media/outfit/outfit-0.webp' alt="">
                    </div>
                    <div>
                        <h4 class="m-0 text-truncate fw-bold">francescamyer</h4>
                        <p class="text-truncate m-0">۴۰ لباس</p>
                    </div>
                </div>
                <h6 class="mt-4">
                    سلام، من فرانزی هستم - یک یوگی و دانشمند ورزش آلمانی که کنجکاوی زیادی برای زندگی آگاهانه دارد. تعادل
                    ملکه است.
                </h6>
            </div>
            <div class="col-12 offset-md-1 col-md-7">
                <div class="creator-cover w-100 h-100" style="background-image: url(media/creator/creator-cover.webp);">
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>