<?php
//IconTools.php
$arrToolsIcon = array();
$arrToolsIcon["edit"] = array('btn-primary', 'fa-pencil-square-o', FA_LC["edit"], $objGlobalVar->setGetVar('modify', 'edit', array('act', 'list')));
$arrToolsIcon["active"] = array('btn-success', 'fa-unlock-alt', FA_LC["active"], $objGlobalVar->setGetVar('act', 'inactive', array('modify', 'list')));
$arrToolsIcon["delete"] = array('btn-danger', 'fa-trash-o', FA_LC["delete"], $objGlobalVar->setGetVar('act', 'del', array('modify', 'list')));
$arrToolsIcon["move"] = array('btn-default', 'fa-refresh', FA_LC["move"], $objGlobalVar->setGetVar('act', 'move', array('modify', 'list')));
$arrToolsIcon["inactive"] = array('btn-danger', 'fa-lock', FA_LC["inactive"], $objGlobalVar->setGetVar('act', 'active', array('modify', 'list')));
$arrToolsIcon["list"] = array('btn-default', 'fa-bars', FA_LC["list"], $objGlobalVar->setGetVar('', '', array('modify', 'act', 'list','ref')));
$arrToolsIcon["add"] = array('btn-primary', 'fa-plus-square', FA_LC["add"], $objGlobalVar->setGetVar('modify', 'add', array('act', 'list','ref')));
$arrToolsIcon["truncate"] = array('btn-danger', 'fa-trash-o', FA_LC["truncate"], $objGlobalVar->setGetVar('act', 'truncate', array('modify', 'list','ref')));
$arrToolsIcon["movein"] = array('btn-info', 'fa-mail-reply', FA_LC["move_selected_item"], $objGlobalVar->setGetVar('act', 'movein', array('modify', 'list')));
$arrToolsIcon["moveout"] = array('btn-warning', 'fa-mail-forward', FA_LC["move_selected_item"], $objGlobalVar->setGetVar('act', 'moveout', array('modify', 'list')));
$arrToolsIcon["closemove"] = array('btn-default', 'fa-close', FA_LC["close"], $objGlobalVar->setGetVar('act', 'closemove', array('modify', 'list','act')));
$arrToolsIcon["view"] = array('btn-warning', 'fa-eye', FA_LC["view"], $objGlobalVar->setGetVar('modify', 'view', array('act', 'list','ref')));
$arrToolsIcon["reverse"] = array('btn-warning', 'fa-share-square-o', FA_LC["reverse"], $objGlobalVar->setGetVar('act', 'reverse', array('modify', 'list')));
$arrToolsIcon["reverse_basket"] = array('btn-warning', 'fa-share-square', FA_LC["reverse"], $objGlobalVar->setGetVar('act', 'reverse_basket', array('modify', 'list')));
//API
$arrToolsIcon["activeapi"] = array('btn-success', 'fa-unlock-alt', FA_LC["active"], $objGlobalVar->setGetVar('act', 'inactiveapi', array('modify', 'list')));
$arrToolsIcon["inactiveapi"] = array('btn-danger', 'fa-lock', FA_LC["inactive"], $objGlobalVar->setGetVar('act', 'activeapi', array('modify', 'list')));

