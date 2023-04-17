<?php
//UserTradeModify.php

include IW_ASSETS_FROM_PANEL . "include/PageUnity.php";
?>
<!DOCTYPE html>
<?php echo $objIpanelViewUnity->tagHtmlPart(); ?>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="fontiran.com:license" content="Y68A9">
    <?php echo $objIpanelViewUnity->tagFavicon(FA_LC["theme_color"], FA_LC["tile_color"]); ?>
    <?php echo $objIpanelViewUnity->tagTitlePart(); ?>

    <!-- Bootstrap -->
    <link href="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php if ($objInitTools->getLanguageDirection() == 'rtl') { ?>
        <link href="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/bootstrap-rtl/dist/css/bootstrap-rtl.min.css"
              rel="stylesheet">
    <?php } ?>
    <!-- Font Awesome -->
    <link href="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/font-awesome/css/font-awesome.min.css"
          rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- bootstrap-progressbar -->
    <link href="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css"
          rel="stylesheet">
    <!-- iCheck -->
    <link href="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/bootstrap-daterangepicker/daterangepicker.css"
          rel="stylesheet">

    <!-- bootstrap-wysiwyg -->
    <link href="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/google-code-prettify/bin/prettify.min.css"
          rel="stylesheet">
    <!-- Select2 -->
    <link href="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/select2/dist/css/select2.min.css" rel="stylesheet">
    <!-- Switchery -->
    <link href="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/switchery/dist/switchery.min.css" rel="stylesheet">
    <!-- starrr -->
    <link href="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/starrr/dist/starrr.css" rel="stylesheet">
    <link href="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/multi-select-master/css/multi-select.css"
          rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>build/css/custom.min.css" rel="stylesheet">
</head>
<!-- /header content -->
<body class="nav-md">
<div class="container body">
    <div class="main_container">
        <div class="col-md-3 left_col hidden-print">
            <div class="left_col scroll-view">
                <?php (new FileCaller)->FileIncluderWithControler(IW_PANEL_FROM_PANEL . 'admin/', 'GlobalPage', 'PanelPageTitle'); ?>

                <div class="clearfix"></div>

                <!-- menu profile quick info -->
                <?php (new FileCaller)->FileIncluderWithControler(IW_PANEL_FROM_PANEL . 'admin/', 'GlobalPage', 'MenuProfileQuickInfo'); ?>

                <!-- /menu profile quick info -->

                <br/>

                <!-- sidebar menu -->
                <?php (new FileCaller)->FileIncluderWithControler(IW_PANEL_FROM_PANEL . 'admin/', 'GlobalPage', 'SiderbarMenu'); ?>
                <!-- /sidebar menu -->

                <!-- /menu footer buttons -->
                <?php (new FileCaller)->FileIncluderWithControler(IW_PANEL_FROM_PANEL . 'admin/', 'GlobalPage', 'MenuFooterButtons'); ?>

                <!-- /menu footer buttons -->
            </div>
        </div>

        <!-- top navigation -->
        <?php (new FileCaller)->FileIncluderWithControler(IW_PANEL_FROM_PANEL . 'admin/', 'GlobalPage', 'TopNavigation'); ?>
        <!-- /top navigation -->
        <!-- /header content -->

        <!-- page content -->
        <div class="right_col" role="main">
            <div class="">
                <?php (new FileCaller)->FileIncluderWithControler(IW_PANEL_FROM_PANEL . 'admin/', 'GlobalPage', 'PageTitleTop'); ?>
                <div class="clearfix"></div>

                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2><?php echo $strModifyTitle; ?>
                                </h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <br/>
                                <form class="form-horizontal form-label-left input_mask" method="post" action="">

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo FA_LC["group_name"]; ?>
                                            <span class="required">*</span>
                                        </label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <select name="GroupIdKey" class="form-control"  required="required">
                                                <?php echo $strGroupIdKey; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo FA_LC["accessibility_settings"]; ?>
                                            <span class="required">*</span>
                                        </label>

                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <p><?php echo FA_LC["click_section_select"] ?></p>
                                            <select id='optgroup' multiple='multiple' name="AllTrade[]">
                                                <?php echo $strAllTrade; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="ln_solid"></div>
                                    <?php if (@$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJsonNoSet())->modify != 'view') { ?>
                                        <div class="form-group">
                                            <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                                                <button type="submit" name="SubmitM" value="A"
                                                        class="btn btn-success"><?php echo FA_LC["send"]; ?></button>
                                                <button type="reset"
                                                        class="btn btn-primary"><?php echo FA_LC["cancel"]; ?></button>
                                            </div>
                                        </div>
                                    <?php } ?>

                                </form>
                            </div>
                        </div>


                    </div>


                </div>

            </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <?php (new FileCaller)->FileIncluderWithControler(IW_PANEL_FROM_PANEL . 'admin/', 'GlobalPage', 'FooterContent'); ?>
        <!-- /footer content -->
    </div>
</div>
<?php (new FileCaller)->FileIncluderWithControler(IW_PANEL_FROM_PANEL . 'admin/', 'GlobalPage', 'LockScreen'); ?>
<!-- jQuery -->
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/fastclick/lib/fastclick.js"></script>
<!-- NProgress -->
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/nprogress/nprogress.js"></script>
<!-- bootstrap-progressbar -->
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
<!-- iCheck -->
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/iCheck/icheck.min.js"></script>

<!-- bootstrap-daterangepicker -->
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/moment/min/moment.min.js"></script>

<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

<!-- bootstrap-wysiwyg -->
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/google-code-prettify/src/prettify.js"></script>
<!-- jQuery Tags Input -->
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
<!-- Switchery -->
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/switchery/dist/switchery.min.js"></script>
<!-- Select2 -->
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/select2/dist/js/select2.full.min.js"></script>
<!-- Parsley -->
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/parsleyjs/dist/parsley.min.js"></script>
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/parsleyjs/dist/i18n/fa.js"></script>
<!-- Autosize -->
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/autosize/dist/autosize.min.js"></script>
<!-- jQuery autocomplete -->
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
<!-- starrr -->
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/starrr/dist/starrr.js"></script>

<!-- Custom Theme Scripts -->
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>build/js/custom.min.js"></script>
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/multi-select-master/js/jquery.multi-select.js"></script>
<script type="text/javascript">
    $('#optgroup').multiSelect({selectableOptgroup: true});

</script>
</body>
</html>






