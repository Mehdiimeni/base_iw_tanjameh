<?php


class  SamanPayment extends ACLTools
{

    private $TerminalId;
    private $RedirectUrl;
    private $PasargadToken;

    public function __construct($secUId)
    {
        $this->TerminalId = '13113817';
        $this->RedirectUrl = 'https://tanjameh.com/iweb/index.php?part=Payment&BankName=Saman&page=RefBank&SU='.$secUId.'&R=';
    }


    public function getToken($Amount, $ResNum, $AddressId, $UserCellNumber = null): string
    {
        $SecAmount = $this->en2Base64($Amount,1);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://sep.shaparak.ir/onlinepg/onlinepg',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{ "action":"token",
            "TerminalId":"' . $this->TerminalId . '",
            "Amount":' . $Amount . ',
            "ResNum":"' . $ResNum . '",
            "RedirectUrl":"' . $this->RedirectUrl . $ResNum .'&AddId='.$AddressId. '&Sec='.$SecAmount.'",
            "CellNumber":"' . $UserCellNumber . '"
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Cookie: ASP.NET_SessionId=svnqaednbat04ryew3c3g12i; SEP01edab9f=017cb00b007ef42d4d6265488e1d8268d81896b0aaefe85cc6f6e7343a173d2bdb4e19c4e10be6b6ab23e9ec630994bfafe0bd93a90598647336a57e8c1818421afd3280c4e9fffeee2135bc59d8aea8409111d80d; __RequestVerificationToken_L09ubGluZVBH0=A70HKYt0uZHyojhob7jSrYfZCLgJCyIBiDv7deP-Nnne14IPY5h1LfZfThuAU95jol9becX60552KvfctJNFKUIgGclx3nnLkhkv4SS7GEg1'
            ),
        ));

        $response = curl_exec($curl);
        $arrResponse = $this->JsonDecodeArray($response);
        curl_close($curl);
        return $arrResponse['token'];

    }

    /**
     * @return mixed
     */
    public function sendToBank($Amount, $ResNum, $AddressId, $UserCellNumber = null)
    {
        $strToken = $this->getToken($Amount, $ResNum, $AddressId, $UserCellNumber = null);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://sep.shaparak.ir/OnlinePG/SendToken',
            CURLOPT_URL => 'https://sep.shaparak.ir/OnlinePG/SendToken?token=' . $strToken,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_POSTFIELDS => '{"token":"' . $strToken . '",
            "GetMethod":""
            }',

            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Cookie: ASP.NET_SessionId=svnqaednbat04ryew3c3g12i; SEP01edab9f=017cb00b007ef42d4d6265488e1d8268d81896b0aaefe85cc6f6e7343a173d2bdb4e19c4e10be6b6ab23e9ec630994bfafe0bd93a90598647336a57e8c1818421afd3280c4e9fffeee2135bc59d8aea8409111d80d; __RequestVerificationToken_L09ubGluZVBH0=A70HKYt0uZHyojhob7jSrYfZCLgJCyIBiDv7deP-Nnne14IPY5h1LfZfThuAU95jol9becX60552KvfctJNFKUIgGclx3nnLkhkv4SS7GEg1'
            ),

        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;

    }

    /**
     * @return mixed
     */
    public function ReverseTransaction($RefNum)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://sep.shaparak.ir/verifyTxnRandomSessionkey/ipg/ReverseTransaction',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{ 
            "RefNum":"' . $RefNum . '",
            "TerminalNumber":' . $this->TerminalId . '
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Cookie: ASP.NET_SessionId=svnqaednbat04ryew3c3g12i; SEP01edab9f=017cb00b007ef42d4d6265488e1d8268d81896b0aaefe85cc6f6e7343a173d2bdb4e19c4e10be6b6ab23e9ec630994bfafe0bd93a90598647336a57e8c1818421afd3280c4e9fffeee2135bc59d8aea8409111d80d; __RequestVerificationToken_L09ubGluZVBH0=A70HKYt0uZHyojhob7jSrYfZCLgJCyIBiDv7deP-Nnne14IPY5h1LfZfThuAU95jol9becX60552KvfctJNFKUIgGclx3nnLkhkv4SS7GEg1'
            ),
        ));


        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    public function VerifyTransaction($RefNum)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://sep.shaparak.ir/verifyTxnRandomSessionkey/ipg/VerifyTransaction',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{ 
            "RefNum":"' . $RefNum . '",
            "TerminalNumber":' . $this->TerminalId . '
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Cookie: ASP.NET_SessionId=svnqaednbat04ryew3c3g12i; SEP01edab9f=017cb00b007ef42d4d6265488e1d8268d81896b0aaefe85cc6f6e7343a173d2bdb4e19c4e10be6b6ab23e9ec630994bfafe0bd93a90598647336a57e8c1818421afd3280c4e9fffeee2135bc59d8aea8409111d80d; __RequestVerificationToken_L09ubGluZVBH0=A70HKYt0uZHyojhob7jSrYfZCLgJCyIBiDv7deP-Nnne14IPY5h1LfZfThuAU95jol9becX60552KvfctJNFKUIgGclx3nnLkhkv4SS7GEg1'
            ),
        ));


        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }


}