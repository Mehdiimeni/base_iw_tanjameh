<?php
include dirname(__FILE__, 4) . "/iassets/include/DBLoader.php";

if ($objACLTools->NormalLogin(dirname(__FILE__, 5) . '/irepository/log/login/user/' . $_POST['user_idkey'], 'user')) {
    echo (true);
} else {
    echo (false);
}