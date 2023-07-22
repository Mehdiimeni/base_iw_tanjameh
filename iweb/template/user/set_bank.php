<?php
///template/user/set_bank.php


if ($_GET['bank'] != '' and $_GET['price'] != '' and $_GET['cnu']) {

    if (base64_decode(base64_decode($_GET['cnu'])) == $_GET['price'] . $_GET['bank']) {
        $post_all_data = array(
            'bank' => $_GET['bank'],
            'price' => $_GET['price']
        );

        set_bank($post_all_data);
    }
}
?>
