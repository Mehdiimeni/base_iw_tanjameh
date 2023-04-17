<?php
//ModalParts


include "./controller/GlobalPage/ModalParts.php";

?>
<!-- Start Sidebar Modal -->
<div class="modal right fade sidebarModal" id="sidebarModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><i class='bx bx-x'></i></span>
            </button>

            <div class="modal-body">
                <div class="sidebar-about-content">
                    <h3><?php echo FA_LC["about_us"]; ?></h3>

                    <div class="about-the-store">
                        <p>در حال حاضر یکی از بهترین و آسانترین روش های خرید، خرید اینترنتی می باشد که در کشور ما ایران
                            نیز بسیار رواج دارد. با توجه به محدودیت های زیاد برای خرید از سایت های خارجی، بر آن شدیم که
                            با تشکیل گروه تن جامه بخشی از این محدودیت را کاسته و راهی آسان و ایمن را برای خرید مشتریان
                            عزیز به وجود آوریم.
                            در سایت تن جامه محصولات 1.900 برند مختلف و معتبر جهانی اعم از پوشاک ، کیف و کفش ، زیورآلات و
                            ... برای بانوان، آقایان و کودکان قابل مشاهده و سفارش است.

                        <ul class="sidebar-contact-info">
                            <li><i class='bx bx-map'></i> <a href="?part=Contact&page=Contact" target="_blank">ایران -
                                    تهران - خیابان اندرزگو - خیابان سلیمی - ساختمان شماره 2 واحد 126</a>
                            </li>
                            <li><i class='bx bx-phone-call'></i> <a href="tel:02122206812">021-22206812</a></li>
                            <li><i class='bx bx-envelope'></i> <a href="mailto:info@tanjameh.com">info@tanjameh.com</a>
                            </li>
                        </ul>
                    </div>
                    <!--
                                        <ul class="social-link">
                                            <li><a href="#" class="d-block" target="_blank"><i class='bx bxl-facebook'></i></a></li>
                                            <li><a href="#" class="d-block" target="_blank"><i class='bx bxl-twitter'></i></a></li>
                                            <li><a href="#" class="d-block" target="_blank"><i class='bx bxl-instagram'></i></a></li>
                                            <li><a href="#" class="d-block" target="_blank"><i class='bx bxl-linkedin'></i></a></li>
                                            <li><a href="#" class="d-block" target="_blank"><i class='bx bxl-pinterest-alt'></i></a></li>
                                        </ul>
                                        -->
                </div>

            </div>
        </div>
    </div>
</div>


<!-- Start Shopping Cart Modal -->
<div class="modal right fade shoppingCartModal" id="shoppingCartModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><i class='bx bx-x'></i></span>
            </button>

            <div class="modal-body">
                <h3><?php echo FA_LC["basket"]; ?> (<?php echo @$intCountAddToCart ?>)</h3>

                <div class="products-cart-content">
                    <?php echo(@$strProductsCart); ?>
                </div>

                <div class="products-cart-subtotal">
                    <span><?php echo FA_LC["total_count"]; ?></span>
                    <span class="subtotal"><?php echo @$intTotalPrice; ?></span>
                </div>

                <div class="products-cart-btn">
                    <a href="?part=User&page=Shop" class="optional-btn"><?php echo FA_LC["basket"]; ?></a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Shopping Cart Modal -->

<!-- Start Wishlist Modal -->
<div class="modal right fade shoppingWishlistModal" id="shoppingWishlistModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><i class='bx bx-x'></i></span>
            </button>

            <div class="modal-body">
                <h3><?php echo FA_LC["your_wishlist"]; ?> (<?php echo @$intCountWishlist; ?>)</h3>

                <div class="products-cart-content">
                    <?php echo(@$strProductsWishlist); ?>
                </div>

                <div class="products-cart-btn">
                    <a href="?part=User&page=Shop" class="optional-btn"><?php echo(FA_LC["basket"]); ?></a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Wishlist Modal -->
