<?php 
//web index 

(new FileCaller)->FileIncluderWithControler(dirname(__FILE__,2), 'temp', 'top');
(new FileCaller)->FileIncluderWithControler(dirname(__FILE__,2), 'global', 'top');
(new FileCaller)->FileIncluderWithControler(dirname(__FILE__,2), 'global', 'nav');
(new FileCaller)->FileIncluderWithControler(dirname(__FILE__,2), 'global', 'menu');
(new FileCaller)->FileIncluderWithControler(dirname(__FILE__,2), 'global', 'mobile_view');
(new FileCaller)->FileIncluderWithControler(dirname(__FILE__,2), 'adver', 'banner_adver_1', '0');
(new FileCaller)->FileIncluderWithControler(dirname(__FILE__,2), 'adver', 'banner_adver_2', '0');
(new FileCaller)->FileIncluderWithControler(dirname(__FILE__,2), 'adver', 'user_trase', '0');
(new FileCaller)->FileIncluderWithControler(dirname(__FILE__,2), 'adver', 'banner_adver_3', '0');
(new FileCaller)->FileIncluderWithControler(dirname(__FILE__,2), 'adver', 'user_like', '0');
(new FileCaller)->FileIncluderWithControler(dirname(__FILE__,2), 'adver', 'brand_box', '0');
(new FileCaller)->FileIncluderWithControler(dirname(__FILE__,2), 'adver', 'trend_categories', '0');
(new FileCaller)->FileIncluderWithControler(dirname(__FILE__,2), 'global', 'newsletter', '0');
(new FileCaller)->FileIncluderWithControler(dirname(__FILE__,2), 'global', 'footer');
(new FileCaller)->FileIncluderWithControler(dirname(__FILE__,2), 'temp', 'down');
