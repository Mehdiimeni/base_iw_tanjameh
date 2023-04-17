<?php
//CardHolder.php

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

    <!-- iCheck -->
    <link href="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- Datatables -->
    <link href="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/datatables.net-bs/css/dataTables.bootstrap.min.css"
          rel="stylesheet">
    <link href="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css"
          rel="stylesheet">
    <link href="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css"
          rel="stylesheet">
    <link href="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css"
          rel="stylesheet">
    <link href="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css"
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
                <div class="navbar nav_title" style="border: 0;">
                    <a href="./" class="site_title">
                        <span><?php echo FA_LC["iwadmin_page_title"]; ?></span></a>
                </div>

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


                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">

                                <small><?php echo @$strPageDescription ?></small>

                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                           aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li>
                                                <a href="<?php echo $objGlobalVar->setGetVar('list', 'export', array('act')); ?>"><?php echo FA_LC["list_export_mode"]; ?></a>
                                            </li>
                                            <li>
                                                <a href="<?php echo $objGlobalVar->setGetVar('list', 'extend', array('act')); ?>"><?php echo FA_LC["list_extend_mode"]; ?></a>
                                            </li>
                                            <li>
                                                <a href="<?php echo $objGlobalVar->setGetVar('list', 'normal', array('act')); ?>"><?php echo FA_LC["list_normal_mode"]; ?></a>
                                            </li>
                                        </ul>
                                    </li>

                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <?php (new FileCaller)->FileIncluderWithControler(IW_PANEL_FROM_PANEL . 'admin/', 'GlobalPage', 'ListTableType'); ?>
                                <thead>
                                <?php echo $strListHead; ?>
                                </thead>
                                <tbody>
                                <?php echo $strListBody; ?>
                                </tbody>
                                </table>
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

<!-- iCheck -->
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/iCheck/icheck.min.js"></script>
<!-- Datatables -->
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/jszip/dist/jszip.min.js"></script>
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/pdfmake/build/pdfmake.min.js"></script>
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/pdfmake/build/vfs_fonts.js"></script>

<!-- Custom Theme Scripts -->
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>build/js/custom.min.js"></script>


</body>
</html>


