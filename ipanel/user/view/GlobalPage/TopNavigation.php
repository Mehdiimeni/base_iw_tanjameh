<?php
//TopNavigation.php
?>
<div class="top_nav hidden-print">
    <div class="nav_menu">
        <nav>
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                <a href="?" id="menu_toggle"><i class="fa fa-home"></i></a>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li class="">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                       aria-expanded="false">
                        <?php echo $UserProfileImage;
                        echo($stdProfile->Name); ?>
                        <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li><a title="<?php echo FA_LC["profile"]; ?>"
                               href="<?php echo '?ln=&part=Users&page=Users&modify=add&ref='.$objGlobalVar->en2Base64($stdProfile->IdKey . '::==::' . TableIWUser, 0); ?>"><i
                                        class="fa fa-user pull-right"></i> <?php echo FA_LC['profile']; ?></a></li>
                        <li><a title="<?php echo FA_LC["ticket"]; ?>"
                               href="<?php echo '?ln=&part=Ticket&page=UserTicket'; ?>"><i
                                        class="fa fa-ticket pull-right"></i> <?php echo FA_LC['ticket']; ?></a></li>
                        <li><a title="<?php echo FA_LC["exit"]; ?>"
                               href="<?php echo $objGlobalVar->setGetVar('type', 'usr');
                               echo $objGlobalVar->setGetVar('act', 'logout'); ?>"><i
                                        class="fa fa-sign-out pull-right"></i> <?php echo FA_LC['exit']; ?></a></li>
                        <li><a title="<?php echo FA_LC["dashboard_help"]; ?>"
                               href=""><i
                                        class="fa fa-question-circle pull-right"></i> <?php echo FA_LC['dashboard_help']; ?></a></li>

                    </ul>
                </li>


            </ul>
            <div class="nav toggle">
                <?php echo((new TimeTools())->jdate("l j F Y")); ?><br/>
                <?php echo((new TimeTools())->jdate("H:i:s")); ?>
            </div>

        </nav>
    </div>
</div>
