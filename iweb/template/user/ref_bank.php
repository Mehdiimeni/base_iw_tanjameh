<?php
///template/user/ref_bank.php



if (!isset($_POST['Status'])) {
    JavaTools::JsAlertWithRefresh(_LANG['bank_do_not_response'], 0, './?user=checkout_confirm');
    exit();
} else {

    if ($_POST['Status'] == 1) {
        JavaTools::JsAlertWithRefresh(_LANG['canceled_by_user__1'], 0, './?user=checkout_confirm');
        exit();
    }

    if ($_POST['Status'] == 3) {
        JavaTools::JsAlertWithRefresh(_LANG['payment_not_ok__3'], 0, './?user=checkout_confirm');
        exit();
    }
    if ($_POST['Status'] == 4) {
        JavaTools::JsAlertWithRefresh(_LANG['payment_not_send__4'], 0, './?user=checkout_confirm');
        exit();
    }
    if ($_POST['Status'] == 5) {
        JavaTools::JsAlertWithRefresh(_LANG['invalid_parameters__5'], 0, './?user=checkout_confirm');
        exit();
    }
}

if ($_POST['Status'] == 2) {

    $retun_bank_data = array(
        'ResitId' => $_POST['MID'],
        'State' => $_POST['State'],
        'Status' => $_POST['Status'],
        'RRN' => $_POST['Rrn'],
        'Token' => $_POST['Token'],
        'RefNum' => $_POST['RefNum'],
        'ResNum' => $_POST['ResNum'],
        'TerminalId' => $_POST['TerminalId'],
        'TraceNo' => $_POST['TraceNo'],
        'Amount' => $_POST['Amount'],
        'Wage' => $_POST['Wage'],
        'SecurePan' => $_POST['SecurePan'],
        'HashedCardNumber' => $_POST['HashedCardNumber'],
        'BankName' => $_GET['bank'],
        'Sec' => $_GET['Sec'],
        'UserAddressId' => $_GET['AddId'],
        'secUID' => $_GET['SU'],
        'AmountRial' => base64_decode(base64_decode($_GET['Sec'])),
        'R' => $_GET['R'],
        'iw_company_id' => 1,
    );

    $setpayment_result = set_payment($retun_bank_data);


    if ($setpayment_result->stat == false and $setpayment_result->code == 1) {
        JavaTools::JsAlertWithRefresh(_LANG['res_number_not_equal'] . '. ' . _LANG['payment_return_message'], 0, './?user=checkout_confirm');
        exit();

    }

    if ($setpayment_result->stat == false and $setpayment_result->code == 2) {
        JavaTools::JsAlertWithRefresh(_LANG['payment_not_correct'] . '. ' . _LANG['payment_return_message'], 0, './?user=checkout_confirm');
        exit();

    }

    if ($setpayment_result->stat == false and $setpayment_result->code == 3) {
        JavaTools::JsAlertWithRefresh(_LANG['payment_add_before'] . '. ' . _LANG['payment_return_message'], 0, './?user=checkout_confirm');
        exit();
    }

    if ($setpayment_result->stat == false and $setpayment_result->code == 4) {
        JavaTools::JsAlertWithRefresh(_LANG['user_data_error'] . '. ' . _LANG['payment_return_message'], 0, './?user=exit');
        exit();
    }

    if ($setpayment_result->stat == false and $setpayment_result->code == 5) {
        JavaTools::JsAlertWithRefresh(_LANG['user_data_error'] . '. ' . _LANG['payment_return_message'], 0, './?user=exit');
        exit();
    }

    if ($setpayment_result->stat == false and $setpayment_result->code == 6) {
        JavaTools::JsAlertWithRefresh(_LANG['user_data_error'] . '. ' . _LANG['user_need_login'], 0, './?user=login');
        exit();
    }

    if ($setpayment_result->stat == true and $setpayment_result->code == 1) {
        JavaTools::JsAlertWithRefresh(_LANG['payment_ok__2'] . '. ' . _LANG['tanks_for_shopping'], 0, './?user=myaccount-orders');
        exit();
    }
}

?>