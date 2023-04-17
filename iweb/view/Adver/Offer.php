<?php
//Offer.php
?>
<!-- Start Offer Area -->
<section class="offer-area  ptb-100 jarallax" style="background-image: url('<?php echo $strImageBanner; ?>')" data-jarallax='{"speed": 0.3}'>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-5 col-md-6">
                <div class="offer-content">
                    <span class="sub-title"><?php echo $objSTWebBanner->Line1; ?></span>
                    <h2><?php echo $objSTWebBanner->Line2; ?></h2>
                    <p><?php echo $objSTWebBanner->Line3; ?></p>
                    <a href="<?php echo $objSTWebBanner->LinkTo; ?>" class="default-btn"><?php echo $objSTWebBanner->BottomCaption; ?></a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Offer Area -->
