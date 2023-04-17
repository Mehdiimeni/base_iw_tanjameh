<?php
//Invocie.php
include IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
include IW_ASSETS_FROM_PANEL . "include/IconTools.php";

$objGlobalVar = new GlobalVarTools();
$Enabled = BoolEnum::BOOL_TRUE();
$BasketIdKey = $_GET['BasketIdKey'];
$PaymentIdKey = $_GET['PaymentIdKey'];


$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
$objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
$objShowFile->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');

$objStorageTools = new StorageTools($objFileToolsInit->KeyValueFileReader()['MainName']);
$objStorageTools->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');


$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->setCreator('Tanjameh.com');
$pdf->setAuthor('Tanjameh ltd.');
$pdf->setTitle($BasketIdKey);
$pdf->setSubject('Tanjameh');
$pdf->setKeywords('Tanjameh , shop');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->setDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->setMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

// set auto page breaks
$pdf->setAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language dependent data:
$lg = array();
$lg['a_meta_charset'] = 'UTF-8';
$lg['a_meta_dir'] = 'rtl';
$lg['a_meta_language'] = 'fa';
$lg['w_page'] = 'page';

// set some language-dependent strings (optional)
$pdf->setLanguageArray($lg);


// ---------------------------------------------------------

// set font
$pdf->SetFont('dejavusans', '', 12);

//Invocie
$SCondition = " PaymentIdKey = '$PaymentIdKey' and  BasketIdKey = '$BasketIdKey' ";
foreach ($objORM->FetchAll($SCondition, '*', TableIWAUserInvoice) as $UserInvoice) {
    $SCondition = " IdKey = '$UserInvoice->UserAddressIdKey'  ";
    $UserAddress = $objORM->Fetch($SCondition, 'NicName,Address,IdKey', TableIWUserAddress);


    $SCondition = "Enabled = '$Enabled' AND  ProductId = '$UserInvoice->ProductId' ";
    $ListItem = $objORM->Fetch($SCondition, '*', TableIWAPIProducts);

    $objArrayImage = explode('==::==', $ListItem->Content);
    $objArrayImage = array_combine(range(1, count($objArrayImage)), $objArrayImage);

    $intImageCounter = 1;
    foreach ($objArrayImage as $image) {
        if (@strpos($ListItem->ImageSet, (string)$intImageCounter) === false) {

            unset($objArrayImage[$intImageCounter]);
        }
        $intImageCounter++;
    }
    $objArrayImage = array_values($objArrayImage);


    $strProductsFactorFull .= '<tr>';
    $strProductsFactorFull .= '<td class="product-name" width="25%" style="margin:5px; padding:5px; text-align: center; ">';
    $strProductsFactorFull .= $ListItem->Name;
    $strProductsFactorFull .= '</td>';
    $strProductsFactorFull .= '<td class="product-name" style="margin:5px; padding:5px; text-align: center; ">';
    $strProductsFactorFull .= $objShowFile->ShowImage('', $objShowFile->FileLocation("attachedimage"), @$objArrayImage[0], $ListItem->Name, 120, 'class="main-image"');
    $strProductsFactorFull .= '</td>';
    $strProductsFactorFull .= '<td class="product-total" style="margin:5px; padding:5px; text-align: center; ">';
    $strProductsFactorFull .= '<span class="subtotal-amount">' . $UserInvoice->Size . '</span>';
    $strProductsFactorFull .= '</td>';
    $strProductsFactorFull .= '<td class="product-total" style="margin:5px; padding:5px; text-align: center; ">';
    $strProductsFactorFull .= '<span class="subtotal-amount">' . $UserInvoice->ProductId . '</span>';
    $strProductsFactorFull .= '</td>';
    $strProductsFactorFull .= '<td class="product-total" style="margin:5px; padding:5px; text-align: center; ">';
    $strProductsFactorFull .= '<span class="subtotal-amount">' . $UserInvoice->Count . '</span>';
    $strProductsFactorFull .= '</td>';
    $strProductsFactorFull .= '<td class="product-total" style="margin:5px; padding:5px; text-align: center; ">';
    $strProductsFactorFull .= '<span class="subtotal-amount">' . $UserInvoice->ItemPrice . '</span>';
    $strProductsFactorFull .= '</td></tr>';

}

$strInvocie = '<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tbody>
    <tr>
    <td align="right"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tbody>
          <tr>
            <td align="right"><h2 >TANJAMEH</h2></td>
          </tr>
          <tr>
            <td align="right"><img src="' . IW_WEB_THEME_FROM_PANEL . 'assets/img/tanjameh.png" width="100" height="102" alt=""/></td>
          </tr>
        </tbody>
      </table></td>
      <td width="35%" align="right"><table width="100%%" border="0" cellspacing="0" cellpadding="0">
        <tbody>
          <tr>
            <td align="right"><span> ' . FA_LC["invocie"] . '</span> ' . $UserInvoice->IdRow . '</td>
          </tr>
          <tr>
            <td align="right">' . $UserInvoice->SetDate . '</td>
          </tr>
        </tbody>
      </table></td>
      
    </tr>
  </tbody>
</table>

<hr/>

<h5 class="title"> ' . FA_LC["send_address"] . '</h5>
    <table class="table table-bordered">

        <tbody>
        <tr>
            <td class="total-price">
                <span> ' . $UserAddress->Address . '</span>
            </td>
        </tr>
        </tbody>
    </table>

<hr/>
<table class="table table-bordered" style="margin:10px; padding:10px; width: 90%; " border="1">
        <thead>
        <tr>
            <th scope="col" style="margin:5px; padding:5px; text-align: center; " width="25%">' . FA_LC["product"] . '</th>
            <th scope="col" style="margin:5px; padding:5px; text-align: center; ">' . FA_LC["image"] . '</th>
            <th scope="col" style="margin:5px; padding:5px; text-align: center; ">' . FA_LC["size"] . '</th>
            <th scope="col" style="margin:5px; padding:5px; text-align: center; ">' . FA_LC["id"] . '</th>
            <th scope="col" style="margin:5px; padding:5px; text-align: center; ">' . FA_LC["quantity"] . '</th>
            <th scope="col" style="margin:5px; padding:5px; text-align: center; ">' . FA_LC["cart_totals"] . '</th>
        </tr>
        </thead>

        <tbody>

        ' . $strProductsFactorFull . '
        <tr>
            <td class="total-price">
                <span>' . FA_LC["sub_total"] . '</span>
            </td>

            <td class="product-subtotal">
                <span class="subtotal-amount">' . $UserInvoice->TotalPrice . '</span>
            </td>
        </tr>

        <tr>
            <td class="total-price">
                <span>' . FA_LC["shipping"] . '</span>
            </td>

            <td class="product-subtotal">
                <span class="subtotal-amount">' . $UserInvoice->TotalShipping . '</span>
            </td>
        </tr>
        
        <tr>
            <td class="total-price">
                <span>' . FA_LC["pack_number"] . '</span>
            </td>

            <td class="product-subtotal">
                <span class="subtotal-amount">' . $UserInvoice->PackCount . '</span>
            </td>
        </tr>

        <tr>
            <td class="total-price">
                <span>' . FA_LC["total_count"] . '</span>
            </td>

            <td class="product-subtotal">
                <span class="subtotal-amount">' . $UserInvoice->TotalPriceShipping . '</span>
            </td>
        </tr>
        </tbody>
    </table>';

$pdf->AddPage('P', 'A4');
$pdf->WriteHTML($strInvocie, true, 0, true, 0);

// add a page


// print a block of text using Write()
//$pdf->Write(0, $strInvocie, '', 0, 'C', true, 0, false, false, 0);

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output($BasketIdKey . '.pdf', 'I');

?>


