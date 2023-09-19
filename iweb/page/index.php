<?php
require("./iweb/core/code_cacher.php");

$_SESSION['page_name_system'] = 'index';
$codeCacher = new CodeCacher();
$codeKey = $_SESSION['page_name_system'];
$cachedCode = $codeCacher->getCachedCode($codeKey);

if ($cachedCode === false) {
    ob_start();

    (new FileCaller)->FileIncluderWithControler('./iweb', 'temp', 'top');
    (new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'top');
    (new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'nav');
    (new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'menu');
    (new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'mobile_view');
    (new FileCaller)->FileIncluderWithControler('./iweb', 'adver', 'banner_adver_1', '0');
    (new FileCaller)->FileIncluderWithControler('./iweb', 'adver', 'banner_adver_2', '0');
    (new FileCaller)->FileIncluderWithControler('./iweb', 'adver', 'banner_adver_3', '0');
    (new FileCaller)->FileIncluderWithControler('./iweb', 'adver', 'banner_adver_4', '0');
    (new FileCaller)->FileIncluderWithControler('./iweb', 'adver', 'brand_box', '0');
    (new FileCaller)->FileIncluderWithControler('./iweb', 'adver', 'trend_categories', '0');
    (new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'newsletter', '0');
    (new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'footer');
    (new FileCaller)->FileIncluderWithControler('./iweb', 'temp', 'down');

    $codeContent = ob_get_clean();
    $codeCacher->cacheCode($codeKey, $codeContent);
    $cachedCode = $codeCacher->getCachedCode($codeKey);

    echo $cachedCode;
} else {
    echo $cachedCode;
}
