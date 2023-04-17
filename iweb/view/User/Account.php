<?php
//Account.php

include IW_ASSETS_FROM_PANEL . "include/PageUnity.php";
include "./view/GlobalPage/TopPages.php";
include "./controller/GlobalPage/MenuPart.php";
?>


<!-- Start Page Title -->
<div class="page-title-area">
    <div class="container">
        <div class="page-title-content">
            <h2><?php echo FA_LC["my_account"]; ?></h2>
            <ul>
                <li><a href="./"><?php echo FA_LC["home_page"]; ?></a></li>
                <li><?php echo FA_LC["my_account"]; ?></li>
            </ul>
        </div>
    </div>
</div>
<!-- End Page Title -->

<!-- Start Blog Details Area -->
<section class="blog-details-area ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12">
                <div class="blog-details-desc">

                    <div class="article-content">


                        <div class="entry-meta">
                            <ul>
                                <li>
                                    <i class='bx bx-folder-open'></i>
                                    <span><?php echo FA_LC["count_property"]; ?></span>
                                    <a href="?part=User&page=ShopList"><?php echo $CountProperty; ?></a>
                                </li>
                                <li>
                                    <i class='bx bx-group'></i>
                                    <span><?php echo FA_LC["count_enter"]; ?></span>
                                    <a href="#"><?php echo $stdProfile->CountEnter; ?></a>
                                </li>
                                <li>
                                    <i class='bx bx-calendar'></i>
                                    <span><?php echo FA_LC["last_admin_login"]; ?></span>
                                    <a href="#"><?php echo $stdProfile->ModifyDate; ?></a>
                                </li>
                            </ul>
                        </div>

                        <div class="article-author">
                            <div class="author-profile-header"></div>
                            <div class="author-profile">
                                <div class="author-profile-title">
                                    <?php echo $strUserProfileImage; ?>

                                    <div class="author-profile-title-details d-flex justify-content-between">
                                        <div class="author-profile-details">
                                            <h4><?php echo($stdProfile->Name); ?></h4>
                                            <span class="d-block"><?php echo(FA_LC["user_type"] . " : " . $strAdminGroupName); ?></span>
                                        </div>

                                    </div>
                                </div>
                                <p><?php echo(FA_LC["address"] . " : ".$strAddressUser); ?></p>
                            </div>
                        </div>

                        <blockquote class="wp-block-quote">
                            <p><?php echo $strMessageToAll; ?></p>

                        </blockquote>

                        <h3><?php echo FA_LC["note"]; ?></h3>

                        <p><?php echo $strNoteToAll; ?></p>

                    </div>

                </div>
            </div>

            <div class="col-lg-4 col-md-12">
                <aside class="widget-area">

                    <section class="widget widget_xton_posts_thumb">
                        <h3 class="widget-title"><a href="?part=User&page=Shop" ><?php echo FA_LC["basket"]; ?></a></h3>

                        <?php echo($strProductsCart); ?>

                    </section>

                    <section class="widget widget_xton_posts_thumb">
                        <h3 class="widget-title"><a href="?part=User&page=WishList" ><?php echo FA_LC["your_wishlist"]; ?></a></h3>
                        <?php echo($strProductsWishlist); ?>
                    </section>

                    <section class="widget widget_xton_posts_thumb">
                        <h3 class="widget-title"><a href="?part=User&page=ShopList" ><?php echo FA_LC["last_buy"]; ?></a></h3>
                        <?php echo($strOldBuylist); ?>
                    </section>
                    <section class="widget widget_xton_posts_thumb">
                        <h3 class="widget-title"><a href="?part=User&page=Profile" ><?php echo FA_LC["profile_info"]; ?></a></h3>
                    </section>
                    <section class="widget widget_xton_posts_thumb">
                        <h3 class="widget-title"><a href="?part=User&page=Address" ><?php echo FA_LC["address"]; ?></a></h3>
                    </section>
                    <section class="widget widget_xton_posts_thumb">
                        <h3 class="widget-title"><a href="?part=User&page=Ticket" ><?php echo FA_LC["ticket"]; ?></a></h3>
                    </section>
                    <section class="widget widget_xton_posts_thumb">
                        <h3 class="widget-title"><a href="#" ><?php echo FA_LC["return_product"]; ?></a></h3>
                    </section>


                    <section class="widget widget_contact">
                        <div class="text">
                            <div class="icon">
                                <i class='bx bx-phone-call'></i>
                            </div>
                            <span><?php echo FA_LC["emergency_call"]; ?></span>
                            <a href="tel:+09821">+09821</a>
                        </div>
                    </section>
                </aside>
            </div>
        </div>
    </div>
</section>
<!-- End Blog Details Area -->

<?php
//include "./controller/Adver/Partner.php";
//include "./view/Adver/Testimonials.php";
//include "./view/Adver/Facility.php";
//include "./view/Adver/Instagram.php";
//include "./view/GlobalPage/ModalParts.php";
include "./view/GlobalPage/FooterArea.php";
?>
