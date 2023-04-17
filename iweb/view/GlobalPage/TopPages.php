<?php
//TopPages

(new MakeDirectory)->MKDir(IW_REPOSITORY_FROM_PANEL . 'log/login/', 'user', 0755);

$objGlobalVar = new GlobalVarTools();
$UserIdKey = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserIdKey'));
$objACL = new ACLTools();

if ($objGlobalVar->JsonDecode($objGlobalVar->ServerVarToJson())->HTTP_HOST == 'localhost')
    error_reporting(E_ALL);

require_once IW_DEFINE_FROM_PANEL . 'conf/tablename.php';
require_once IW_DEFINE_FROM_PANEL . 'conf/viewname.php';
require_once IW_DEFINE_FROM_PANEL . 'conf/functionname.php';
require_once IW_DEFINE_FROM_PANEL . 'conf/procedurename.php';

$objIpanelViewUnity = new IPanelViewUnity(FA_LC["IW"], FA_LC["IW"], IW_PANEL_THEME_FROM_PANEL . 'build/icon/', $objInitTools->getLanguageDirection(), $objInitTools->getLang(), $objInitTools->getLanguageDirection(), FA_LC["iwweb_page_title"]);

?>

<!DOCTYPE html>
<?php echo $objIpanelViewUnity->tagHtmlPart(); ?>
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="enamad" content="273338"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php echo $objIpanelViewUnity->tagFavicon(FA_LC["theme_color"], FA_LC["tile_color"]); ?>
    <?php echo $objIpanelViewUnity->tagTitlePart(); ?>

    <!-- Links of CSS files -->
    <link rel="stylesheet" href="<?php echo(IW_WEB_THEME_FROM_PANEL); ?>assets/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="<?php echo(IW_WEB_THEME_FROM_PANEL); ?>assets/css/animate.min.css">
    <link rel="stylesheet" href="<?php echo(IW_WEB_THEME_FROM_PANEL); ?>assets/css/boxicons.min.css">
    <link rel="stylesheet" href="<?php echo(IW_WEB_THEME_FROM_PANEL); ?>assets/css/flaticon.css">
    <link rel="stylesheet" href="<?php echo(IW_WEB_THEME_FROM_PANEL); ?>assets/css/magnific-popup.min.css">
    <link rel="stylesheet" href="<?php echo(IW_WEB_THEME_FROM_PANEL); ?>assets/css/nice-select.min.css">
    <link rel="stylesheet" href="<?php echo(IW_WEB_THEME_FROM_PANEL); ?>assets/css/slick.min.css">
    <link rel="stylesheet" href="<?php echo(IW_WEB_THEME_FROM_PANEL); ?>assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo(IW_WEB_THEME_FROM_PANEL); ?>assets/css/meanmenu.min.css">
    <link rel="stylesheet" href="<?php echo(IW_WEB_THEME_FROM_PANEL); ?>assets/css/rangeSlider.min.css">
    <link rel="stylesheet" href="<?php echo(IW_WEB_THEME_FROM_PANEL); ?>assets/css/style.css">
    <link rel="stylesheet" href="<?php echo(IW_WEB_THEME_FROM_PANEL); ?>assets/css/responsive.css">
    <link rel="stylesheet" href="<?php echo(IW_WEB_THEME_FROM_PANEL); ?>assets/css/rtl.css">
    <link href="<?php echo(IW_PANEL_JSON_FROM_PANEL); ?>jquery-ui.css" rel="stylesheet">


    <link rel="icon" type="image/png" href="<?php echo(IW_WEB_THEME_FROM_PANEL); ?>assets/img/favicon.png">


    <!-- Vendor Styles including: Font Icons, Plugins, etc.-->
    <link rel="stylesheet" media="screen" href="../iwtheme2/vendor/nouislider/dist/nouislider.min.css"/>
    <!-- Main Theme Styles + Bootstrap-->
    <link rel="stylesheet" media="screen" href="../iwtheme2/css/iwtheme.min.css">
    <link rel="stylesheet" media="screen" href="../iwtheme2/css/theme.min.css">
</head>
<body>
<!-- Start Top Header Area -->
<div class="top-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-12">
                <ul class="header-contact-info">
                    <li><a href="./">تن جامه </a></li>
                    <li>تلفن : <a href="tel:02122206812">02122206812</a></li>
                    <li>
                        <div class="dropdown language-switcher d-inline-block">
                            <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                <span>پارسی <i class='bx bx-chevron-down'></i></span>
                            </button>

                            <div class="dropdown-menu">
                                <a href="#" class="dropdown-item d-flex align-items-center">
                                                                       <span>English</span>
                                </a>
                                <a href="#" class="dropdown-item d-flex align-items-center">

                                    <span>العربی</span>
                                </a>

                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="col-lg-6 col-md-12">
                <ul class="header-top-menu">
                    <?php

                    if (@$objACL->NormalUserLogin(IW_REPOSITORY_FROM_PANEL . 'log/login/user/' . $UserIdKey)) {
                        ?>
                        <li><a href="?part=User&page=Login"><i class='bx bx-log-in'></i> <?php echo FA_LC["enter"]; ?>
                            </a></li>
                        <?php
                    } else {
                        ?>
                        <li><a href="?type=usr&act=logout"><i class='bx bx-exit'></i> <?php echo FA_LC["exit"]; ?></a>
                        </li>
                        <li><a href="?part=User&page=Account"><i
                                        class='bx bxs-user'></i> <?php echo FA_LC["my_account"]; ?></a></li>
                        <li><a href="?part=User&page=Shop"><i
                                        class='bx bxs-basket'></i> <?php echo FA_LC["basket"]; ?></a></li>
                        <li><a href="?part=User&page=WishList" data-bs-toggle="modal"
                               data-bs-target="#shoppingWishlistModal"><i
                                        class='bx bx-heart'></i> <?php echo FA_LC["your_wishlist"]; ?></a></li>


                        <?php
                    }

                    ?>


                    <li><a href="?part=User&page=Compare"><i
                                    class='bx bx-shuffle'></i> <?php echo FA_LC["comparison"]; ?></a></li>

                </ul>

                <ul class="header-top-others-option">
                    <div class="option-item">
                        <div class="search-btn-box">
                            <i class="search-btn bx bx-search-alt"></i>
                        </div>
                    </div>

                    <div class="option-item">
                        <div class="cart-btn">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#shoppingCartModal"><i
                                        class='bx bx-shopping-bag'></i><span><?php echo @$intCountAddToCart;?></span></a>
                        </div>
                    </div>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End Top Header Area -->
