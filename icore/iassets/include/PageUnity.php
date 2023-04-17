<?php
$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
$objInitTools = new InitTools($objFileToolsInit->KeyValueFileReader(), IW_REPOSITORY_FROM_PANEL . 'log/error/ipanel/adminerror.log');
$objIpanelViewUnity = new IPanelViewUnity(FA_LC["IW"], FA_LC["IW"], IW_PANEL_THEME_FROM_PANEL . 'build/icon/', $objInitTools->getLanguageDirection(), $objInitTools->getLang(), $objInitTools->getLanguageDirection(), FA_LC["iwadmin_page_title"]);

