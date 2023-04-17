<?php
//First3.php
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
                    <a href="./" class="site_title"> <span><?php echo FA_LC["iwuser_page_title"]; ?></span></a>
                </div>

                <div class="clearfix"></div>

                <!-- menu profile quick info -->
                <?php (new FileCaller)->FileIncluderWithControler(IW_PANEL_FROM_PANEL . 'user/', 'GlobalPage', 'MenuProfileQuickInfo'); ?>
                <!-- /menu profile quick info -->

                <br/>

                <!-- sidebar menu -->
                <?php (new FileCaller)->FileIncluderWithControler(IW_PANEL_FROM_PANEL . 'user/', 'GlobalPage', 'SiderbarMenu'); ?>
                <!-- /sidebar menu -->

                <!-- /menu footer buttons -->
                <?php (new FileCaller)->FileIncluderWithControler(IW_PANEL_FROM_PANEL . 'user/', 'GlobalPage', 'MenuFooterButtons'); ?>

                <!-- /menu footer buttons -->
            </div>
        </div>

        <!-- top navigation -->
        <?php (new FileCaller)->FileIncluderWithControler(IW_PANEL_FROM_PANEL . 'user/', 'GlobalPage', 'TopNavigation'); ?>
        <!-- /top navigation -->
        <!-- /header content -->

        <!-- page content -->
        <div class="right_col" role="main">
            <div class="">
                <div class="col-lg-4 col-md-4 col-xs-12 ">
                    <div class="x_panel fixed_height_390">
                        <div class="x_content">


                            <h3 class="name"><?php echo $stdProfile->Name; ?></h3>

                            <div class="flex">
                                <ul class="list-inline count2">

                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target=".bs-example-modal-sm"><?php echo FA_LC["view_card_info"]; ?>
                                    </button>

                                    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog"
                                         aria-hidden="true">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close"><span
                                                                aria-hidden="true">×</span>
                                                    </button>
                                                    <h4 class="modal-title"
                                                        id="myModalLabel2"><?php echo FA_LC["view_card_info"]; ?></h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p><b><?php echo($arrUserCardInfo["CardNumber"]); ?></b></p>
                                                    <p><?php echo("CVV2 : " . $arrUserCardInfo["CVV2"]); ?></p>
                                                    <p><?php echo(FA_LC["expire_date"] . " : " . $arrUserCardInfo["ExpireDate"]); ?></p>
                                                    <p><?php echo(FA_LC["secondary_pin"] . " : " . $arrUserCardInfo["SecondaryPin"]); ?></p>
                                                    <p><?php echo(FA_LC["balance"] . " : " . number_format($arrUserCardInfo["Balance"],0)); ?></p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default"
                                                            data-dismiss="modal"><?php echo FA_LC["close"]; ?></button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </ul>
                            </div>
                            <div class="row top_tiles">
                                <div class="animated flipInY col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="tile-stats">
                                        <div class="icon"><i class="fa fa-empire"></i></div>
                                        <div class="count"><?php echo($arrState['Point']); ?></div>
                                        <h3><?php echo FA_LC["score_value"]; ?></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="row top_tiles">
                                <div class="animated flipInY col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="tile-stats">
                                        <div class="icon"><i class="fa fa-trophy"></i></div>
                                        <div class="count"><?php echo number_format($arrState['BillWage'], 0) ?></div>
                                        <h3><?php echo FA_LC["bill_wage"]; ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-10 col-xs-12 ">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2><?php echo FA_LC["user_level"]; ?>
                            </h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>

                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <div class="bs-example" data-example-id="simple-jumbotron">
                                <div class="jumbotron">
                                    <h1> <?php echo FA_LC["hello"]; ?><?php echo $stdProfile->Name; ?> </h1>
                                    <?php if ($strNewUser) { ?>
                                        <p><?php echo FA_LC["add_card_tip"]; ?> </p>
                                    <?php } else { ?>
                                        <p><?php echo FA_LC["user_welcome1"]; ?><?php echo $strUserGroupName; ?><?php echo FA_LC["user_welcome2"]; ?></p>
                                    <?php } ?>
                                    <marquee direction="right" class="marqueenews-content">
                                        <h5><?php echo $strMarquee; ?></h5>
                                    </marquee>
                                </div>


                            </div>



                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>

            <?php if ($arrAllTrade != null) { ?>
                <div class="">
                    <div class="row top_tiles" id="tradeViewPart">
                        <div id="trade"></div>
                        <?php //echo($strTradePosition); ?>
                        <div class="clearfix"></div>

                    </div>
                </div>
            <?php } ?>

            <div class="">
                <div class="row top_tiles">
                    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                            <div class="icon"><i class="fa fa-sign-out"></i></div>
                            <div class="count"><?php echo $stdProfile->CountEnter ?></div>
                            <h3><?php echo FA_LC["count_enter"]; ?></h3>
                        </div>
                    </div>
                    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                            <div class="icon"><i class="fa fa-barcode"></i></div>
                            <div class="count"><?php echo($arrState['CountOfBill']); ?></div>
                            <h3><?php echo FA_LC["count_pay_bill"]; ?></h3>

                        </div>
                    </div>
                    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                            <div class="icon"><i class="fa fa-mobile"></i></div>
                            <div class="count"><?php echo($arrState['CountOfPin']); ?></div>
                            <h3><?php echo FA_LC["count_buy_pin"]; ?></h3>
                        </div>
                    </div>
                    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                            <div class="icon"><i class="fa fa-money"></i></div>
                            <div class="count"><?php echo(number_format($arrState['Credit'], 0)); ?></div>
                            <h3><?php echo FA_LC["your_account"]; ?></h3>
                        </div>
                    </div>

                </div>


            </div>

            <div class="">


                <div class="clearfix"></div>

                <div class="row">


                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2><?php echo FA_LC["status_chart"]; ?>
                                </h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>

                                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <canvas id="canvasRadar"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2><?php echo FA_LC["club_percentage"]; ?>

                                </h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>

                                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <canvas id="polarArea"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2> <?php echo FA_LC["score_value"]; ?>

                                </h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>

                                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <canvas id="pieChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <br/>
            </div>

        </div>


        <!-- /page content -->


        <!-- footer content -->
        <?php (new FileCaller)->FileIncluderWithControler(IW_PANEL_FROM_PANEL . 'user/', 'GlobalPage', 'FooterContent'); ?>
        <!-- /footer content -->
    </div>
</div>
<!-- lock screen -->
<?php (new FileCaller)->FileIncluderWithControler(IW_PANEL_FROM_PANEL . 'user/', 'GlobalPage', 'LockScreen'); ?>
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
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>build/js/custom.min.js"></script>
<script>
    if ($("#pieChart").length) {
        var e = document.getElementById("pieChart"), a = {
            datasets: [{
                data: [200, 150, 300, 500],
                backgroundColor: [ "#9B59B6", "#BDC3C7", "#26B99A", "#3498DB"],
                label: "My dataset"
            }], labels: [ "برنز", "سیلور", "گلدن", "پلاتین"]
        };
        new Chart(e, {data: a, type: "pie", otpions: {legend: !1}})
    }

</script>
<!-- /bootstrap-daterangepicker -->
<script>
    setInterval(function () {
        ajaxQuery();
    }, 10000);

    function ajaxQuery() {
        // some stuff inside here to perform call
        $.ajax({
            url: "<?php echo IW_PANEL_JSON_FROM_PANEL . 'SignalView.php' ?>",


            success: function (data) {
                console.log(data);
                $('#tradeViewPart').remove().end();
                $('#trade').append(data);
            }

        });


    }
</script>

</body>
</html>

