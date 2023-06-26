<?php
///template/adver/title_adver_1.php
$position_order = 1;
if (get_title_adver_data($_SESSION['page_name_system'], $position_order)) {
    ?>
    <!-- baner -->
    <div class="row  text-dark mt-3 pt-0 pt-md-4 ps-4 ps-md-0 position-relative placeholder-glow"
        style="background-color: <?php echo (@get_title_adver_data($_SESSION['page_name_system'], $position_order)[0]->main_color); ?>;">
        <div class="col-12 col-md-6 py-3">
            <h3 class="fw-semibold">
                <?php echo (@get_title_adver_data($_SESSION['page_name_system'], $position_order)[0]->title); ?>
            </h3>
            <h4 class="mb-4">
                <?php echo (@get_title_adver_data($_SESSION['page_name_system'], $position_order)[0]->content); ?>
            </h4>
            <a href="<?php echo (@get_title_adver_data($_SESSION['page_name_system'], $position_order)[0]->bottom_link); ?>"
                class="text-decoration-none text-dark fw-semibold stretched-link"> <?php echo (@get_title_adver_data($_SESSION['page_name_system'], $position_order)[0]->bottom_caption); ?> <i
                    class="fa-solid fa-arrow-left"></i></a>
        </div>
        <div class="col-12 col-md-6 card p-0 rounded-0 border-0">
            <div class="position-relative pt-48 bg-dark-subtle placeholder">
                <img class="lazy-image position-absolute top-0 w-100"
                    data-src="./irepository/img/adver_banner/<?php echo (@get_title_adver_data($_SESSION['page_name_system'], $position_order)[0]->image); ?>"
                    alt="<?php echo (@get_title_adver_data($_SESSION['page_name_system'], $position_order)[0]->title); ?>">
            </div>
        </div>
    </div>
<?php } ?>
</div>
</div>
</div>