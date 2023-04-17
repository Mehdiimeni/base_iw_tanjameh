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
            <h2><?php echo FA_LC["list_ticket"]; ?></h2>
            <ul>
                <li><a href="./"><?php echo FA_LC["home_page"]; ?></a></li>
                <li><?php echo FA_LC["list_ticket"]; ?></li>
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

                    <div class="comments-area">
                        <h3 class="comments-title"><?php echo FA_LC["list_ticket"]; ?></h3>

                        <ol class="comment-list">

                            <?php echo $strTicketAll; ?>
                        </ol>

                        <div class="comment-respond">
                            <h3 class="comment-reply-title"><?php echo FA_LC["ticket_add"]; ?></h3>

                            <form class="comment-form" method="post" action="">
                                <p class="comment-notes">
                                    <span id="email-notes"><?php echo FA_LC["send_ticket_direct_content"]; ?></span>

                                </p>

                                <p class="comment-form-url">
                                    <label><?php echo FA_LC["subject"]; ?>
                                        <span class="required">*</span>
                                    </label>
                                    <input name="TicketSubject"
                                           required="required" type="text" id="TicketSubject"
                                           placeholder="<?php echo FA_LC["subject"]; ?>">
                                </p>
                                <p class="comment-form-comment">
                                    <label><?php echo FA_LC["message"]; ?>
                                        <span class="required">*</span>
                                    </label>
                                    <textarea name="SenderTicket"
                                              placeholder="<?php echo FA_LC["message"]; ?>" id="SenderTicket" cols="45"
                                              rows="5" maxlength="65525" required="required"></textarea>
                                </p>
                                <p class="comment-form-cookies-consent">
                                    <input type="checkbox" value="yes" name="Roll" required="required"
                                           id="Roll">
                                    <label for="Roll"><?php echo FA_LC["i_read_all_roll"]; ?></label>
                                </p>
                                <p class="form-submit">
                                    <button type="submit" name="SubmitM" value="A"
                                            class="submit btn btn-primary"><?php echo FA_LC["send"]; ?></button>
                                </p>
                            </form>
                        </div>
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
