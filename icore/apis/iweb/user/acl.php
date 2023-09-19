<?php
require_once "../global/CommonInclude.php";

if (file_exists('../../../../irepository/log/login/user/' . $_POST['user_id'])) {
    echo (true);
} else {
    echo (false);
}