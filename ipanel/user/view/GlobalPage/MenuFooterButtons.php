<?php
//MenuFooterButtons.php
?>
<div class="sidebar-footer hidden-small">
    <a data-toggle="tooltip" data-placement="top" title="<?php echo FA_LC["settings"]; ?>">
        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
    </a>
    <a data-toggle="tooltip" data-placement="top" title="<?php echo FA_LC["full_screen"]; ?>" onclick="toggleFullScreen();">
        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
    </a>
    <a data-toggle="tooltip" data-placement="top" title="<?php echo FA_LC["lock"]; ?>" class="lock_btn">
        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
    </a>
    <a data-toggle="tooltip" data-placement="top" title="<?php echo FA_LC["exit"]; ?>" href="<?php echo $objGlobalVar->setGetVar('type', 'usr'); echo $objGlobalVar->setGetVar('act', 'logout'); ?>">
        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
    </a>
</div>
