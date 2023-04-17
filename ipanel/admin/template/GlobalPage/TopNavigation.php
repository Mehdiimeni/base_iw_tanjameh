<?php
///template/GlobalPage/TopNavigation.php
?>


<div class="nav_menu">
    <nav>
        <div class="nav toggle">
            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
        </div>

        <ul class="nav navbar-nav navbar-right">
            <li class="">
                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                    aria-expanded="false">
                    <?php echo $AdminProfileImage; ?><?php echo $stdProfile->Name; ?>
                    <span class=" fa fa-angle-down"></span>
                </a>
                <ul class="dropdown-menu dropdown-usermenu pull-right">

                    <li><a title="<?php echo FA_LC["exit"]; ?>" href="<?php echo $objGlobalVar->setGetVar('type', 'adm');
                       echo $objGlobalVar->setGetVar('act', 'logout'); ?>"><i
                                class="fa fa-sign-out pull-right"></i>
                            <?php echo FA_LC['exit']; ?>
                        </a></li>

                </ul>
            </li>

            <li role="presentation" class="dropdown">
                <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-envelope-o"></i>
                    <span class="badge bg-green">
                        <?php echo $intCountAllTicket; ?>
                    </span>
                </a>
                <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">

                    <?php echo $strNewTicket; ?>
                    <li>
                        <div class="text-center">
                            <a href="?ln=&part=Ticket&page=UserTicket">
                                <strong>
                                    <?php echo FA_LC["show_all"]; ?>
                                </strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </div>
                    </li>

                </ul>
            </li>
            <li>
                <a href="?ln=&part=UserBasket&page=AllBasket" class="dropdown-toggle info-number">
                    <i class="fa fa-shopping-basket"></i>
                    <span class="badge bg-green">
                        <?php echo $intCountAllShop; ?>
                    </span>
                </a>

            </li>

            <li>
                <a href="?ln=" class="dropdown-toggle info-number">
                    <i class="fa fa-home"></i>
                </a>

            </li>

        </ul>
    </nav>
</div>
</div>