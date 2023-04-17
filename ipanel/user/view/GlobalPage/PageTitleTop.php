<?php
//PageTitleTop.php
?>
<div class="page-title">
    <div class="title_left">
        <h3><?php echo $stdPart->PartName; ?>
            <small><?php echo $stdPage->PageName; ?></small>
        </h3>
    </div>

    <div class="title_right">
        <div class="col-md-3 col-sm-3 col-xs-12 form-group pull-right ">

            <?php if ($strModify != null  ) {
                echo (new ListTools())->ButtonReflector($arrToolsIcon["list"]);
            }elseif($blModify) {
                echo (new ListTools())->ButtonReflector($arrToolsIcon["add"]);
            } ?>

        </div>
    </div>
</div>
