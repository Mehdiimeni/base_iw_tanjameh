<?php
///template/GlobalPage/FooterContent.php
?>

<div id="PImageModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="PImageModalLabel" aria-hidden="true">
    <div class="iw-img-modal">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img  style="width: 100% !important;height: auto " src="#"/>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo FA_LC["close"]; ?></button>
            </div>
        </div>
    </div>
</div>
<footer class="hidden-print">
    <div class="pull-left">
        <a href="mailto:<?php echo FA_LC["iwadmin_page_email"]; ?>"><?php echo FA_LC["iwadmin_page_description"]; ?></a>
    </div>
    <div class="clearfix"></div>
</footer>
