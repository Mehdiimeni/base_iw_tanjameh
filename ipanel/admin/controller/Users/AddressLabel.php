<?php
//AddressLabel.php
require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
include IW_ASSETS_FROM_PANEL . "include/IconTools.php";

$objGlobalVar = new GlobalVarTools();
$Enabled = true;
$user_id = $_GET['id'];

$stdProfile = $objORM->Fetch( "id = $user_id  ", '*', TableIWUser);


$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->setCreator('Tanjameh.com');
$pdf->setAuthor('Tanjameh ltd.');
$pdf->setTitle($stdProfile->Name);
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

//Addresses

$SCondition = " iw_user_id = $user_id  ";
foreach ($objORM->FetchAll($SCondition, 'iw_user_address_details_id', TableIWUserAddress) as $ListItem) {

    $strAdresses = '';
    $SCondition = " id = $ListItem->iw_user_address_details_id  ";
    $obj_AddressDetails = $objORM->Fetch($SCondition, '*', TableIWUserAddressDetails);

    $country_name = $objORM->Fetch("id = $obj_AddressDetails->iw_country_id","Name", TableIWACountry)->Name;

    $strAdresses .= '
<p  align="center" dir="RTL" style="text-align:center;direction:
rtl;unicode-bidi:embed"><b><span lang="FA-IR" style="font-size:16.0pt;line-height:
107%;font-family:Vazir">' . $stdProfile->Name . '</span></b></p>

<p  align="center" dir="RTL" style="text-align:center;direction:
rtl;unicode-bidi:embed"><b><span lang="EN-GB" dir="LTR" style="font-size:16.0pt;
line-height:107%;font-family:Vazir">&nbsp;</span></b></p>

<p  align="center" dir="RTL" style="text-align:center;direction:
rtl;unicode-bidi:embed"><b><span lang="FA-IR" style="font-size:16.0pt;line-height:
107%;font-family:Vazir">' . $obj_AddressDetails->Address . '</span></b></p>

<p  align="center" dir="RTL" style="text-align:center;direction:
rtl;unicode-bidi:embed"><b><span lang="FA-IR" style="font-size:16.0pt;line-height:
107%;font-family:Vazir">' . FA_LC['tel'] . ' : ' . $obj_AddressDetails->OtherTel . '</span></b></p>

<p  align="center" dir="RTL" style="text-align:center;direction:
rtl;unicode-bidi:embed"><b><span lang="FA-IR" style="font-size:16.0pt;line-height:
107%;font-family:Vazir">' . FA_LC['mobile'] . ' : ' . $obj_AddressDetails->OtherTel . '</span></b></p>

<p  align="center" dir="RTL" style="text-align:center;direction:
rtl;unicode-bidi:embed"><b><span lang="FA-IR" style="font-size:16.0pt;line-height:
107%;font-family:Vazir">' . FA_LC['post_code'] . ' : ' . $stdProfile->CellNumber . '</span></b></p>

<p  align="center" dir="RTL" style="text-align:center;direction:
rtl;unicode-bidi:embed"><b><span dir="LTR" style="font-size:40.0pt;line-height:
107%;font-family:Vazir">' . $country_name . '</span></b></p>
';

    $pdf->AddPage('P', 'A6');
    $pdf->WriteHTML($strAdresses, true, 0, true, 0);
}
// add a page


// print a block of text using Write()
//$pdf->Write(0, $strAdresses, '', 0, 'C', true, 0, false, false, 0);

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output($stdProfile->Name . '-Address.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+


