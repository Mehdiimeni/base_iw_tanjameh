<?php
//Checkout.php
include IW_ASSETS_FROM_PANEL . "include/PageUnity.php";
include "./view/GlobalPage/TopPages.php";
include "./controller/GlobalPage/MenuPart.php";
?>
    <!-- Start Page Title -->
    <div class="page-title-area">
        <div class="container">
            <div class="page-title-content">
                <h2><?php echo(FA_LC["proceed_to_checkout"]); ?></h2>
                <ul>
                    <li><a href="./"><?php echo FA_LC["home_page"]; ?></a></li>
                    <li><?php echo(FA_LC["proceed_to_checkout"]); ?></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- End Page Title -->

    <!-- Start Checkout Area -->
    <section class="checkout-area ptb-100">
        <div class="container">

            <form>
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="billing-details">
                            <h3 class="title"><?php echo(FA_LC["select_address"]); ?></h3>

                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label><?php echo(FA_LC["address"]); ?> <span
                                                    class="required">*</span></label>
                                        <?php if ($boolAddress) { ?>
                                            <div class="select-box">
                                                <select id="SelectAddress" class="form-control">
                                                    <?php echo $strAdrresses; ?>
                                                </select>
                                            </div>
                                        <?php } else { ?>
                                            <a href="?part=User&page=Address"><?php echo FA_LC["must_have_one_address"]; ?></a>
                                        <?php } ?>
                                    </div>


                                </div>

                                <section class="widget widget_xton_posts_thumb">
                                    <h3 class="widget-title"><a href="?part=User&page=Address"><i class="fa fa-plus"
                                                                                                  aria-hidden="true"></i> <?php echo FA_LC["add_address"]; ?>
                                        </a></h3>
                                </section>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-12">
                        <div class="order-details">
                            <?php if ($objUserAddressInfo->IdKey != null) { ?>
                                <div class="col-lg-12 col-md-12">
                                    <h5 class="title"><?php echo(FA_LC["send_address"]); ?></h5>
                                    <div class="order-table table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th scope="col"><?php echo($objUserAddressInfo->NicName . ' : '); ?></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td class="total-price">
                                                    <span><?php echo($objUserAddressInfo->Address); ?></span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>

                                    </div>

                                </div>

                                <br>
                            <?php } ?>
                            <h3 class="title"><?php echo(FA_LC["billing_details"]); ?></h3>

                            <div class="order-table table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th scope="col"><?php echo(FA_LC["product"]); ?></th>
                                        <th scope="col"
                                            style="margin:5px; padding:5px; text-align: center; "><?php echo(FA_LC["size"]); ?></th>
                                        <th scope="col"
                                            style="margin:5px; padding:5px; text-align: center; "><?php echo(FA_LC["quantity"]); ?></th>
                                        <th scope="col"
                                            style="margin:5px; padding:5px; text-align: center; "><?php echo(FA_LC["total_count"]); ?></th>
                                    </tr>
                                    </thead>

                                    <tbody>

                                    <?php echo $strProductsFactor; ?>
                                    <tr>
                                        <td class="total-price">
                                            <span><?php echo(FA_LC["sub_total"]); ?></span>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td class="product-subtotal"
                                            style="margin:5px; padding:5px; text-align: center; ">
                                            <span class="subtotal-amount"><?php echo($intTotalPrice); ?></span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="total-price">
                                            <span><?php echo(FA_LC["shipping"]); ?></span>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td class="product-subtotal"
                                            style="margin:5px; padding:5px; text-align: center; ">
                                            <span class="subtotal-amount"><?php echo($intTotalShipping); ?></span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="total-price">
                                            <span><?php echo(FA_LC["pack_number"]); ?></span>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td class="product-subtotal"
                                            style="margin:5px; padding:5px; text-align: center; ">
                                            <span class="subtotal-amount"><?php echo($intPackcount); ?></span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="total-price">
                                            <span><?php echo(FA_LC["total_count"]); ?></span>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td class="product-subtotal"
                                            style="margin:5px; padding:5px; text-align: center; ">
                                            <span class="subtotal-amount"><?php echo($intTotalPriceShipping); ?></span>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="payment-box">
                                <div class="payment-method">
                                    <p>
                                        <input type="radio" id="direct-bank-transfer" name="radio-group" checked>
                                        <label for="direct-bank-transfer"><?php echo FA_LC["direct_bank_transfer"]; ?></label>
                                    </p>


                                </div>
                                <?php if ($boolGotoBank and ($intTotalPriceShippingEn < 50000000)) { ?>
                                    <a href="?part=Payment&page=SetBank&Value=<?php echo $intTotalPriceShippingEn; ?>&BankName=saman&AddId=<?php echo $_GET['AddId']; ?>"
                                       class="default-btn"><?php echo FA_LC["payment"]; ?></a>
                                <?php }
                                if (($intTotalPriceShippingEn > 50000000))
                                    echo FA_LC["price_over_pay"];

                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </section>
<?php
include "./view/GlobalPage/FooterArea.php";
?>