<?php
//web index 

$_SESSION['page_name_system'] = 'checkout_confirm';

(new FileCaller)->FileIncluderWithControler('./iweb', 'temp', 'top_checkou');
(new FileCaller)->FileIncluderWithControler('./iweb', 'user', 'checkout_confirm', '0');
(new FileCaller)->FileIncluderWithControler('./iweb', 'temp', 'down_checkou');