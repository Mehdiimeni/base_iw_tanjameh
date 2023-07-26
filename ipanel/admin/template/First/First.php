<?php
///template/First/First.php
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
                    <a href="./" class="site_title"> <span><?php echo FA_LC["iwadmin_page_title"]; ?></span></a>
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
                <div class="row top_tiles">


                    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <a href="?ln=&part=UserBasket&page=AllBasket">
                            <div class="tile-stats">
                                <div class="icon"><i class="fa fa-upload"></i></div>
                                <div class="count"><?php echo($intCartBought); ?></div>
                                <h3>جدید</h3>
                                <p>خریدهای در انتظار تایید</p>
                            </div>
                        </a>
                    </div>
                    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <a href="?ln=&part=UserBasket&page=AllSorting">
                            <div class="tile-stats">
                                <div class="icon"><i class="fa fa-bars"></i></div>
                                <div class="count"><?php echo($intCartSorting); ?></div>
                                <h3> سورتینگ</h3>
                                <p>کالاهای رسیده</p>
                            </div>
                        </a>
                    </div>
                    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <a href="?ln=&part=UserBasket&page=AllPacking">
                            <div class="tile-stats">
                                <div class="icon"><i class="fa fa-dropbox"></i></div>
                                <div class="count"><?php echo($intCartPack); ?></div>
                                <h3>پکینگ</h3>
                                <p>سیستم پکینگ</p>
                            </div>
                        </a>
                    </div>
                    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <a href="?ln=&part=UserBasket&page=Booking">
                            <div class="tile-stats">
                                <div class="icon"><i class="fa fa-paper-plane"></i></div>
                                <div class="count"><?php echo($intCartBooking); ?></div>
                                <h3>بوکینگ</h3>
                                <p>سیستم بوکینگ</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="row top_tiles">
                    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <a href="?ln=&part=UserBasket&page=Dispatch">
                            <div class="tile-stats">
                                <div class="icon"><i class="fa fa-barcode"></i></div>
                                <div class="count"><?php echo($intCartDispatch); ?></div>
                                <h3>دیسپچ</h3>
                                <p>سیستم دیسپچ</p>
                            </div>
                        </a>
                    </div>
                    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <a href="?ln=&part=UserBasket&page=Delivery">
                            <div class="tile-stats">
                                <div class="icon"><i class="fa fa-thumbs-up"></i></div>
                                <div class="count"><?php echo($intCartDelivery); ?></div>
                                <h3>دلیوری</h3>
                                <p>بسته های رسیده</p>
                            </div>
                        </a>
                    </div>
                    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <a href="?ln=&part=UserBasket&page=Claim">
                            <div class="tile-stats">
                                <div class="icon"><i class="fa fa-thumbs-down"></i></div>
                                <div class="count"><?php echo($intCartClaim); ?></div>
                                <h3>Claim</h3>
                                <p>بسته های نرسیده</p>
                            </div>
                        </a>
                    </div>
                    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <a href="?ln=&part=UserBasket&page=PreviousPurchases">
                            <div class="tile-stats">
                                <div class="icon"><i class="fa fa-archive"></i></div>
                                <div class="count"><?php echo($intCartComplete); ?></div>
                                <h3>خریدهای قبلی</h3>
                                <p>بسته های قبلی</p>
                            </div>
                        </a>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>تبدیل ارزها
                                <small>ارزهای موجود</small>
                            </h2>

                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="row"
                                 style="border-bottom: 1px solid #E0E0E0; padding-bottom: 5px; margin-bottom: 5px;">


                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="x_panel">

                                        <div class="x_content">

                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th><?php echo FA_LC["currency1"]; ?></th>
                                                    <th><?php echo FA_LC["currency2"]; ?></th>
                                                    <th><?php echo FA_LC["rate"]; ?></th>
                                                    <th><?php echo FA_LC["last_update"]; ?></th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                <?php echo $strCurrency; ?>


                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>خلاصه هفتگی
                                <small> بازدید از سایت</small>
                            </h2>

                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="row"
                                 style="border-bottom: 1px solid #E0E0E0; padding-bottom: 5px; margin-bottom: 5px;">
                                <div class="col-md-12" style="overflow:hidden;">
                        <span class="sparkline_one" style="height: 160px; padding: 10px 25px;">
                                      <canvas width="200" height="60"
                                              style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                                  </span>
                                    <h4 style="margin:18px">تعداد بازدید در هفته</h4>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="">
                <div class="row top_tiles">
                    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <a href="?ln=&part=Users&page=Users">
                            <div class="tile-stats">
                                <div class="icon"><i class="fa fa-user"></i></div>
                                <div class="count"><?php echo($intCountAllUser); ?></div>
                                <h3> کاربران</h3>
                                <p>کاربران فعال و امتیاز دار</p>
                            </div>
                        </a>
                    </div>
                    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                            <div class="icon"><i class="fa fa-shopping-cart"></i></div>
                            <div class="count"><?php echo($intCountTempCart); ?></div>
                            <h3>سبد خرید</h3>
                            <p>سبد های خرید باز</p>
                        </div>
                    </div>
                    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <a href="?ln=&part=UserAccounting&page=Payments">
                            <div class="tile-stats">
                                <div class="icon"><i class="fa fa-money"></i></div>
                                <div class="count"><?php echo($intCountPaymentState); ?></div>
                                <h3>سندهای پرداختی</h3>
                                <p>تراکنش های بانکی</p>
                            </div>
                        </a>
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
<!-- lock screen -->
<?php (new FileCaller)->FileIncluderWithControler(IW_PANEL_FROM_PANEL . 'admin/', 'GlobalPage', 'LockScreen'); ?>
<!-- /lock screen -->

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

<!-- Chart.js -->
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/Chart.js/dist/Chart.min.js"></script>
<!-- jQuery Sparklines -->
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- gauge.js -->
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/gauge.js/dist/gauge.min.js"></script>
<!-- Skycons -->
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/skycons/skycons.js"></script>
<!-- Flot -->
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/Flot/jquery.flot.js"></script>
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/Flot/jquery.flot.pie.js"></script>
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/Flot/jquery.flot.time.js"></script>
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/Flot/jquery.flot.stack.js"></script>
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/Flot/jquery.flot.resize.js"></script>
<!-- Flot plugins -->
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/flot.curvedlines/curvedLines.js"></script>
<!-- DateJS -->
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/DateJS/build/production/date.min.js"></script>
<!-- JQVMap -->
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/jqvmap/dist/jquery.vmap.js"></script>
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>

<!-- Custom Theme Scripts -->
<script src="<?php echo(IW_PANEL_JSON_FROM_PANEL); ?>OnClickAdd.js"></script>
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>build/js/custom.min.js"></script>

<!-- /bootstrap-daterangepicker -->

</body>
</html>

