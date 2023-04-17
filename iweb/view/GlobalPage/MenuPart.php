<?php
//MenuPart.php

?>

<!-- Start Navbar Area -->
<div class="navbar-area">
    <div class="xton-responsive-nav">
        <div class="container">
            <div class="xton-responsive-menu">
                <div class="logo">
                    <a href="./">
                        <img src="<?php echo(IW_WEB_THEME_FROM_PANEL); ?>assets/img/logo.png" alt="logo">
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="xton-nav">
        <div class="container">
            <nav class="navbar navbar-expand-md navbar-light">
                <a class="navbar-brand" href="./">
                    <img src="<?php echo(IW_WEB_THEME_FROM_PANEL); ?>assets/img/logo.png" alt="logo">
                </a>

                <div class="collapse navbar-collapse mean-menu">
                    <ul class="navbar-nav">

                        <?php echo $MainMenuSite; ?>

                    </ul>

                    <div class="others-option">
                        <div class="option-item">
                            <div class="search-btn-box">
                                <i class="search-btn bx bx-search-alt"></i>
                            </div>
                        </div>
                        <div class="option-item">
                            <div class="cart-btn">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#shoppingCartModal"><i
                                            class='bx bx-shopping-bag'></i><span><?php echo $intCountAddToCart; ?></span></a>
                            </div>
                        </div>
                        <div class="option-item">
                            <div class="burger-menu" data-bs-toggle="modal" data-bs-target="#sidebarModal">
                                <span class="top-bar"></span>
                                <span class="middle-bar"></span>
                                <span class="bottom-bar"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
<!-- End Navbar Area -->
<!-- Start Sticky Navbar Area -->
<div class="navbar-area header-sticky">
    <div class="xton-nav">
        <div class="container">
            <nav class="navbar navbar-expand-md navbar-light">
                <a class="navbar-brand" href="./">
                    <img src="<?php echo(IW_WEB_THEME_FROM_PANEL); ?>assets/img/logo.png" alt="logo">
                </a>

                <div class="collapse navbar-collapse mean-menu">
                    <ul class="navbar-nav">
                        <?php echo $MainMenuSite; ?>
                    </ul>

                    <div class="others-option">
                        <div class="option-item">
                            <div class="search-btn-box">
                                <i class="search-btn bx bx-search-alt"></i>
                            </div>
                        </div>

                        <div class="option-item">
                            <div class="cart-btn">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#shoppingCartModal"><i
                                            class='bx bx-shopping-bag'></i><span><?php echo $intCountAddToCart; ?></span></a>
                            </div>
                        </div>


                        <div class="option-item">
                            <div class="burger-menu" data-bs-toggle="modal" data-bs-target="#sidebarModal">
                                <span class="top-bar"></span>
                                <span class="middle-bar"></span>
                                <span class="bottom-bar"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
<!-- End Header Area -->
<!-- Start Search Overlay -->
<div class="search-overlay">
    <div class="d-table">
        <div class="d-table-cell">
            <div class="search-overlay-layer"></div>
            <div class="search-overlay-close">
                <span class="search-overlay-close-line"></span>
                <span class="search-overlay-close-line"></span>
            </div>

            <div class="search-overlay-form">
                <form method="post" action="?Search=Pro">
                    <input type="text" name="Search" class="input-search" placeholder="<?php echo FA_LC["search"]; ?>">
                    <button type="submit" name="SubmitSearch" value="A"><i class='bx bx-search-alt'></i></button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Search Overlay -->
